<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 21.07.2018
 * Time: 13:47
 */

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
class UserManagerService
{
    /**
     * save EntityManager
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function addNewUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}