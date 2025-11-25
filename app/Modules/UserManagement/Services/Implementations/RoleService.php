<?php

namespace App\Modules\UserManagement\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\UserManagement\DTOs\Role\RoleDto;
use App\Modules\UserManagement\Repositories\Interfaces\RoleRepositoryInterface;
use App\Modules\UserManagement\Services\Interfaces\RoleServiceInterface;

class RoleService extends BaseService implements RoleServiceInterface
{
    use HasPaginatedSearch;
    public function __construct(RoleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getRoleNameByRoleId(int $id): string
    {
        return $this->repository->getRoleNameByRoleId($id);
    }

    public function getPermissionIdsByRoleId(int $id): array
    {
        return $this->repository->getPermissionIdsByRoleId($id)->toArray();
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['name'],
            dtoClass: RoleDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null
        );
    }

    public function deleteRecord($id)
    {
        // check yo role lai kunai permission xa ki nai
        $roleHasPermission = $this->repository->roleHasPermissionsCheckByRoleId($id);

        // if role has permission then show error message
        if ($roleHasPermission == true) {
            return [
                'redirect' => true,
                'error' => 'This role already has permissions assigned. Please remove the permissions first before deleting the role.'
            ];
        }
        return $this->repository->deleteRecord($id);
    }
}
