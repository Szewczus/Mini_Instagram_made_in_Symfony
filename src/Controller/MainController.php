<?php


namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="mainPage")
     */
    function mainPage()
    {
        return $this->render('mainPage.html.twig');
    }
}