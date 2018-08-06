<?php


namespace App\Service;


class UrlGenerator
{
    public function getRandomUrl()
    {
        $bytes = random_bytes(5);
        $random = bin2hex($bytes);
        if (strlen($random) > 5) {
            $url = substr($random, 0, 5);
        }
        return $url;
    }
}