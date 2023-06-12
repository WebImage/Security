<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

interface RoleProviderInterface
{
    public function get(string $role_id): ?Role;
    public function exists(string $role_id): bool;
    /**
     * @param string[] $role_ids
     * @return Role[]
     */
    public function getAll(array $role_ids=null): array;
    public function create(string $role_id, string $name): Role;
    public function remove(string $role_id): void;
    public function save(Role $role): Role;
}