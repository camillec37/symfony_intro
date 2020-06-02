<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HopController extends AbstractController
{
    /**
     * @Route("/hop", name="hop")
     */
    public function index()
    {
        return $this->render('hop/index.html.twig', [
            'controller_name' => 'HopController',
        ]);
    }
}
