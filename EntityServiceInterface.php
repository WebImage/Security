<?php

namespace WebImage\Security;

interface EntityServiceInterface
{
//    public function getSecurityManager(): SecurityManager;
    public function getEntityId(SecurityEntityInterface $entity): string;
//    public function getEntityFromId(string $id): SecurityEntityInterface;
//    public function registerNamespace(string $namespace, EntityRepositoryInterface $repository);
    // registerNamespace('user', new UserEntityRepository());
    //
}