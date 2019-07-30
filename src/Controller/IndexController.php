<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
/**
    //  * @Route("/", name="index")
     * @Route("/{route}", name="vue_pages", requirements={"route"="^.+"})
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('base.html.twig', []);
    }
}
