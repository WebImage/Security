<?php

namespace WebImage\Security;

interface PermissionProviderInterface
{
    /**
     * @return Permission[]
     */
    public function getAll(): array;

    public function get(string $id): ?Permission;

    public function exists(string $id): bool;

	/**
	 * @param string $id
	 * @param string $name
	 * @throws DuplicatePermissionException
	 * @return Permission
	 */
    public function create(string $id, string $name): Permission;

    public function remove(string $id): bool;

    public function save(Permission $permission): Permission;
}