<?php

namespace WebImage\Security;

use WebImage\Core\Dictionary;

class EntityFactoryNamespaceResolver
{
    /** @var EntityFactoryInterface[] */
    private Dictionary $namespaces;

    public function __construct()
    {
        $this->namespaces = new Dictionary();;
    }

    public function resolve(string $namespace): ?EntityFactoryInterface
    {
        return $this->namespaces->get($namespace);
    }

    public function register(string $namespace, EntityFactoryInterface $factory)
    {
        $this->namespaces->set($namespace, $factory);
    }
}