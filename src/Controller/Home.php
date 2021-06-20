<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Images\ImageAcumolator;


class Home extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param ImageAcumolator $imageAcumolator
     * @return Response
     */
    public function __invoke(Request $request, ImageAcumolator $imageAcumolator)
    {
        // array of urls rss && api
        $urlList = [
            "https://newsapi.org/v2/top-headlines?country=us&apiKey=c782db1cd730403f88a544b75dc2d7a0" => "api",
            "https://www.pinterest.co.uk/sucastro/animals.rss" => "rss",
        ];
        $imagesList = $imageAcumolator->handler($urlList);

        return $this->render('default/index.html.twig', array('images' => $imagesList));
    }
}
