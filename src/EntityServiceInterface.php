<?php

namespace WebImage\Security;

interface EntityServiceInterface
{
    public function getSecurityManager(): SecurityManager;
    /**
     * Resolves an object to a SecurityEntityInterface
     * @param $object
     * @return SecurityEntityInterface|null
     */
    public function entity($object): ?SecurityEntityInterface;

    /**
     * Resolves an id to a SecurityEntityInterface
     * @param string $id
     * @return SecurityEntityInterface|null
     */
    public function get(string $id): ?SecurityEntityInterface;

//    public function getEntityId(SecurityEntityInterface $entity): string;
//    public function getEntityFromId(string $id): SecurityEntityInterface;
//    public function registerNamespace(string $namespace, EntityRepositoryInterface $repository);
    // registerNamespace('user', new UserEntityRepository());
    //
}