<?php


namespace App\Controller\Redirect;


use App\Repository\UrlRepository;
use App\Service\LocalizationStatisticsService;
use App\Service\UrlStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

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

        $id = $url->getId();
        $originalUrl = $url->getOriginalUrl();

        $urlStatisticsService->updateStatistics($id);
        $country = $localizationStatistics->getCountry();
        $isCountrySavedToday = $localizationStatistics->isCountrySavedToday($country);

        if ($isCountrySavedToday) {
            $localizationStatistics->addClickToExistingCountry($country);
        } else {
            $localizationStatistics->addNewCountry($url, $country);

        }

        return new Response("AHA: ");
//        return $this->redirect($originalUrl);
    }
}