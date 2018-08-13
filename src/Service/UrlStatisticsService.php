<?php


namespace App\Service;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class UrlStatisticsService
{

    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }


    public function updateStatistics($id)
    {
        $em = $this->em;

        $connection = $em->getConnection();
        try {
            $connection->executeUpdate('UPDATE statistic SET clicks = (clicks + 1) WHERE url_id_id = ?', array($id));
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
        }

    }
}