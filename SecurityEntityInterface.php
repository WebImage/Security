<?php

namespace WebImage\Security;

interface SecurityEntityInterface
{
    public function getQId(): QId;

    public function addRole(string $role): void;

    public function removeRole(string $role): void;

    public function inRole(string $role): bool;

    /**
     * @return Role[]
     */
    public function getRoles(): array;

    public function canDo(string $permission): bool;

    public function canDoAll(array $permissions): bool;

    public function canDoAny(array $permissions): bool;
}