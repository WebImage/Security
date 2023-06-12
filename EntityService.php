<?php

namespace WebImage\Security;

/**
 * @deprecated
 */
class EntityService implements EntityServiceInterface, RoleProviderAwareInterface, EntityRoleProviderAwareInterface
{
    use RoleProviderAwareTrait;
    use EntityRoleProviderAwareTrait;

    private EntityFactoryResolver $resolver;

    public function __construct(RoleProviderInterface          $roleProvider,
                                EntityRoleProviderInterface    $entityRoleProvider,
                                EntityFactoryResolver $resolver
    )
    {
        $this->setRoleProvider($roleProvider);
        $this->setEntityRoleProvider($entityRoleProvider);
        $this->resolver = $resolver;
    }

    public function getSecurityManager(): SecurityManager
    {
//        return $this->getEnti
    }

    public function entity($object): ?SecurityEntityInterface
    {
        if (is_object($object)) return $this->entityFromObject($object);
        else if (is_string($object))

        throw new \Exception('Unsupported entity type');
    }

    public function get(string $id): ?SecurityEntityInterface
    {
        die(__FILE__ . ':' . __LINE__ . '<br />' . PHP_EOL);
    }




//    public function getEntityId(SecurityEntityInterface $entity): string
//    {
//        return $entity->getId();
//    }
}