<?php


namespace App\Controller\Redirect;


use App\Repository\UrlRepository;
use App\Service\LocalizationStatisticsService;
use App\Service\UrlStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SingleUrlRedirectController extends AbstractController
{
    /**
     * @Route("/{shortenedUrl}", methods={"GET"}, name="single_url_redirect")
     */
    public function singleUrlRedirect(
        $shortenedUrl,
        UrlRepository $urlRepository,
        UrlStatisticsService $urlStatisticsService,
        LocalizationStatisticsService $localizationStatistics
    ) {
        $url = $urlRepository->findOneBy([
            'shortenedUrl' => $shortenedUrl,
        ]);

        $urlId = $url->getId();
        $originalUrl = $url->getOriginalUrl();

        $urlStatisticsService->updateStatistics($urlId);
        $country = $localizationStatistics->getCountry();
        $isCountrySavedToday = $localizationStatistics->isCountrySavedToday($country, $urlId);

        if ($isCountrySavedToday) {
            $localizationStatistics->addClickToExistingCountry($country, $urlId);
        } else {
            $localizationStatistics->addNewCountry($url, $country);

        }
        return $this->redirect($originalUrl);
    }
}