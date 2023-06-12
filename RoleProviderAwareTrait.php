<?php

namespace WebImage\Security;

trait RoleProviderAwareTrait
{
    private $roleProvider;

    public function roles(): RoleProviderInterface
    {
        return $this->roleProvider;
    }

    public function setRoleProvider(RoleProviderInterface $roleProvider)
    {
        $this->roleProvider = $roleProvider;
    }
}