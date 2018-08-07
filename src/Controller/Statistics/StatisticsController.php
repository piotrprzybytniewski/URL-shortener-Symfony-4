<?php


namespace App\Controller\Statistics;


use App\Repository\StatisticRepository;
use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/s/{url}", methods={"GET"}, name="public_url_statistics")
     */
    public function publicStatistics($url, StatisticRepository $statisticRepository, UrlRepository $urlRepository)
    {
        $private = false;

        $link = $urlRepository->findOneBy([
            'shortenedUrl' => $url
        ]);

        $user_id = $link->getUserId();

        if ($user_id === null) {
            $id = $link->getId();

            $statistics = $statisticRepository->findOneBy([
                'urlId' => $id,
            ]);

            $clicks = $statistics->getClicks();


        } else {
            $private = true;
            return $this->render('statistic/public.html.twig', array(
                'private' => $private,
            ));
        }
        return $this->render('statistic/public.html.twig', array(
            'url' => $url,
            'clicks' => $clicks,
            'private' => $private,
        ));

    }
}