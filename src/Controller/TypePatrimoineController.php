<?php

namespace AcMarche\Patrimoine\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use AcMarche\Patrimoine\Entity\TypePatrimoine;
use AcMarche\Patrimoine\Form\TypePatrimoineType;
use AcMarche\Patrimoine\Repository\TypePatrimoineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type")
 * @IsGranted("ROLE_PATRIMOINE_ADMIN")
 */
class TypePatrimoineController extends AbstractController
{
    private TypePatrimoineRepository $typeRepository;

    public function __construct(TypePatrimoineRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * @Route("/", name="patrimoine_type_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/type/index.html.twig',
            [
                'types' => $this->typeRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="patrimoine_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $type = new TypePatrimoine();
        $form = $this->createForm(TypePatrimoineType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->typeRepository->persist($type);
            $this->typeRepository->flush();

            return $this->redirectToRoute('patrimoine_type_show', ['id' => $type->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/type/new.html.twig',
            [
                'type' => $type,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_type_show", methods={"GET"})
     */
    public function show(TypePatrimoine $type): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/type/show.html.twig',
            [
                'type' => $type,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="patrimoine_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypePatrimoine $type): Response
    {
        $form = $this->createForm(TypePatrimoineType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeRepository->flush();


            return $this->redirectToRoute('patrimoine_type_show', ['id' => $type->getId()]);
        }

        return $this->render(
            '@AcMarchePatrimoine/type/edit.html.twig',
            [
                'type' => $type,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="patrimoine_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypePatrimoine $type): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $this->typeRepository->remove($type);
            $this->typeRepository->flush();
        }

        return $this->redirectToRoute('patrimoine_type_index');
    }
}
