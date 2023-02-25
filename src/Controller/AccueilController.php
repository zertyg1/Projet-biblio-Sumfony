<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use App\Repository\NationaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/accueil")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil/{nom}", name="app_accueil")
     * 
     */
    
    public function index($nom): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'info' => 'Ce site est en développement',
            'nom' => $nom

        ]);
    }
    /**  @Route("/accueil/{nom}/secondPage", name="app_secondPage") */
    public function secondPage(Request $request, $nom): Response
    {
        $nom .= " Robillard";

        return $this->render('accueil/secondPage.html.twig', [
            'controller_name' => 'AccueilController',
            'info' => 'Ce site est en développement',
            'nom' => $nom
        ]);
    }
}