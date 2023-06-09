<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

/**
 * @deprecated
 */
class RoleManager
{
    protected RoleProviderInterface           $roleProvider;
    protected PermissionProviderInterface     $permissionProvider;
    protected RolePermissionProviderInterface $rolePermissionProvider;
    protected EntityRoleProviderInterface     $entityRoleProvider;
    /** @var Dictionary */
    private array $cachedRoles = [];

    /**
     * @param RoleProviderInterface $roleProvider
     */
    public function __construct(
        RoleProviderInterface           $roleProvider,
        PermissionProviderInterface     $permissionProvider,
        RolePermissionProviderInterface $rolePermissionProvider,
        EntityRoleProviderInterface     $entityRolesProvider
    )
    {
        $this->roleProvider           = $roleProvider;
        $this->permissionProvider     = $permissionProvider;
        $this->rolePermissionProvider = $rolePermissionProvider;
        $this->entityRoleProvider     = $entityRolesProvider;
    }

    public function getRole(string $role_id): ?Role
    {
        if (!$this->cachedRoles->has($role_id)) {
            $role_id = $this->roleProvider->get($role_id);
            if ($role_id === null) return null;

            $this->roleProvider->getPermissionsForRoles($role_id);
        }

        return $this->cachedRoles->get($role_id);
    }

    public function roleExists(string $role)
    {
        return $this->roleProvider->exists($role);
    }

    /**
     * @param string $id
     * @param string $name
     * @return Role
     */
    public function createRole(string $id, string $name): Role
    {
        return $this->roleProvider->create($id, $name);
    }

    public function removeRole(string $role): void
    {
        $this->roleProvider->remove($role);
    }

    public function saveRole(Role $role)
    {
        $this->roleProvider->save($role);
    }

    public function getEntitiesInRole(string $role, int $offset = null, int $limit = null): array
    {
//        $security->roles();
//        $security->roles()->getAll();
//        $security->roles()->get('admin');
//        $security->roles()->exists('admin');
//        $security->roles()->create('admin', 'Admin');
//        $security->roles()->createIfNotExists('admin', 'Admin');
//        $security->roles()->addPermission('admin', 'document:send');
//
//        $security->permissions();
//        $security->permissions()->getAll();
//        $security->permissions()->get('document:send');
//
//        $security->entities()->registerType('user', UserSecurityEntityRepository);
//        $security->entities()->create('user', $user);
//        $security->entities()->get('user:123'); // => UserSecurityEntity($user)
//        $security->entities()->canDo(new UserSecurityEntity(), 'document:send'));
//
//        $security->rolePermissions();
//        $security->entities();
//        $security->entitiesRoles();


        return $this->roleProvider->getEntitiesInRole($role, $offset, $limit);
    }

    public function addRoleToEntity(string $role_id, SecurityEntityInterface $entity): void
    {
        $role = $this->getRole($role_id);
        if ($role === null) throw new InvalidRoleException('The role ' . $role_id . ' does not exist');
        $this->roleProvider->addRoleToEntity($role, $entity);
    }

    public function removeRoleFromEntity(string $role_id, SecurityEntityInterface $entity): void
    {
        $role = $this->getRole($role_id);
        if ($role === null) throw new InvalidRoleException('The role ' . $role_id . ' does not exist');
        $this->roleProvider->removeRoleFromEntity($role, $entity);
    }

    public function isEntityInRole(SecurityEntityInterface $entity, string $role_id): bool
    {
        $role = $this->getRole($role_id);
        if ($role === null) throw new InvalidRoleException('The role ' . $role_id . ' does not exist');

        return $this->roleProvider->isEntityInRole(
            $entity,
            $role
        );
    }

    /**
     * PERMISSIONS
     */

    /**
     * @return Permission[]
     */
    public function getPermissions(): array
    {
        return $this->permissionProvider->getAll();
    }

    public function getPermission(string $id): ?Permission
    {
        return $this->permissionProvider->get($id);
    }

    public function permissionExists(string $id): bool
    {
        return $this->permissionProvider->exists($id);
    }

    public function createPermission(string $id, string $name): Permission
    {
        return $this->permissionProvider->create($id, $name);
    }

    public function removePermission(string $id): bool
    {
        return $this->permissionProvider->remove($id);
    }

    public function savePermission(Permission $permission): Permission
    {
        return $this->permissionProvider->save($permission);
    }

    public function addPermissionToRole(string $permission_id, string $role_id): bool
    {
        $permission = $this->getRequiredPermission($permission_id);
        $role       = $this->getRequiredRole($role_id);

        return $this->roleProvider->addPermissionToRole($permission, $role);
    }

    public function removePermissionFromRole(string $permission_id, string $role_id): bool
    {
        $role       = $this->getRequiredRole($role_id);
        $permission = $this->getRequiredPermission($permission_id);

        return $this->roleProvider->removePermissionFromRole($permission, $role);
    }

    /**
     * ROLE PERMISSIONS
     */
    /**
     * @return void
     */
    public function roleHasPermission(string $role_id, string $permission_id)
    {
        $role       = $this->getRequiredRole($role_id);
        $permission = $this->getRequiredPermission($permission_id);

        return $this->roleProvider->roleHasPermission($role, $permission);
    }

    private function getRequiredRole(string $id): Role
    {
        $role = $this->getRole($id);
        if ($role === null) throw new InvalidRoleException('The role ' . $id . ' does not exist');

        return $role;
    }

    private function getRequiredPermission(string $id): Permission
    {
        $permission = $this->getPermission($id);
        if ($permission === null) throw new InvalidPermissionException('The permission ' . $id . ' does not exist');

        return $permission;
    }
}