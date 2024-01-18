<?php

namespace WebImage\Security;

use Exception;
use WebImage\Core\Dictionary;

class SecurityManager
{
    private RoleProviderInterface       $roleProvider;
    private PermissionProviderInterface $permissionProvider;
    private RolePermissionProviderInterface $rolePermissionProvider;
    private EntityServiceInterface $entityService;
    private EntityFactoryResolver  $entityFactoryResolver;

    /**
     * @param RoleProviderInterface $roleProvider
     * @param PermissionProviderInterface $permissionProvider
     * @param EntityFactoryResolver $entityResolver
     */
    public function __construct(
        RoleProviderInterface       $roleProvider,
        PermissionProviderInterface $permissionProvider,
//        EntityService                   $entityService
        EntityFactoryResolver       $entityResolver
    )
    {
        $this->setRoleProvider($roleProvider);
        $this->setPermissionProvider($permissionProvider);
        $this->entityFactoryResolver = $entityResolver;
    }

    private function setRoleProvider(RoleProviderInterface $roleProvider): void
    {
        $this->roleProvider = $roleProvider;
        if ($roleProvider instanceof SecurityManagerAwareInterface) $roleProvider->setSecurityManager($this);
    }

    private function setPermissionProvider(PermissionProviderInterface $permissionProvider): void
    {
        $this->permissionProvider = $permissionProvider;
        if ($permissionProvider instanceof SecurityManagerAwareInterface) $permissionProvider->setSecurityManager($this);
    }

    private function setRolePermissionProvider(RolePermissionProviderInterface $rolePermissionProvider): void
    {
        $this->rolePermissionProvider = $rolePermissionProvider;
        if ($rolePermissionProvider instanceof SecurityManagerAwareInterface) $rolePermissionProvider->setSecurityManager($this);
    }

    /**
     * @return RoleProviderInterface
     */
    public function roles(): RoleProviderInterface
    {
        return $this->roleProvider;
    }

    /**
     * @return PermissionProviderInterface
     */
    public function permissions(): PermissionProviderInterface
    {
        return $this->permissionProvider;
    }

	/**
	 * @throws Exception
	 */
	public function entity($object=null): ?SecurityEntityInterface
	{
		if (is_string($object)) return $this->entityFromString($object);
		else if (is_object($object)) return $this->entityFromObject($object);
		// ANONYMOUS SUPPORT: else if ($object === null) return $this->entityFactoryResolver->resolve('')->entity();

		throw new Exception(__METHOD__ . ' must be called with object or string');
	}

	/**
	 * @template T
	 * @return T[]|array
	 * @throws Exception
	 */
	public function entities(array $objects): array
	{
		if (count($objects) == 0) return [];

		$type = $this->getAndAssertSingleType($objects);

		if ($type == 'string') return $this->entitiesFromStrings($objects);
		else if ($type == 'object') throw new \RuntimeException(__METHOD__ . ' does not yet support objects');// $this->entitiesFromObjects($objects);

		throw new Exception(__METHOD__ . ' must be called with object or string');
	}

	private function getAndAssertSingleType(array $objects)
	{
		$type = null;

		foreach($objects as $ix => $object) {
			$objectType = gettype($object);
			if (!in_array($objectType, ['object', 'string'])) throw new \RuntimeException('Unknown object passed at index ' . $ix . ': ' . $objectType);
			else if ($type !== null && $objectType != $type) throw new \RuntimeException('All objects sent to ' . __METHOD__ . ' must be of one type.  Initial object was ' . $type . ', but object at index ' . $ix . ' was of type ' . $objectType);
			$type = $objectType;
		}

		return $type;
	}

	private function entityFromString(string $entity_id): ?SecurityEntityInterface
    {
        $qid     = Qid::fromString($entity_id);
        $factory = $this->entityFactoryResolver->resolve($qid->getNamespace());

        return $factory->get($this, $qid);
    }

	/**
	 * @template T
	 * @param array $entity_ids
	 * @return T[]|array
	 */
	private function entitiesFromStrings(array $entity_ids): array
	{
		$factoryEntityMap = [];

		// Group entity_ids by the factory required to retrieve them
		foreach($entity_ids as $entity_id) {
			$qid     = Qid::fromString($entity_id);
			if (!array_key_exists($qid->getNamespace(), $factoryEntityMap)) $factoryEntityMap[$qid->getNamespace()] = [];
			$factoryEntityMap[$qid->getNamespace()][] = $qid;
		}

		// For each factory type, merge the results from the dedicated factory
		$d = new Dictionary();
		foreach($factoryEntityMap as $namespace => $qids) {
			$factory = $this->entityFactoryResolver->resolve($namespace);
			$d->merge($factory->getMultiple($this, $qids));
		}

		return array_map(function($entity_id) use ($d) {
			return $d->get($entity_id);
		}, $entity_ids);
	}

    /**
     * @throws Exception
     */
    private function entityFromObject($object): ?SecurityEntityInterface
    {
        $factory = $this->entityFactoryResolver->resolveFromObject($object);

        return $factory->entity($this, $object);
    }
}
