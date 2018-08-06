<?php


namespace App\Controller\Statistics;


use App\Repository\StatisticRepository;
use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/s/{url}", methods={"GET"}, name="public_url_statistics")
     */
    public function publicStatistics($url, StatisticRepository $statisticRepository, UrlRepository $urlRepository)
    {

        $link = $urlRepository->findOneBy([
            'shortenedUrl' => $url
        ]);

        $id = $link->getId();

        return $this->render('statistic/public.html.twig', array(
            'url' => $url,
            'id' => $id,
            ));
    }
}