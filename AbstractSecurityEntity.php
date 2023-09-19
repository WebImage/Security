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
        $this->getSecurityManager()->roles()->addEntityToRole($this, $role);
    }

    public function removeRole(string $role): void
    {
        $this->getSecurityManager()->roles()->removeEntityFromRole($this, $role);
    }

    public function inRole(string $role): bool
    {
        return $this->getSecurityManager()->roles()->isEntityInRole($this, $role);
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        $roles = $this->securityManager->roles();
        $role_ids = $roles->getRolesForEntity($this);

        return $roles->getAll($role_ids);
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