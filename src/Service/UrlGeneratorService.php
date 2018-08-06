<?php


namespace App\Service;


use App\Repository\UrlRepository;
use Exception;

class UrlGeneratorService
{

    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function getRandomUrl()
    {

        do {
            try {
                $bytes = random_bytes(5);
            } catch (Exception $e) {
                $this->get('session')->setFlash('error', "Url generator failed. Try again!");
            }
            $random = bin2hex($bytes);

            if (strlen($random) > 5) {
                $url = substr($random, 0, 5);
            }
            $urlInDatabase = $this->urlRepository->findOneBy([
                'shortenedUrl' => $url,
            ]);

        } while ($urlInDatabase);

        return $url;
    }
}