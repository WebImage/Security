<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

class EntityFactoryResolver
{
    /** @var Dictionary|EntityFactoryInterface[] */
    private Dictionary $namespaces;
    /** @var Dictionary|string[] */
    private Dictionary $classNamespaceMap;

    public function __construct()
    {
        $this->namespaces = new Dictionary();;
        $this->classNamespaceMap = new Dictionary();
    }

    public function resolve(string $namespace): ?EntityFactoryInterface
    {
        return $this->namespaces->get($namespace);
    }

    /**
     * @throws \Exception
     */
    public function resolveFromObject($object): ?EntityFactoryInterface
    {
        if (!is_object($object)) throw new \Exception(__METHOD__ . ' only supports object resolution');
        $className = get_class($object);

        if (!$this->classNamespaceMap->has($className)) throw new \Exception($className . ' does not resolve to a namespace');

        return $this->resolve($this->classNamespaceMap->get($className));
    }

    public function register(string $namespace, EntityFactoryInterface $factory)
    {
        $this->namespaces->set($namespace, $factory);
    }

    public function mapClassToNamespace(string $class, string $namespace)
    {
        $this->classNamespaceMap->set($class, $namespace);
    }
}