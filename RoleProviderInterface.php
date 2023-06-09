<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

interface RoleProviderInterface
{
    public function get(string $role_id): ?Role;
    public function exists(string $role_id): bool;
    /**
     * @return string[]
     */
    public function getAll(): array;
    public function create(string $role_id, string $name): Role;
    public function remove(string $role_id): void;
    public function save(Role $role): Role;
}