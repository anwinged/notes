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
     * @var int
     */
    private $statusCode;

    /**
     * @param $data
     * @param int $statusCode
     *
     * @return self
     */
    public static function create($data, int $statusCode = Response::HTTP_OK): self
    {
        return new self($data, $statusCode);
    }

    /**
     * @param $data
     * @param int $statusCode
     */
    private function __construct($data, int $statusCode)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
