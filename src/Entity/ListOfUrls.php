<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListOfUrlsRepository")
 */
class ListOfUrls
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=400)
     */
    private $listUrl;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Url", mappedBy="ListId")
     */
    private $listOfUrls;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statistic", mappedBy="list")
     */
    private $statistics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LocalizationStatistic", mappedBy="listOfUrls")
     */
    private $localizationStatistics;

    public function __construct()
    {
        $this->listOfUrls = new ArrayCollection();
        $this->statistics = new ArrayCollection();
        $this->localizationStatistics = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getListUrl(): ?string
    {
        return $this->listUrl;
    }

    public function setListUrl(string $listUrl): self
    {
        $this->listUrl = $listUrl;

        return $this;
    }

    /**
     * @return Collection|Url[]
     */
    public function getListOfUrls(): Collection
    {
        return $this->listOfUrls;
    }

    public function addListOfUrl(Url $listOfUrl): self
    {
        if (!$this->listOfUrls->contains($listOfUrl)) {
            $this->listOfUrls[] = $listOfUrl;
            $listOfUrl->setListId($this);
        }

        return $this;
    }

    public function removeListOfUrl(Url $listOfUrl): self
    {
        if ($this->listOfUrls->contains($listOfUrl)) {
            $this->listOfUrls->removeElement($listOfUrl);
            // set the owning side to null (unless already changed)
            if ($listOfUrl->getListId() === $this) {
                $listOfUrl->setListId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Statistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(Statistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setList($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): self
    {
        if ($this->statistics->contains($statistic)) {
            $this->statistics->removeElement($statistic);
            // set the owning side to null (unless already changed)
            if ($statistic->getList() === $this) {
                $statistic->setList(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LocalizationStatistic[]
     */
    public function getLocalizationStatistics(): Collection
    {
        return $this->localizationStatistics;
    }

    public function addLocalizationStatistic(LocalizationStatistic $localizationStatistic): self
    {
        if (!$this->localizationStatistics->contains($localizationStatistic)) {
            $this->localizationStatistics[] = $localizationStatistic;
            $localizationStatistic->setListOfUrls($this);
        }

        return $this;
    }

    public function removeLocalizationStatistic(LocalizationStatistic $localizationStatistic): self
    {
        if ($this->localizationStatistics->contains($localizationStatistic)) {
            $this->localizationStatistics->removeElement($localizationStatistic);
            // set the owning side to null (unless already changed)
            if ($localizationStatistic->getListOfUrls() === $this) {
                $localizationStatistic->setListOfUrls(null);
            }
        }

        return $this;
    }
}
