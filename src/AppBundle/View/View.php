<?php

declare(strict_types=1);

namespace AppBundle\View;

use Symfony\Component\HttpFoundation\Response;

final class View
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string
     */
    private $options = [];

    /**
     * @param $data
     * @param array $options
     *
     * @return self
     */
    public static function create($data, array $options = []): self
    {
        return new self($data, $options);
    }

    /**
     * @param $data
     * @param array $options
     */
    private function __construct($data, array $options)
    {
        $this->data = $data;
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string[]
     */
    public function getGroups(): array
    {
        return $this->options['groups'] ?? [];
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->options['status_code'] ?? Response::HTTP_OK;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->options['state'] ?? 'unknown';
    }
}
