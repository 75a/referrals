<?php


namespace app\core\flash;


use app\core\Application;

abstract class Flash
{
    protected const TYPE_NAME = "";
    protected const STYLE_CLASS_NAME = "flash-error";

    protected String $message;
    protected bool $queuedToBeRemoved = false;

    public function __construct(String $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStyleClass(): string
    {
        return static::STYLE_CLASS_NAME;
    }

    public function getTypeName(): string
    {
        return static::TYPE_NAME;
    }

    public function setFlashToBeRemoved(): void
    {
        $this->queuedToBeRemoved = true;
    }

    public function shouldBeRemoved(): bool
    {
        return $this->queuedToBeRemoved;
    }
}