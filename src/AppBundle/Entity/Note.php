<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Note.
 *
 * @ORM\Table(name="note")
 * @ORM\Entity()
 * @~~ORM\Entity(repositoryClass="AppBundle\Repository\NoteRepository")
 */
class Note
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="text")
     *
     * @Assert\NotNull()
     * @Assert\Length(max=1048576)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=1024, options={"default": ""})
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="short", type="string", length=1024, options={"default": ""})
     */
    private $short = '';

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text")
     */
    private $html;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = false;

    /**
     * Get id.
     *
     * @return int
     *
     * @Groups({"full", "preview"})
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set source.
     *
     * @param string $source
     *
     * @return Note
     *
     * @Groups({"setup"})
     */
    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source.
     *
     * @return string
     *
     * @Groups({"full"})
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     *
     * @Groups({"full", "preview"})
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     *
     * @Groups({"full", "preview"})
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * @param string $short
     */
    public function setShort(string $short)
    {
        $this->short = $short;
    }

    /**
     * Set html.
     *
     * @param string $html
     *
     * @return Note
     */
    public function setHtml(string $html): self
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html.
     *
     * @return string
     *
     * @Groups({"full"})
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Note
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     *
     * @Groups({"full", "preview"})
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Note
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     *
     * @Groups({"full", "preview"})
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     *
     * @Groups({"full", "preview"})
     */
    public function isArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     *
     * @return $this
     */
    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }
}
