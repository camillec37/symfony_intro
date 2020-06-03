<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formulaire")
 */
class FormulaireController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request, SessionInterface $session)
    {
        if ($request->isMethod('POST')) {

            if(empty($_POST['email']) || empty($_POST['message'])){
                trigger_error('tous les champs doivent etre remplis');
            }

            $session->set('email', $_POST['email']);
            $session->set('message', $_POST['message']);

            $email = $session->get('email');
            $message = $session->get('message');


            return $this->redirectToRoute("app_formulaire_affichage",
            [
                'email' => $email,
                'message' => $message
            ]
        );
        }

        return $this->render('formulaire/index.html.twig');

    }


    /**
     * @Route("/affichage")
     */
    public function affichage()
    {
        //$session->clear();

        return $this->render('formulaire/affichage.html.twig');

    }





}
