<?php


namespace App\Controller;


use App\Entity\Url;
use App\Repository\UrlRepository;
use App\Service\UrlGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
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
        EntityManagerInterface $em,
        UrlGeneratorService $urlGeneratorService,
        UrlRepository $urlRepository
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
        if ($request->isMethod(Request::METHOD_POST)) {
            $urls = $form->get('urls')->getData();
            $maxListId = $urlRepository->getMaxListId();

            foreach ($urls as $link) {
                $url = new Url();
                $shortenedUrl = $urlGeneratorService->getRandomUrl();
                $url->addUrl($link, $shortenedUrl);
                $em->persist($url);
            }
            $em->flush();


        }
        return $this->render('multiple_addresses.html.twig', [
            'form' => $form->createView(),
        ]);


    }
}