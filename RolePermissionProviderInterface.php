<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

interface RolePermissionProviderInterface
{
    /**
     * @param string[] $role_ids
     * @return Dictionary
     */
    public function forRoles(array $role_ids): Dictionary;

    public function roleHasPermission(string $role, string $permission): bool;

    public function addPermissionToRole(string $permission, string $role): bool;

    public function removePermissionFromRole(string $permission, string $role): bool;
}