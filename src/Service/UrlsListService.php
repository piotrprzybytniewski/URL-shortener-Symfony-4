<?php


namespace App\Service;


use App\Entity\ListOfUrls;
use App\Entity\Statistic;
use App\Entity\Url;
use Doctrine\ORM\EntityManagerInterface;

class UrlsListService
{
    private $urlGeneratorService;
    private $em;

    public function __construct(UrlGeneratorService $urlGeneratorService, EntityManagerInterface $em)
    {
        $this->urlGeneratorService = $urlGeneratorService;
        $this->em = $em;
    }

    public function addListOfUrls($urls, $userId)
    {
        $em = $this->em;
        $urlGeneratorService = $this->urlGeneratorService;

        $list = new ListOfUrls();
        $listUrl = $urlGeneratorService->getRandomUrl();
        $list->setListUrl($listUrl);
        $em->persist($list);

        foreach ($urls as $link) {
            $url = new Url();
            $statistic = new Statistic();
            $shortenedUrl = $urlGeneratorService->getRandomUrl();
            $url->addUrl($link, $shortenedUrl, $list, $userId, $statistic);
            $em->persist($url);
        }
        $em->flush();

        return $listUrl;
    }
}