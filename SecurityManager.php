<?php

namespace WebImage\Security;

use Exception;

class SecurityManager
{
    private RoleProviderInterface       $roleProvider;
    private PermissionProviderInterface $permissionProvider;
    private RolePermissionProviderInterface $rolePermissionProvider;
    private EntityRoleProviderInterface $entityRolesProvider;
    private EntityServiceInterface      $entityService;
    private EntityFactoryResolver       $entityFactoryNamespaceResolver;

    /**
     * @param RoleProviderInterface $roleProvider
     * @param PermissionProviderInterface $permissionProvider
     *      * @param RolePermissionProviderInterface $rolePermissionProvider
     * @param EntityRoleProviderInterface $entityRolesProvider
     * @param EntityFactoryResolver $entityResolver
     */
    public function __construct(
        RoleProviderInterface       $roleProvider,
        PermissionProviderInterface $permissionProvider,
        RolePermissionProviderInterface $rolePermissionProvider,
        EntityRoleProviderInterface $entityRolesProvider,
//        EntityService                   $entityService
        EntityFactoryResolver       $entityResolver
    )
    {
        $this->setRoleProvider($roleProvider);
        $this->setPermissionProvider($permissionProvider);
        $this->setRolePermissionProvider($rolePermissionProvider);
        $this->setEntityRolesProvider($entityRolesProvider);
        $this->entityFactoryNamespaceResolver = $entityResolver;
    }

    private function setRoleProvider(RoleProviderInterface $roleProvider): void
    {
        $this->roleProvider = $roleProvider;
        if ($roleProvider instanceof SecurityManagerAwareInterface) $roleProvider->setSecurityManager($this);
    }

    private function setPermissionProvider(PermissionProviderInterface $permissionProvider): void
    {
        $this->permissionProvider = $permissionProvider;
        if ($permissionProvider instanceof SecurityManagerAwareInterface) $permissionProvider->setSecurityManager($this);
    }

    private function setRolePermissionProvider(RolePermissionProviderInterface $rolePermissionProvider): void
    {
        $this->rolePermissionProvider = $rolePermissionProvider;
        if ($rolePermissionProvider instanceof SecurityManagerAwareInterface) $rolePermissionProvider->setSecurityManager($this);
    }

    private function setEntityRolesProvider(EntityRoleProviderInterface $entityRoleProvider): void
    {
        $this->entityRolesProvider = $entityRoleProvider;
        if ($entityRoleProvider instanceof SecurityManagerAwareInterface) $entityRoleProvider->setSecurityManager($this);
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
     * //     * @return RolePermissionProviderInterface
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

    /**
     * @throws Exception
     */
    public function entity($object): ?SecurityEntityInterface
    {
        if (is_string($object)) return $this->entityFromString($object);
        else if (is_object($object)) return $this->entityFromObject($object);

        throw new Exception(__METHOD__ . ' must be called with object or string');
    }

    private function entityFromString(string $entity_id)
    {
        $qid     = Qid::fromString($entity_id);
        $factory = $this->entityFactoryNamespaceResolver->resolve($qid->getNamespace());

        return $factory->get($this, $qid);
    }

    /**
     * @throws Exception
     */
    private function entityFromObject($object): ?SecurityEntityInterface
    {
        $factory = $this->entityFactoryNamespaceResolver->resolveFromObject($object);

        return $factory->entity($this, $object);
    }
}