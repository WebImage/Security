<?php

namespace WebImage\Security;

interface NameableIdentityInterface
{
    public function getId(): string;
    public function getName(): string;
}