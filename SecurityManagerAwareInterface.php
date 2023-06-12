<?php

namespace WebImage\Security;

interface SecurityManagerAwareInterface
{
    public function getSecurityManager(): SecurityManager;
    public function setSecurityManager(SecurityManager $securityManager): void;
}