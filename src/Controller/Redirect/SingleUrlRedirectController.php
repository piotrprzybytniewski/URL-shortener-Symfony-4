<?php


namespace App\Controller\Redirect;


use App\Repository\UrlRepository;
use App\Service\UrlStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SingleUrlRedirectController extends AbstractController
{
    /**
     * @Route("/{shortenedUrl}", methods={"GET"}, name="single_url_redirect")
     */
    public function singleUrlRedirect($shortenedUrl, UrlRepository $urlRepository, UrlStatisticsService $urlStatisticsService)
    {
        $url = $urlRepository->findOneBy([
            'shortenedUrl' => $shortenedUrl,
        ]);

        $id = $url->getId();
        $originalUrl = $url->getOriginalUrl();

        $urlStatisticsService->updateStatistics($id);


        return $this->redirect($originalUrl);
    }
}