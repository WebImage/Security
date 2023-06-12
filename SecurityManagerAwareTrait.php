<?php

namespace WebImage\Security;

trait SecurityManagerAwareTrait
{
    private SecurityManager $securityManager;

    public function getSecurityManager(): SecurityManager
    {
        return $this->securityManager;
    }

    public function setSecurityManager(SecurityManager $securityManager): void
    {
        $this->securityManager = $securityManager;
    }
}