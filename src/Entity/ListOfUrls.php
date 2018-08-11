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

    public function __construct()
    {
        $this->listOfUrls = new ArrayCollection();
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
}
