<?php


namespace App\Controller;

use App\Service\UrlsListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UrlsListController extends AbstractController
{

    /**
     * @Route("/list", name="list_of_urls")
     */
    public function showListOfUrls(
        Request $request,
        UrlsListService $urlsList
    ) {
        $formInput = trim($request->get('multiple_addresses'));
        $urls = preg_split("/[\s]+/", $formInput);

        $form = $this->createFormBuilder(['urls' => $urls])
            ->add('urls', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $urls = $form->get('urls')->getData();
            $userId = $this->getUser();

            $listUrl = $urlsList->addListOfUrls($urls, $userId);

            return $this->redirectToRoute('public_list_of_urls_statistics', ['url' => $listUrl]);
        }
        return $this->render('multiple_addresses.html.twig', [
            'form' => $form->createView(),
        ]);


    }
}