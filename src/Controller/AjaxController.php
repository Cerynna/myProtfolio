<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index()
    {
        return $this->render('ajax/index.html.twig', [
            'controller_name' => 'AjaxController',
        ]);
    }

    /**
     * @Route("/ajax/contact", name="sendContact")
     * @param Request $request
     * @return JsonResponse
     */
    public function addRoster(Request $request)
    {
        if ($request->isXmlHttpRequest()) {



            return new JsonResponse("LOL");
        } else {
            return new JsonResponse("BAD REQUEST", "400");
        }
    }

}
