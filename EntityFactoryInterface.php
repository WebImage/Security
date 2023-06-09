<?php

namespace WebImage\Security;

interface EntityFactoryInterface
{
    public function create(QId $qualified_id): SecurityEntityInterface;
}