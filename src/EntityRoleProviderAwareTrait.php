<?php

namespace WebImage\Security;

trait EntityRoleProviderAwareTrait
{
    private EntityRoleProviderInterface $entityRoleProvider;
    public function entityRoles(): EntityRoleProviderInterface
    {
        return $this->entityRoleProvider;
    }

    public function setEntityRoleProvider(EntityRoleProviderInterface $provider)
    {
        $this->entityRoleProvider = $provider;
    }
}