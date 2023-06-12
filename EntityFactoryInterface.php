<?php

namespace WebImage\Security;

use Exception;
use stdClass;

interface EntityFactoryInterface
{
    /**
     * @param SecurityManager $security
     * @param stdClass $user
     * @return SecurityEntityInterface|null
     *@throws Exception when $object is not an object
     */
    public function entity(SecurityManager $securityManager, object $user): ?SecurityEntityInterface;
    public function get(SecurityManager $securityManager, QId $qid): ?SecurityEntityInterface;
}