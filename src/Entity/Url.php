<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 * @ORM\Entity
 * @ORM\Table(name="url")
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
     * @Assert\NotBlank()
     * @AcmeAssert\ContainsUrl
     */
    private $originalUrl;

    /**
     * @ORM\Column(type="string", length=300)
     *
     */
    private $shortenedUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="urls")
     */
    private $userId;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Statistic", mappedBy="urlId", cascade={"persist", "remove"})
     */
    private $statistic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ListOfUrls", inversedBy="listOfUrls")
     */
    private $ListId;


    public function addUrl($link, $shortenedUrl, $listId, $userId, $statistic)
    {
        $this
            ->setOriginalUrl($link)
            ->setShortenedUrl($shortenedUrl)
            ->setListId($listId)
            ->setUserId($userId)
            ->setStatistic($statistic, $listId);
    }

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

    public function getStatistic(): ?Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(Statistic $statistic, $listId): self
    {
        $this->statistic = $statistic;

        // set the owning side of the relation if necessary
        if ($this !== $statistic->getUrlId()) {
            $statistic->setUrlId($this);
            $statistic->setList($listId);
        }

        return $this;
    }

    public function getListId(): ?ListOfUrls
    {
        return $this->ListId;
    }

    public function setListId(?ListOfUrls $ListId): self
    {
        $this->ListId = $ListId;

        return $this;
    }


}
