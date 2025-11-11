<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Modules\Publication\DTOs\Dealers\DealersDto;
use App\Modules\Publication\Services\Interfaces\DealersServiceInterface;
use App\Modules\Publication\Repositories\Interfaces\DealersRepositoryInterface;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DealersService extends BaseService implements DealersServiceInterface
{
    protected $userRepository;

    public function __construct(
        DealersRepositoryInterface $repository,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct($repository);
        $this->userRepository = $userRepository;
    }

    public function getPaginatedSearchResults(int $perPage, $searchTerm = [])
    {
        $filters = [
            'search' => $searchTerm['keywords'] ?? null,
            'status' => $searchTerm['status'] ?? null,
        ];

        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['name', 'email', 'phone_number', 'address'],
            dtoClass: DealersDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
        );
    }

    public function createRecord($data)
    {
        return DB::transaction(function () use ($data) {
            // Create dealer
            $dealerData = $this->extractDealerData($data);
            $dealer = parent::createRecord($dealerData);

            // Create user if requested
            if (!empty($data['create_user']) && $data['create_user'] == '1') {
                $this->createUserForDealer($dealer, $data);
            }

            return $dealer;
        });
    }

    public function updateRecord($data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            // Update dealer
            $dealerData = $this->extractDealerData($data);
            $dealer = parent::updateRecord($dealerData, $id);

            // Handle user account
            if (!empty($data['create_user']) && $data['create_user'] == '1') {
                $this->updateOrCreateUserForDealer($dealer, $data);
            }

            return $dealer;
        });
    }

    private function extractDealerData(array $data): array
    {
        return [
            'name' => $data['name'],
            'phone_number' => $data['phone_number'] ?? null,
            'address' => $data['address'],
            'contact_person' => $data['contact_person'] ?? null,
            'email' => $data['email'] ?? null,
            'status' => $data['status'] ?? 'active',
        ];
    }

    private function createUserForDealer($dealer, array $data): void
    {
        if (empty($data['username']) || empty($data['password'])) {
            return;
        }
        // Check if user already exists
        $existingUser =  DB::table('users')->where('email', $data['user_email'] ?? $data['email'])->first();
        
        if ($existingUser) {
            return; // User already exists
        }

        $userData = [
            'name' => $data['username'],
            'email' => $data['user_email'] ?? $data['email'],
            'password' => Hash::make($data['password']),
            'status' => ($data['user_status'] ?? 'active') === 'active' ? 1 : 0,
            'role_id' => 6, // Default role ID for dealers
        ];

        $this->userRepository->createRecord($userData);
    }

    private function updateOrCreateUserForDealer($dealer, array $data): void
    {
        if (empty($data['username'])) {
            return;
        }

        $userEmail = $data['user_email'] ?? $data['email'];
        $existingUser = DB::table('users')->where('email', $userEmail)->first();

        if ($existingUser) {
            // Update existing user
            $updateData = [
                'name' => $data['username'],
                'email' => $userEmail,
                'status' => ($data['user_status'] ?? 'active') === 'active' ? 1 : 0,
            ];

            // Only update password if provided
            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            DB::table('users')->where('id', $existingUser->id)->update($updateData);
        } else {
            // Create new user (only if password provided)
            if (!empty($data['password'])) {
                $this->createUserForDealer($dealer, $data);
            }
        }
    }
    
}