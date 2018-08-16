<?php


namespace App\Service;

use App\Repository\LocalizationStatisticRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class UrlStatisticsService
{

    private $em;
    private $logger;
    private $localizationStatisticRepository;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger,
        LocalizationStatisticRepository $localizationStatisticRepository
    ) {
        $this->em = $em;
        $this->logger = $logger;
        $this->localizationStatisticRepository = $localizationStatisticRepository;
    }


    public function updateStatistics($id)
    {
        $em = $this->em;

        $connection = $em->getConnection();
        try {
            $connection->executeUpdate('UPDATE statistic SET clicks = (clicks + 1) WHERE url_id_id = ?', [$id]);
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
        }

    }

    public function getClicksForUrl($link)
    {
        $clicks = $link->getStatistic()->getClicks();

        return $clicks;
    }

    public function getLocalizationStatisticsForUrl($link)
    {
        $localizationRepository = $this->localizationStatisticRepository;
        $urlId = $link->getId();

        $localizationStatistics = $localizationRepository->findLocalizationWithOrderByClicks($urlId);

        return $localizationStatistics;
    }

}