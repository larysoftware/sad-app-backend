<?php

namespace App\HomePage\Domain\Entities;

class Message
{
    public function __construct(
        private string $content
    ) {}

    public function getContent(): string
    {
        return $this->content;
    }
}
