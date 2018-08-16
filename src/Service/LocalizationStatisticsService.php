<?php


namespace App\Service;


use App\Entity\LocalizationStatistic;
use App\Repository\LocalizationStatisticRepository;
use App\Repository\UrlRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Psr\Log\LoggerInterface;

class LocalizationStatisticsService
{
    const GEODATABASEPATH = 'E:\php\url-shortener\geolocalization\GeoLite2-Country.mmdb';

    private $logger;
    private $localizationRepository;
    private $em;

    public function __construct(
        LocalizationStatisticRepository $localizationRepository,
        LoggerInterface $logger,
        EntityManagerInterface $em,
        UrlRepository $urlRepository
    ) {
        $this->localizationRepository = $localizationRepository;
        $this->logger = $logger;
        $this->em = $em;
        $this->urlRepository = $urlRepository;
    }


    public function getCountry()
    {
        $reader = new Reader(self::GEODATABASEPATH);
        $country = null;
        try {
            $record = $reader->country('91.207.126.231');
            $country = json_decode(json_encode($record), true);
            $country = $country['country']['names']['en'];
        } catch (AddressNotFoundException $e) {
            $this->logger->error($e->getMessage());
        }

        return $country;
    }

    public function getCurrentDate()
    {
        $today = new \DateTime('now');
        $today = $today->format('Y-m-d');

        return $today;
    }

    public function isCountrySavedToday($country, $urlId)
    {
        $today = $this->getCurrentDate();

        $localizationRepository = $this->localizationRepository;
        $isSavedToday = $localizationRepository->findLocalizationForToday($today, $country, $urlId);

        return (bool)$isSavedToday;
    }

    public function addClickToExistingCountry($country, $urlId)
    {
        $today = $this->getCurrentDate();
        $em = $this->em;

        $connection = $em->getConnection();
        try {
            $connection->executeUpdate('
            UPDATE localization_statistic SET clicks = (clicks + 1) WHERE country = ? AND created_at = ? AND url_id = ?',
                [$country, $today, $urlId]);
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
        }
    }


    public function addNewCountry($url, $country, $listId)
    {
        $em = $this->em;
        $localization = new LocalizationStatistic();
        $localization->setCountry($country);
        $localization->setUrl($url);
        $localization->setCreatedAt(new \DateTime());
        $localization->setListOfUrls($listId);

        $url->addLocalizationStatistic($localization);

        $em->persist($localization);
        $em->persist($url);
        $em->flush();
    }
}