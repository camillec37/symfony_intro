<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Avec l'annotation de Route au dessus de la classe
 * On définit un préfixe de route pour toutes les url
 * et inutile de les répéter
 *
 * @Route("/twig")
 */
class TwigController extends AbstractController
{
    /**
     * Avec le préfixe de route sur la classe, l'url de cette page
     * est /twig ou /twig/ automatiquement
     *
     * @Route("/")
     */
    public function index()
    {
        return $this->render('twig/index.html.twig',
            [
            'demain' => new \DateTime('+1day')
            ]);
    }
}
