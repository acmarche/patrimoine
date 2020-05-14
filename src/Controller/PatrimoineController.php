<?php

namespace AcMarche\Patrimoine\Controller;

use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Form\PatrimoineType;
use AcMarche\Patrimoine\Form\SearchPatrimoineType;
use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/patrimoine")
 * @IsGranted("ROLE_PATRIMOINE_ADMIN")
 */
class PatrimoineController extends AbstractController
{
    /**
     * @var PatrimoineRepository
     */
    private $patrimoineRepository;

    public function __construct(PatrimoineRepository $patrimoineRepository)
    {
        $this->patrimoineRepository = $patrimoineRepository;
    }

    /**
     * @Route("/", name="patrimoine_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchPatrimoineType::class);

        $form->handleRequest($request);
        $patrimoines = $this->patrimoineRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $patrimoines = $this->patrimoineRepository->search(
                $data->getNom(),
                $data->getTypePatrimoine(),
                $data->getStatut()
            );
        }

        return $this->render(
            '@AcMarchePatrimoine/patrimoine/index.html.twig',
            [
                'patrimoines' => $patrimoines,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/new", name="patrimoine_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $patrimoine = new Patrimoine();
        $form = $this->createForm(PatrimoineType::class, $patrimoine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->patrimoineRepository->persist($patrimoine);
            $this->patrimoineRepository->flush();

            return $this->redirectToRoute('patrimoine_show', ['id' => $patrimoine->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/patrimoine/new.html.twig',
            [
                'patrimoine' => $patrimoine,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_show", methods={"GET"})
     */
    public function show(Patrimoine $patrimoine): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/patrimoine/show.html.twig',
            [
                'patrimoine' => $patrimoine,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="patrimoine_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Patrimoine $patrimoine): Response
    {
        $form = $this->createForm(PatrimoineType::class, $patrimoine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->patrimoineRepository->flush();

            return $this->redirectToRoute('patrimoine_show', ['id' => $patrimoine->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/patrimoine/edit.html.twig',
            [
                'patrimoine' => $patrimoine,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Patrimoine $patrimoine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patrimoine->getId(), $request->request->get('_token'))) {
            $this->patrimoineRepository->remove($patrimoine);
            $this->patrimoineRepository->flush();
        }

        return $this->redirectToRoute('patrimoine_index');
    }
}
