<?php


namespace App\Controller\Redirect;


use App\Repository\ListOfUrlsRepository;
use App\Repository\UrlRepository;
use App\Service\LocalizationStatisticsService;
use App\Service\UrlStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MultipleUrlsRedirectController extends AbstractController
{
    /**
     * @Route("/list/{shortenedUrl}", methods={"GET"}, name="multiple_urls_redirect")
     */
    public function multipleUrlsRedirect(
        $shortenedUrl,
        ListOfUrlsRepository $listOfUrlsRepository
    ) {
        $list = $listOfUrlsRepository->findOneBy([
            'listUrl' => $shortenedUrl,
        ]);

        $urls = $list->getListOfUrls();

//        $urlId = $url->getId();
//        $originalUrl = $url->getOriginalUrl();
//
//        $urlStatisticsService->updateStatistics($urlId);
//        $country = $localizationStatistics->getCountry();
//        $isCountrySavedToday = $localizationStatistics->isCountrySavedToday($country, $urlId);
//
//        if ($isCountrySavedToday) {
//            $localizationStatistics->addClickToExistingCountry($country, $urlId);
//        } else {
//            $localizationStatistics->addNewCountry($url, $country);
//
//        }
//        return $this->redirect($originalUrl);

    return $this->render('redirect/multiple_urls_redirect.html.twig', array(
        'urls' => $urls,
    ));

    }

}