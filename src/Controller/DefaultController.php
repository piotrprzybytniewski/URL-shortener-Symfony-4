<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 21.07.2018
 * Time: 13:51
 */

namespace App\Controller;


use App\Entity\Statistic;
use App\Entity\Url;
use App\Form\UrlType;
use App\Service\UrlGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(Request $request, EntityManagerInterface $em, UrlGeneratorService $urlGenerator)
    {
        $url = new Url();
        $form = $this->createForm(UrlType::class, $url);

        $form->handleRequest($request);

        $errors = $form->getErrors(true);

        if ($form->isSubmitted() && $form->isValid()) {
            $originalUrl = $form->get('originalUrl')->getData();
            $url->setOriginalUrl($originalUrl);

            $shortenedUrl = $urlGenerator->getRandomUrl();
            $url->setShortenedUrl($shortenedUrl);
            $statistic = new Statistic();
            $url->setStatistic($statistic);
            $em->persist($url);
            $em->flush();

            return $this->redirectToRoute('public_url_statistics', array(
                'url' => $url->getShortenedUrl(),
            ));

        }

        return $this->render('index.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,
        ));
    }



}