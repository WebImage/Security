<?php

/**
 * Qualified ID
 */
namespace WebImage\Security;

class QId
{
    const NAMESPACE_SEPARATOR = ':';

    private string $namespace;
    private string $id;

    /**
     * @param string $namespace
     * @param string $id
     */
    public function __construct(string $namespace, string $id)
    {
        $this->namespace = $namespace;
        $this->id        = $id;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


    public function toString(): string
    {
        return $this->getNamespace() . self::NAMESPACE_SEPARATOR . $this->getId();
    }

    /**
     * Create from qualified ID (e.g. namespace:id)
     * @param string $qid
     * @return QId
     */
    public static function fromString(string $qid)
    {
        list($namespace, $id) = array_pad(explode(self::NAMESPACE_SEPARATOR, $qid), 2, '');

        return new QId($namespace, $id);
    }
}