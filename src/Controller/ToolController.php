<?php

namespace App\Controller;

use App\Entity\Tool;
use App\Form\ToolType;
use App\Repository\ToolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tool')]
class ToolController extends AbstractController
{
    #[Route('/', name: 'tool_index', methods: ['GET'])]
    public function index(ToolRepository $toolRepository): Response
    {
        return $this->render('tool/index.html.twig', [
            'tools' => $toolRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'tool_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tool = new Tool();
        $form = $this->createForm(ToolType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('tool_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tool/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tool_show', methods: ['GET'])]
    public function show(Tool $tool): Response
    {
        return $this->render('tool/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    #[Route('/{id}/edit', name: 'tool_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tool $tool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToolType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tool_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tool/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tool_delete', methods: ['POST'])]
    public function delete(Request $request, Tool $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tool_index', [], Response::HTTP_SEE_OTHER);
    }

    public function showAll(ToolRepository $toolRepository): Response
    {
        return $this->render('home.html.twig', [
            'tools' => $toolRepository->findAll(),
        ]);
    }
}
