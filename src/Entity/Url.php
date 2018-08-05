<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 */
class Url
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $originalUrl;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $shortenedUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="urls")
     */
    private $userId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ListId;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Statistic", mappedBy="urlId", cascade={"persist", "remove"})
     */
    private $statistic;

    public function getId()
    {
        return $this->id;
    }

    public function getOriginalUrl(): ?string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getShortenedUrl(): ?string
    {
        return $this->shortenedUrl;
    }

    public function setShortenedUrl(string $shortenedUrl): self
    {
        $this->shortenedUrl = $shortenedUrl;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getListId(): ?int
    {
        return $this->ListId;
    }

    public function setListId(?int $ListId): self
    {
        $this->ListId = $ListId;

        return $this;
    }

    public function getStatistic(): ?Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(Statistic $statistic): self
    {
        $this->statistic = $statistic;

        // set the owning side of the relation if necessary
        if ($this !== $statistic->getUrlId()) {
            $statistic->setUrlId($this);
        }

        return $this;
    }
}
