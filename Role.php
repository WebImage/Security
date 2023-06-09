<?php

namespace WebImage\Security;

class Role extends AbstractIdentifiable
{
    /** @var string[] */
    private array $permissions = [];

    public function addPermission(string $permission): bool
    {
        if ($this->canDo($permission)) return false; // Role can already do this

        $this->permissions[] = $permission;

        return true;
    }

    public function removePermission(string $permission): bool
    {
        if (!$this->canDo($permission)) return false; // Role already cannot do this

        unset($this->permissions[$permission]);

        return true;
    }

    public function canDo(string $permission): bool
    {
        return array_key_exists($permission, $this->permissions);
    }
}