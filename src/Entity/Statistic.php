<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatisticRepository")
 */
class Statistic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Url", inversedBy="statistic", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $urlId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $clicks = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ListOfUrls", inversedBy="statistics")
     */
    private $list;

    public function getId()
    {
        return $this->id;
    }

    public function getUrlId(): ?Url
    {
        return $this->urlId;
    }

    public function setUrlId(Url $urlId): self
    {
        $this->urlId = $urlId;

        return $this;
    }

    public function getClicks(): ?int
    {
        return $this->clicks;
    }

    public function setClicks(?int $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function getList(): ?ListOfUrls
    {
        return $this->list;
    }

    public function setList(?ListOfUrls $list): self
    {
        $this->list = $list;

        return $this;
    }
}
