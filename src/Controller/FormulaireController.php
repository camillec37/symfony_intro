<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        $erreur ='';

        if ($request->isMethod('POST')) {

            //$data contient tout le tableau de $_POST
            $data = $request->request->all();

            if(!empty($data['email']) && !empty($data['message'])){

                $session->set('email', $data['email']);
                $session->set('message', $data['message']);

                return $this->redirectToRoute("app_formulaire_affichage");

            } else {
                $erreur = 'Tous les champs doivent etre remplis';
            }

        }

        return $this->render('formulaire/index.html.twig',
        [
            'erreur' => $erreur
        ]);

    }


    /**
     * nom de la route app_formulaire_affichage
     * @Route("/affichage")
     */
    public function affichage(SessionInterface $session)
    {
        if(empty($session->all())) {
            return $this->redirectToRoute('app_formulaire_index');
        }

        $message = $session->get('message');
        $email =   $session->get('email');

        $session->clear();

        return $this->render('formulaire/affichage.html.twig',
            [
                'email' => $email,
                'message' => $message
            ]);
    }

}
