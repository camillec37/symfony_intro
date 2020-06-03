<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/http")
 */
class HttpController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('http/index.html.twig', [
            'controller_name' => 'HttpController',
        ]);
    }


    /**
     * @Route("/requete")
     */
    public function requete(Request $request)
        //comme on envoie un parametre typé sur une classe Request
        //grace au 'paramètre de controller'
        //renvoie une instance unique dela classe request inclus dans le framework
    {
        //http://localhost:8000/http/requete?nom=Marx&prenom=Groucho
        dump($_GET); // apparait en bas de la page caché

        //permet de récupérer un objet qui est une surcouche à $_GET et de la manipuler comme un objet
        //au lieu d'un tableau
        dump($request->query->all());

        //pour récupérer un seul élément précisement
        //éviter les echo dans les méthodes c'est juste pour l'exemple
        echo $request->query->get('prenom');//$_GET['prenom'] Groucho

        //acces a un élément qui n'existe pas dans $_GET
        dump($request->query->get('adresse'));
        //null mais pas de notice lancée si la cle n'existe pas
        //alors que notice si on avait fait dump($_GET['adresse'])

        //on peut mettre une valeur par defaut en deuxième paramètre qui
        //s'applique si la clé n'existe pas
        dump($request->query->get('adresse', '8 rue constance'));

        //équivalent de isset($_GET['adresse']) - renvoie un booleen
        dump($request->query->has('adresse'));//false

        //renvoie la méthode Get ou Post en chaine de caractère
        echo '<br>' . $request->getMethod();

        //si la page a été appelée en POST
        if($request->isMethod('POST')){
            //affiche ce qu'il y a dedans dans la barre de debug
            //$request->request contient un objet qui est une surcouche à $_POST
            //et contient les même méthodes que $request->query
            dump($request->request->all());

            //pour l'afficher
            echo $request->request->get('nom');
        }

        //$request->getSession();

        return $this->render('http/requete.html.twig');
    }



    /**
     * On utilise un paramètre typé SessionInterface
     * pour accéder à la session dans une méthode de contrôleur
     *
     * @Route("/session")
     */
    public function session(SessionInterface $session)
    {
        //pour ajouter des éléments à la session:
        $session->set('prenom','Camille');
        $session->set('nom','Clerc');

        //les éléments enregistrés par l'objet Session le sont dans
        //$_SESSION['_sf2_attributes']
        dump($_SESSION);

        //pour y accéder directement
        dump($session->all());

        //pour accéder a un élément en particulier
        echo $session->get('prenom');

        //pour supprimer un élément de la session
        $session->remove('nom');

        dump($session->all());

        //pour vider entièrement la session
        $session->clear();

        dump($session->all());

        return $this->render('http/session.html.twig');

    }


    /**
     * Une méthode de cntroleur doit nécessairement retourner
     * un objet instance de la classe Response
     *
     * @Route("/reponse")
     */
    public function reponse(Request $request)
    {
        //http:localhost:8000/http/reponse?type=text
        if($request->query->get('type')=='text'){

            $response = new Response('Contenu en texte brut');

            return $response;

         //http:localhost:8000/http/reponse?type=json
        } elseif($request->query->get('type')=='json'){

            $response = [
                'nom' => 'Marx',
                'prenom' => 'Groucho'
            ];

            //return new Response(json_encode($response));
            //ou

            //transforme directement en chaine applique le json_encode
            //et retourne une réponse avec l'entête HTTP Content-Type :
            //application/json au lieu de text/html (voir dans l'editeur
            //reseau entête) c'est la difference avec le précédent
            return new JsonResponse($response);


        //http:localhost:8000/http/reponse?found=no
        } elseif($request->query->get('found')=='no'){

            //pour retourner une 404, on jette cette exception
            throw new NotFoundHttpException();

        //http:localhost:8000/http/reponse?redirect=index
        } elseif ($request->query->get('redirect')=='index'){

            //redirection vers une page en passant le nom de sa route
            //ici la page d'accueil
            return $this->redirectToRoute("app_index_index");

        //http:localhost:8000/http/reponse?redirect=bonjour
        } elseif ($request->query->get('redirect')=='bonjour') {

            //redirection vers une route qui contient un partie variable
            return $this->redirectToRoute(
                "app_index_bonjour",
                [
                    'qui'=>'le monde',
                ]
            );
        }

    //retourne un objet Response dont le contenu est
    //le html construit par le template
    return $this->render('http/reponse.html.twig');
    }


}
