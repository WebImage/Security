<?php

namespace WebImage\Security;

use Exception;

class SecurityManager
{
    private RoleProviderInterface       $roleProvider;
    private PermissionProviderInterface $permissionProvider;
    private RolePermissionProviderInterface $rolePermissionProvider;
    private EntityServiceInterface $entityService;
    private EntityFactoryResolver  $entityFactoryResolver;

    /**
     * @param RoleProviderInterface $roleProvider
     * @param PermissionProviderInterface $permissionProvider
     * @param EntityFactoryResolver $entityResolver
     */
    public function __construct(
        RoleProviderInterface       $roleProvider,
        PermissionProviderInterface $permissionProvider,
//        EntityService                   $entityService
        EntityFactoryResolver       $entityResolver
    )
    {
        $this->setRoleProvider($roleProvider);
        $this->setPermissionProvider($permissionProvider);
        $this->entityFactoryResolver = $entityResolver;
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
     * @throws Exception
     */
    public function entity($object=null): ?SecurityEntityInterface
    {
        if (is_string($object)) return $this->entityFromString($object);
        else if (is_object($object)) return $this->entityFromObject($object);
        // ANONYMOUS SUPPORT: else if ($object === null) return $this->entityFactoryResolver->resolve('')->entity();

        throw new Exception(__METHOD__ . ' must be called with object or string');
    }

    private function entityFromString(string $entity_id): ?SecurityEntityInterface
    {
        $qid     = Qid::fromString($entity_id);
        $factory = $this->entityFactoryResolver->resolve($qid->getNamespace());

        return $factory->get($this, $qid);
    }

    /**
     * @throws Exception
     */
    private function entityFromObject($object): ?SecurityEntityInterface
    {
        $factory = $this->entityFactoryResolver->resolveFromObject($object);

        return $factory->entity($this, $object);
    }
}