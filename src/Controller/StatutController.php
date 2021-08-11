<?php

namespace AcMarche\Patrimoine\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use AcMarche\Patrimoine\Entity\Statut;
use AcMarche\Patrimoine\Form\StatutType;
use AcMarche\Patrimoine\Repository\StatutRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/statut")
 * @IsGranted("ROLE_PATRIMOINE_ADMIN")
 */
class StatutController extends AbstractController
{
    private StatutRepository $statutRepository;

    public function __construct(StatutRepository $statutRepository)
    {
        $this->statutRepository = $statutRepository;
    }

    /**
     * @Route("/", name="patrimoine_statut_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/statut/index.html.twig',
            [
                'statuts' => $this->statutRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="patrimoine_statut_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->statutRepository->persist($statut);
            $this->statutRepository->flush();

            return $this->redirectToRoute('patrimoine_statut_show', ['id' => $statut->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/statut/new.html.twig',
            [
                'statut' => $statut,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_statut_show", methods={"GET"})
     */
    public function show(Statut $statut): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/statut/show.html.twig',
            [
                'statut' => $statut,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="patrimoine_statut_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Statut $statut): Response
    {
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->statutRepository->flush();


            return $this->redirectToRoute('patrimoine_statut_show', ['id' => $statut->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/statut/edit.html.twig',
            [
                'statut' => $statut,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_statut_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Statut $statut): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statut->getId(), $request->request->get('_token'))) {
            $this->statutRepository->remove($statut);
            $this->statutRepository->flush();
        }

        return $this->redirectToRoute('patrimoine_statut_index');
    }
}
