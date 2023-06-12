<?php

namespace WebImage\Security;

abstract class AbstractSecurityEntity implements SecurityEntityInterface, SecurityManagerAwareInterface
{
    use SecurityManagerAwareTrait;

    private Qid $qid;
    /** @var Role[] */
    private array $roles = [];

    /**
     * @param SecurityManager $securityManager
     * @param QId $qid
     */
//    public function __construct(SecurityManager $securityManager, QId $qid)
    public function __construct(SecurityManager $securityManager, QId $qid)
    {
        $this->setSecurityManager($securityManager);
        $this->qid = $qid;
    }

    public function getQId(): QId
    {
        return $this->qid;
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
        return $this->getSecurityManager()->roles()->getAll(
            $this->getSecurityManager()->entityRoles()->getRolesForEntity($this)
        );
    }

    public function canDo(string $permission): bool
    {
        foreach ($this->getRoles() as $role) {
            if ($role->canDo($permission)) return true;
        }

        return false;
    }

    public function canDoAll(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->canDo($permission)) return false;
        }

        return true;
    }

    public function canDoAny(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->canDo($permission)) return true;
        }

        return false;
    }
}