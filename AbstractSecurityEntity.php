<?php

namespace WebImage\Security;

abstract class AbstractSecurityEntity implements SecurityEntityInterface
{
    private SecurityManager $securityManager;

    /**
     * @param SecurityManager $security
     */
    public function __construct(SecurityManager $security)
    {
        $this->securityManager = $security;
    }

    abstract public function getId(): string;
    abstract public function getName(): string;
//    abstract public function getNamespace(): string;

    public function getSecurityManager(): SecurityManager
    {
        return $this->securityManager;
    }

    public function addRole(string $role): void
    {
        $this->getSecurityManager()->entityRoles()->addRoleToEntity($role, $this);
    }

    public function removeRole(string $role): void
    {
        $this->getSecurityManager()->entityRoles()->removeRoleFromEntity($role, $this);
    }

    public function inRole(string $role): bool
    {
        return $this->getSecurityManager()->entityRoles()->isEntityInRole($this, $role);
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->getSecurityManager()->entityRoles()->getRolesForEntity($this);
    }

    public function canDo(string $permission): bool
    {
//        $permissions = $this->getRoleManager()->ca
        return false;
    }

    public function canDoAll(array $permissions): bool
    {
        return false;
    }

    public function canDoAny(array $permissions): bool
    {
        return false;
    }
}