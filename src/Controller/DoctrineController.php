<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/doctrine")
 */
class DoctrineController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('doctrine/index.html.twig', [
            'controller_name' => 'DoctrineController',
        ]);
    }


    /**
     * localhost:8000/doctrine/user/2
     * @Route("/user/{id}", requirements={"id": "\d+"})
     */
    public function getOneUser(UserRepository $repository, $id)
    {
        /**
         * retourne un objet User dont les attributs sont settés
         * à partir d'un selct sur la table user avec une clause where sur l'id
         * ou null si l'id n'existe pas dans la base
         */
        $user = $repository->find($id);

        dump($user);

        return $this->render(
            'doctrine/get_one_user.html.twig',
            [
                'user'=>$user
            ]
        );
    }

    /**
     * @Route("/users")
     */
    public function listUsers(UserRepository $repository)
    {

        //retourne tous les éléments de la table user sous la
        //forme d'un tableau d'objers User
        $users = $repository->findAll();

        dump($users);

        return $this->render('doctrine/list_users.html.twig',
        [
            'users' => $users
        ]);
    }

    /**
     * @Route("/search-email")
     */
    public function searchEmail(Request $request, UserRepository $repository)
    {
        $twidVariables = [];

        //if(isset($_GET['email']))
        if($request->query->has('email')){

            //findOneBy s'utilise quand on sait que les critères de filtre
            //ne peuvent renvoyer qu'un seul résultat (ici,
            //on a sétté email comme unique
            //retourne un objet ou null
            $user = $repository->findOneBy([
                //clause where sur l'email = $_GET['email']
                'email'=> $request->query->get('email')
            ]);

            $twidVariables['user'] = $user;
        }

        return $this->render('doctrine/search_email.html.twig',
            $twidVariables
        );
    }
}
