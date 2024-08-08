<?php

namespace WebImage\Security;

abstract class AbstractIdentifiable implements NameableIdentityInterface
{
    protected string $id;
    protected string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $id
     */
//    public function setId(string $id): void
//    {
//        $this->id = $id;
//    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}