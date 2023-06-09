<?php

namespace WebImage\Security;

class EntityService implements EntityServiceInterface
{
    public function getEntityId(SecurityEntityInterface $entity): string
    {
        return $entity->getId();
    }
}