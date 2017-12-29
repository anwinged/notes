<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Helper\MarkdownParseResult;
use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\Node\Node;

class MarkdownService
{
    const MAX_TITLE_LENGTH = 1024;
    const SHORT_LENGTH = 50;

    private $environment;

    private $parser;

    private $htmlRenderer;

    public function __construct()
    {
        $this->environment = Environment::createCommonMarkEnvironment();
        $this->parser = new DocParser($this->environment);
        $this->htmlRenderer = new HtmlRenderer($this->environment);
    }

    /**
     * @param string $markdownText
     *
     * @return MarkdownParseResult
     */
    public function convert(string $markdownText): MarkdownParseResult
    {
        $document = $this->parser->parse($markdownText);

        return new MarkdownParseResult(
            $this->getTitle($document),
            $this->getShort($document),
            $this->getFull($document)
        );
    }

    /**
     * @param Document $document
     *
     * @return Node|null
     */
    private function getTitleNode(Document $document): ?Node
    {
        $titleNode = $document->firstChild();
        if ($titleNode === null) {
            return null;
        }

        $isAppropriate = ($titleNode instanceof Heading)
            && in_array($titleNode->getLevel(), [1, 2])
        ;

        return $isAppropriate ? $titleNode : null;
    }

    /**
     * @param Document $document
     *
     * @return string
     */
    private function getTitle(Document $document): string
    {
        $titleNode = $this->getTitleNode($document);
        if ($titleNode === null) {
            return '';
        }

        $text = '';
        $nodeWalker = $titleNode->walker();
        while ($event = $nodeWalker->next()) {
            $node = $event->getNode();
            if ($node instanceof Text) {
                $text .= ' '.$node->getContent();
            }
        }

        return mb_strcut(trim($text), 0, self::MAX_TITLE_LENGTH, 'utf8');
    }

    /**
     * @param Document $document
     *
     * @return string
     */
    private function getShort(Document $document): string
    {
        $titleNode = $this->getTitleNode($document);

        $text = '';
        $walker = $document->walker();
        $exclude = false;

        while ($event = $walker->next()) {
            if (mb_strlen($text, 'utf8') >= self::SHORT_LENGTH) {
                break;
            }

            $node = $event->getNode();

            if ($titleNode && spl_object_hash($titleNode) === spl_object_hash($node)) {
                $exclude = $event->isEntering();
                continue;
            }

            if (!$exclude && ($node instanceof Text)) {
                $text .= ' '.$node->getContent();
            }
        }

        return trim($text);
    }

    /**
     * @param Document $document
     *
     * @return string
     */
    private function getFull(Document $document): string
    {
        return $this->htmlRenderer->renderBlock($document);
    }
}
