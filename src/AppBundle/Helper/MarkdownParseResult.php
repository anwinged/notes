<?php

declare(strict_types=1);

namespace AppBundle\Helper;

final class MarkdownParseResult
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $short;

    /**
     * @var string
     */
    private $full;

    /**
     * MarkdownParseResult constructor.
     *
     * @param string $title
     * @param string $short
     * @param string $full
     */
    public function __construct(string $title, string $short, string $full)
    {
        $this->title = $title;
        $this->short = $short;
        $this->full = $full;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * @return string
     */
    public function getFull(): string
    {
        return $this->full;
    }
}
