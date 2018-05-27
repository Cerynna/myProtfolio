<?php

namespace App\Controller;

use App\Entity\Contact;
use ReCaptcha\ReCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends Controller
{
    const SECRET_RECAPTCHA = "6LdvqlsUAAAAAAZ_Zs5PRBoIe3I6Yu_74Mup-24N";

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
            $em = $this->getDoctrine()->getManager();

            $data = $request->get('data');
            $arrField = [];
            foreach ($data as $field) {
                $arrField[$field["name"]] = $field["value"];
            }
            $contact = new Contact();
            $contact->setLastName($arrField["lastName"]);
            $contact->setFirstName($arrField["firstName"]);

            if (filter_var($arrField["email"], FILTER_VALIDATE_EMAIL)) {
                $contact->setEmail($arrField["email"]);
            } else {
                return new JsonResponse([
                    "wtf" => [
                        "text" => "L'email rentré n'est pas valide"
                    ]]);
            }
            if (strlen($arrField["message"]) >= 5) {
                $contact->setMessage($arrField["message"]);
            } else {
                return new JsonResponse([
                    "wtf" => [
                        "text" => "Il va falloir m'en dire un peu plus"
                    ]]);
            }
            $contact->setStatus(Contact::STATUS["waiting"]);
            $contact->setDate(new \DateTime('now'));


            if (isset($arrField["g-recaptcha-response"])) {
                $recaptcha = new ReCaptcha(self::SECRET_RECAPTCHA);
                $resp = $recaptcha->verify($arrField["g-recaptcha-response"], $_SERVER['REMOTE_ADDR']);
                if (!$resp->isSuccess()) {
                    return new JsonResponse([
                        "wtf" => [
                            "text" => "Tu as oublier de dire que tu n'etais pas un robot.",
                        ]]);
                }
            }

            $verif = $em->getRepository(Contact::class)->verifEmail($contact);
            if (is_array($verif)) {
                return new JsonResponse($verif);
            }

            $em->persist($contact);
            $em->flush();


            return new JsonResponse([
                "valid" => [
                    "text" => "Ton message m'as bien été transmit."
                ]]);
        } else {
            return new JsonResponse("BAD REQUEST", "400");
        }
    }

}
