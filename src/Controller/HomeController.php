<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ToolRepository;

Class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ToolRepository $toolRepository): Response
    {
        return $this->render('home.html.twig', ['tools' => $toolRepository->findAll()]);
    }

    #[Route('/curriculum', name: 'cv_show')]
    public function cvShow(): Response
    {
        return $this->render('curriculum.html.twig',);
    }
}