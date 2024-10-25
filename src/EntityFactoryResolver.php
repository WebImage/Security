<?php

namespace WebImage\Security;

use Exception;
use WebImage\Core\Dictionary;

class EntityFactoryResolver
{
    /** @var Dictionary|EntityFactoryInterface[] */
    private Dictionary $namespaces;
    /** @var Dictionary|string[] */
    private Dictionary $classNamespaceMap;

    public function __construct()
    {
        $this->namespaces = new Dictionary();
        $this->classNamespaceMap = new Dictionary();
    }

    public function resolve(string $namespace): ?EntityFactoryInterface
    {
        return $this->namespaces->get($namespace);
    }

	public function namespaceForObject($object): ?string
	{
		if (!is_object($object)) throw new Exception(__METHOD__ . ' only supports object resolution');
		$className = get_class($object);

		if (!$this->classNamespaceMap->has($className)) throw new Exception($className . ' does not resolve to a namespace');

		return $this->classNamespaceMap->get($className);
	}

	/**
	 * @throws Exception
	 */
	public function resolveFromObject($object): ?EntityFactoryInterface
	{
		return $this->resolve($this->namespaceForObject($object));
//		if (!is_object($object)) throw new Exception(__METHOD__ . ' only supports object resolution');
//		$className = get_class($object);
//
//		if (!$this->classNamespaceMap->has($className)) throw new Exception($className . ' does not resolve to a namespace');
//
//		return $this->resolve($this->classNamespaceMap->get($className));
//	}
//
//    /**
//     * @throws Exception
//     */
//    public function resolveFromObject($object): ?EntityFactoryInterface
//    {
//        if (!is_object($object)) throw new Exception(__METHOD__ . ' only supports object resolution');
//        $className = get_class($object);
//
//        if (!$this->classNamespaceMap->has($className)) throw new Exception($className . ' does not resolve to a namespace');
//
//        return $this->resolve($this->classNamespaceMap->get($className));
    }

	/**
	 * Register a string namespace, e.g. "user" with its corresponding factory, e.g. UserEntityFactory.  It is also a good idea to call mapClassToNamespace() to map a class to the string namespace.
	 * @param string $namespace
	 * @param EntityFactoryInterface $factory
	 * @return void
	 */
    public function register(string $namespace, EntityFactoryInterface $factory): void
    {
        $this->namespaces->set($namespace, $factory);
    }

	/**
	 * Maps a class to a namespace so that an EntityFactory can be resolved from an object
	 * @param string $class
	 * @param string $namespace
	 * @return void
	 */
    public function mapClassToNamespace(string $class, string $namespace): void
    {
        $this->classNamespaceMap->set($class, $namespace);
    }
}