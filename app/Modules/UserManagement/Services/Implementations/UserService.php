<?php
namespace App\Modules\UserManagement\Services\Implementations;

use App\Core\Helpers\FilePathHelper;
use App\Core\Services\Implementation\BaseService;

use App\Core\Services\Interface\FileUploadServiceInterface;
use App\Core\Traits\HandlesImageFields;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\UserManagement\DTOs\User\UserDto;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use App\Modules\UserManagement\Services\Interfaces\UserServiceInterface;

class UserService extends BaseService implements UserServiceInterface
{
    use HandlesImageFields;
    use HasPaginatedSearch;
    protected $fileUploadService;

    public function __construct(
        UserRepositoryInterface $repository,
        FileUploadServiceInterface $fileUploadService
    ) {
        parent::__construct($repository);
        $this->fileUploadService = $fileUploadService;
    }

    public function createRecord($data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, int $id)
    {
        $existingUser = $this->repository->findById($id);
        if (!empty($data['password'])) {
            // New password encrypt
            $data['password'] = bcrypt($data['password']);
        } else {
            // Keep old password
            $data['password'] = $existingUser->password;
        }
        return $this->repository->updateRecord($id, $data);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['name', 'role.name', 'email'],
            dtoClass: UserDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null
        );
    }

    public function findById(int $id)
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            return null;
        }
        $user->profile_image_url = FilePathHelper::getUrl($user->profile_image, 'PROFILE_IMAGE_PATH');

        return $user;
    }
    public function editRecordByIdAndEmployeeId($id, $employeeId)
    {
        return $this->repository->editRecordByIdAndEmployeeId($id, $employeeId);
    }
    public function updateRecordByIdAndEmployeeId($data, $id, $employeeId)
    {
        return $this->repository->updateRecordByIdAndEmployeeId($data, $id, $employeeId);
    }
    public function editRecordByEmployeeId($employeeId)
    {
        return $this->repository->editRecordByEmployeeId($employeeId);
    }
}
