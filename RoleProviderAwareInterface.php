<?php

namespace WebImage\Security;

interface RoleProviderAwareInterface
{
    public function roles(): RoleProviderInterface;
    public function setRoleProvider(RoleProviderInterface $provider);
}