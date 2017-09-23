<?php

namespace Tests;

use AppBundle\Service\MarkdownService;
use PHPUnit\Framework\TestCase;

class MarkdownServiceTest extends TestCase
{
    /**
     * @var MarkdownService
     */
    private $service;

    protected function setUp()
    {
        $this->service = new MarkdownService();
    }

    public function testConversion()
    {
        $markdown = <<<'EOD'
# Heading

Paragraph.

* Item
* Second

Other.
EOD;

        $result = $this->service->convert($markdown);

        $this->assertEquals('Heading', $result->getTitle());
        $this->assertEquals('Paragraph. Item Second Other.', $result->getShort());
    }

    public function testEmpty()
    {
        $markdown = '';
        $result = $this->service->convert($markdown);

        $this->assertEquals('', $result->getTitle());
        $this->assertEquals('', $result->getShort());
        $this->assertEquals('', $result->getFull());
    }
}
