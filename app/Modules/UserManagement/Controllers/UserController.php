<?php

namespace App\Modules\UserManagement\Controllers;

use App\Core\Http\BaseCrudController;
use App\Modules\UserManagement\DTOs\User\UserDto;
use App\Modules\UserManagement\Mappers\SelectOptionMapper;
use App\Modules\UserManagement\Repositories\Implementations\RoleRepository;
use App\Modules\UserManagement\Requests\user\CreateUpdate;
use App\Modules\UserManagement\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends BaseCrudController
{
    protected string $viewPrefix = "UserManagement::user.";
    protected string $routePrefix = 'user.';
    protected string $entityName = 'User';

    protected $service, $selectOptionMapper;
    protected string $dtoClass = UserDto::class;
    public function __construct(UserServiceInterface $service, SelectOptionMapper $selectOptionMapper)
    {
        $this->service = $service;
        $this->selectOptionMapper = $selectOptionMapper;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', config('UserManagement.user', 10));
        $serachTerm = $request->input('search');

        return $this->dataIndex($perPage, $serachTerm);
    }

    public function create()
    {
        $roles = $this->selectOptionMapper->loadCommonSelectOptions()['roles'];
        return $this->dataCreate(['roles' => $roles]);
    }

    public function store(CreateUpdate $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        $roles = $this->selectOptionMapper->loadCommonSelectOptions()['roles'];
        return $this->dataEdit($id, ['roles' => $roles]);
    }

    public function update(CreateUpdate $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }
    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'users', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }

    public function userProfile()
    {
        $id = $this->service->getCurrentLoginUserId();
        $data['record'] = $this->service->findById($id);
        if (!$data['record']) {
            return false;
        }

        // Add profile image URL for form
        $data['profile_image_url'] = $data['record']->getMediaUrl('profile_image_id');

        return view($this->viewPrefix . 'profile', ['data' => $data]);
    }

    public function updateProfile(CreateUpdate $request, $id)
    {
        $currentLoginUserId = $this->service->getCurrentLoginUserId();
        if ($currentLoginUserId != $id) {
            return redirect()->back()->with('error', 'You can only update your own profile.');
        }
        $user = $this->service->findById($id);
        if (!$user) {
            return false;
        }

        $data = $request->validated();

        // Handle media ID for profile image
        if ($request->has('profile_image_media_id') && $request->profile_image_media_id) {
            $data['profile_image_id'] = $request->profile_image_media_id;
        } else {
            // Keep existing profile_image_id if no new image selected
            unset($data['profile_image_id']);
        }

        $this->service->updateRecord($data, $id);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

}
