<?php

namespace WebImage\Security;

class SecurityManager
{
    private RoleProviderInterface           $roleProvider;
    private PermissionProviderInterface     $permissionProvider;
    private RolePermissionProviderInterface $rolePermissionProvider;
    private EntityRoleProviderInterface     $entityRolesProvider;
    private EntityServiceInterface          $entityService;

    /**
     * @param RoleProviderInterface $roleProvider
     * @param PermissionProviderInterface $permissionProvider
     * @param RolePermissionProviderInterface $rolePermissionProvider
     * @param EntityRoleProviderInterface $entityRolesProvider
     */
    public function __construct(
        RoleProviderInterface           $roleProvider,
        PermissionProviderInterface     $permissionProvider,
        RolePermissionProviderInterface $rolePermissionProvider,
        EntityRoleProviderInterface     $entityRolesProvider,
        EntityService                   $entityService
    )
    {
        $this->roleProvider           = $roleProvider;
        $this->permissionProvider     = $permissionProvider;
        $this->rolePermissionProvider = $rolePermissionProvider;
        $this->entityRolesProvider    = $entityRolesProvider;
        $this->entityService          = $entityService;
    }

    /**
     * @return RoleProviderInterface
     */
    public function roles(): RoleProviderInterface
    {
        return $this->roleProvider;
    }

    /**
     * @return PermissionProviderInterface
     */
    public function permissions(): PermissionProviderInterface
    {
        return $this->permissionProvider;
    }

    /**
     * @return RolePermissionProviderInterface
     */
    public function rolePermissions(): RolePermissionProviderInterface
    {
        return $this->rolePermissionProvider;
    }

    /**
     * @return EntityRoleProviderInterface
     */
    public function entityRoles(): EntityRoleProviderInterface
    {
        return $this->entityRolesProvider;
    }

    public function entities(): EntityServiceInterface
    {
        return $this->entityService;
    }
}