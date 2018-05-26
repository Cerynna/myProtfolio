<?php

namespace App\Controller;

use App\Entity\Production;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @Route("/myProduction", name="production")
     */
    public function production()
    {
        $productions = $this->getDoctrine()->getRepository(Production::class)->findAll();

        return $this->render('main/production.html.twig', [
            'controller_name' => 'MainController',
            'productions' => $productions,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {

        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/cv", name="cv")
     */
    public function cv()
    {

        return $this->render('main/cv.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test()
    {

        return $this->render('main/test.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


}
