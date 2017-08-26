<?php

declare(strict_types=1);

namespace AppBundle\Service;

class MarkdownService
{
    private $parsedown;

    public function __construct(\Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    public function convert(string $markdownText): string
    {
        return $this->parsedown->text($markdownText);
    }
}
