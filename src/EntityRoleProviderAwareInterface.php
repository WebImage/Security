<?php

namespace WebImage\Security;

interface EntityRoleProviderAwareInterface
{
    public function entityRoles(): EntityRoleProviderInterface;
    public function setEntityRoleProvider(EntityRoleProviderInterface $provider);
}