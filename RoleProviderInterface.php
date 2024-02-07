<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

interface RoleProviderInterface
{
    /**
     * @param string $roleId
     * @return Role|null
     */
    public function get(string $roleId): ?Role;

    /**
     * @param string $role_id
     * @return bool
     */
    public function exists(string $role_id): bool;
    /**
     * @param string[]|null $limitRoleIds  If NULL return all, otherwise return only the roles specified in $limitRoleIds.  empty($limitRoleIds) MUST return empty array
     * @return Role[]
     */
    public function getAll(array $limitRoleIds=null): array;

	/**
	 * @param array $roleIds
	 * @return Dictionary
	 */
	public function createRoleLookup(array $roleIds): Dictionary;

    /**
     * @param string $role_id
     * @param string $name
     * @return Role
     */
    public function create(string $role_id, string $name): Role;

    /**
     * @param string $role_id
     * @return void
     */
    public function remove(string $role_id): void;

    /**
     * @param Role $role
     * @return Role
     */
    public function save(Role $role): Role;

    /**
     * @param string $role_id
     * @param int|null $offset
     * @param int|null $limit
     * @return SecurityEntityInterface[]
     * @throws Exception
     */
    public function entitiesInRole(string $role_id, int $offset = null, int $limit = null): array;

    /**
     * @param SecurityEntityInterface $entity
     * @param string $role
     * @return void
     */
    public function addEntityToRole(SecurityEntityInterface $entity, string $role): void;

    /**
     * @param SecurityEntityInterface $entity
     * @param string $role
     * @return void
     */
    public function removeEntityFromRole(SecurityEntityInterface $entity, string $role): void;

    /**
     * @param SecurityEntityInterface $entity
     * @param string $role
     * @return bool
     */
    public function isEntityInRole(SecurityEntityInterface $entity, string $role): bool;

    /**
     * @param SecurityEntityInterface $entity
     * @return string[]
     */
    public function rolesForEntity(SecurityEntityInterface $entity): array;

	/**
	 * @param SecurityEntityInterface[] $entities
	 * @return Dictionary|array A key => value where key = SecurityEntityInterface::qid = roles:string[]
	 */
    public function rolesForEntities(array $entities): Dictionary;

    /**
     * @param string[] $roleIds
     * @return Dictionary
     */
    public function permissionsForRoles(array $roleIds): Dictionary;

    /**
     * @param string $role
     * @param string $permission
     * @return bool
     */
    public function roleHasPermission(string $role, string $permission): bool;

    /**
     * @param string $permission
     * @param string $role
     * @return bool
     */
    public function addPermissionToRole(string $permission, string $role): bool;

    /**
     * @param string $permission
     * @param string $role
     * @return bool
     */
    public function removePermissionFromRole(string $permission, string $role): bool;
}
