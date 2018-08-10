<?php


namespace App\Controller;


use App\Entity\Url;
use App\Form\UrlType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlsListController extends AbstractController
{

    /**
     * @Route("/list", name="list_of_urls")
     */
    public function showListOfUrls(Request $request, EntityManagerInterface $em)
    {
        $formInput = trim($request->get('multiple_addresses'));
        $urls = preg_split("/[\s]+/", $formInput);


        $form = $this->createFormBuilder(array('urls' => $urls))
            ->add('urls', CollectionType::class, array(
                'entry_type' => TextType::class,
                'allow_add' => true,
            ))
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $urls = $form->getData();
//          $urls = new ArrayCollection($urls);


            foreach ($urls as $link) {
                $url = new Url();
                $url->addUrl($link);
                $em->persist($url);
            }

            $em->flush();

//
//            foreach ($urls as $link) {
//                $url = new Url();
//                $url->setOriginalUrl($link);
//                $url->setShortenedUrl($link);
//                $em->persist($url);
//                $em->flush();
//
//            }
        }
        return $this->render('multiple_addresses.html.twig', array(
            'form' => $form->createView(),
        ));


    }
}