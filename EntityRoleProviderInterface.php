<?php

namespace WebImage\Security;

interface EntityRoleProviderInterface
{
    /**
     * @param string $role_id
     * @param int|null $offset
     * @param int|null $limit
     * @return SecurityEntityInterface
     * @throws \Exception
     */
    public function getEntitiesInRole(string $role_id, int $offset = null, int $limit = null): array;

    public function addRoleToEntity(string $role, SecurityEntityInterface $entity): void;

    public function removeRoleFromEntity(string $role, SecurityEntityInterface $entity): void;


    public function isEntityInRole(SecurityEntityInterface $entity, string $role): bool;

    /**
     * @param SecurityEntityInterface $entity
     * @return string[]
     */
    public function getRolesForEntity(SecurityEntityInterface $entity): array;
}