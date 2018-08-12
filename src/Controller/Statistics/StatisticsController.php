<?php


namespace App\Controller\Statistics;


use App\Repository\ListOfUrlsRepository;
use App\Repository\StatisticRepository;
use App\Repository\UrlRepository;
use App\Service\StatisticsAccessService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/s/{url}", methods={"GET"}, name="public_url_statistics")
     */
    public function publicStatistics(
        $url,
        StatisticRepository $statisticRepository,
        UrlRepository $urlRepository,
        StatisticsAccessService $statisticsAccess
    ) {
        $private = false;

        $link = $urlRepository->findOneBy([
            'shortenedUrl' => $url,
        ]);

        if ($statisticsAccess->userIsAuthorOfSingleUrl($link)) {
            $id = $link->getId();

            $statistics = $statisticRepository->findOneBy([
                'urlId' => $id,
            ]);
            $clicks = $statistics->getClicks();
        } else {
            $private = true;
            return $this->render('statistic/public.html.twig', [
                'private' => $private,
            ]);
        }

        return $this->render('statistic/public.html.twig', [
            'url' => $url,
            'clicks' => $clicks,
            'private' => $private,
        ]);
    }

    /**
     * @Route("/list/{url}", methods={"GET"}, name="public_list_of_urls_statistics")
     */
    public function publicListOfStatistics(
        $url,
        ListOfUrlsRepository $listOfUrlsRepository,
        StatisticsAccessService $statisticsAccess
    ) {
        $private = false;

        $list = $listOfUrlsRepository->findOneBy([
            'listUrl' => $url,
        ]);

        $urls = $list->getListOfUrls();

        if ($statisticsAccess->userIsAuthorOfList($list)) {

            return $this->render('statistic/public_list.html.twig', [
                'urls' => $urls,
                'private' => $private,
            ]);
        }

        $private = true;
        return $this->render('statistic/public_list.html.twig', [
            'urls' => $urls,
            'private' => $private,
        ]);


    }
}