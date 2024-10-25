<?php

namespace WebImage\Security;

use Exception;
use stdClass;
use WebImage\Core\Dictionary;

interface EntityFactoryInterface
{
	/**
	 * @param SecurityManager $securityManager
	 * @param object $user
	 * @param string $namespace
	 * @return SecurityEntityInterface|null
	 * @throws Exception when $object is not an object
	 */
    public function entity(SecurityManager $securityManager, object $user, string $namespace): ?SecurityEntityInterface;

    public function get(SecurityManager $securityManager, QId $qid): ?SecurityEntityInterface;

	/**
	 * @param SecurityManager $securityManager
	 * @param QId[] $qids
	 * @return Dictionary|SecurityEntityInterface[]
	 */
    public function getMultiple(SecurityManager $securityManager, array $qids): Dictionary;
}
