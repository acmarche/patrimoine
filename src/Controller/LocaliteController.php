<?php

namespace AcMarche\Patrimoine\Controller;

use AcMarche\Patrimoine\Entity\Localite;
use AcMarche\Patrimoine\Form\LocaliteType;
use AcMarche\Patrimoine\Repository\LocaliteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/localite")
 * @IsGranted("ROLE_PATRIMOINE_ADMIN")
 */
class LocaliteController extends AbstractController
{
    private LocaliteRepository $localiteRepository;

    public function __construct(LocaliteRepository $localiteRepository)
    {
        $this->localiteRepository = $localiteRepository;
    }

    /**
     * @Route("/", name="patrimoine_localite_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/localite/index.html.twig',
            [
                'localites' => $this->localiteRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="patrimoine_localite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $localite = new Localite();
        $form = $this->createForm(LocaliteType::class, $localite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->localiteRepository->persist($localite);
            $this->localiteRepository->flush();

            return $this->redirectToRoute('patrimoine_localite_show', ['id' => $localite->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/localite/new.html.twig',
            [
                'localite' => $localite,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_localite_show", methods={"GET"})
     */
    public function show(Localite $localite): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/localite/show.html.twig',
            [
                'localite' => $localite,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="patrimoine_localite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Localite $localite): Response
    {
        $form = $this->createForm(LocaliteType::class, $localite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->localiteRepository->flush();


            return $this->redirectToRoute('patrimoine_localite_show', ['id' => $localite->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/localite/edit.html.twig',
            [
                'localite' => $localite,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_localite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Localite $localite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$localite->getId(), $request->request->get('_token'))) {
            $this->localiteRepository->remove($localite);
            $this->localiteRepository->flush();
        }

        return $this->redirectToRoute('patrimoine_localite_index');
    }
}
