<?php


namespace App\Service;


use Symfony\Component\Security\Core\Security;

class StatisticsAccessService
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function userIsAuthorOfList($list)
    {
        $urls = $list->getListOfUrls();
        $userId = $this->security->getUser();
        if (isset($userId)) {
            $userId = $userId->getId();
        }
        $userIdOfUrl = $urls->first()->getUserId();
        if (isset($userIdOfUrl)) {
            $userIdOfUrl = $userIdOfUrl->getId();
        }

        return (bool) $userIdOfUrl == $userId;

    }

    public function userIsAuthorOfSingleUrl($link)
    {
        $userId = $this->security->getUser();
        if (isset($userId)) {
            $userId = $userId->getId();
        }
        $userIdOfLink = $link->getUserId();

        return (bool) $userIdOfLink == $userId;
    }
}