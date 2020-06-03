<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * Annotation de routing : définit quelle est l'URL de la page
     * que rend cette méthode
     *
     * on peut enlever le nom de la route, elle est nommée automatiquement
     * à partir du nom de la classe de contrôleur et du nom de la méthode
     * à laquelle elle correspond
     * (ici on a enlevé name="index", elle va s'appeler
     * app_index_index

     *
     * @Route("/")
     */
    public function index()
    {
        //la vue (=le html) de la page de cette méthode est générée
        //par le template contenu dans templates/index/index.html.twig
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
        //la deuxieme valeur de cette méthode est optionnelle mais doit être un tableau
        //qui contient le nom de la variable et éventuellement d'autres valeurs
        //en modèle cle=>variable
    }


    /**
     *  le nom de la route est app_index_hello
     * l'URL est
     * @Route("/hello-world")
     *
     */
    public function hello()
    {
        return $this->render('index/hello.html.twig');
    }


    /**
     * Partie variable de l'url entre accolades :
     * La route matche /bonjour/camille et /bonjour/ben
     * Le$qui en paramètre de la méthode contient la valeur
     * de la partie variable {qui} de l'url
     *
     * @Route("/bonjour/{qui}")
     */
    public function bonjour($qui)
    {
      return $this->render('index/bonjour.html.twig',
      //je passe une variable au template qui s'appelle nom
      //et qui a la valeur de $qui
      [
          'nom'=> $qui
      ]);
    }


    /**
     * La route matche /salut/camille
     * mais aussi /salut ou /salut/ qui affichera la valeur par défaut
     *
     * @Route("/salut/{qui}", defaults={"qui": "à toi"})
     */
    public function salut($qui)
    {
        return $this->render('index/salut.html.twig',
        [
            'qui'=> $qui
        ]);
    }


    /**
     * Une route avec 2 parties variables dont une optionnelle
     *
     * @Route("/coucou/{prenom}-{nom}", defaults={"nom": ""})
     */
    public function coucou($prenom, $nom)
    {
        $nomComplet = rtrim($prenom.' '.$nom);

        return $this->render('index/coucou.html.twig',[
            'nom'=> $nomComplet
        ]);
    }


    /**
     * id doit être un nombre (\d+ en expression régulière)
     *
     * @Route("/utilisateur/modification/{id}", requirements={"id": "\d+"})
     */
    public function userEdit($id)
    {
        return $this->render('index/user_edit.html.twig', [
            'id'=> $id
        ]);
    }
}
