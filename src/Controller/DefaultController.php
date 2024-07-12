<?php

namespace AcMarche\Patrimoine\Controller;

use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_PATRIMOINE_ADMIN')]
class DefaultController extends AbstractController
{
    public function __construct(private readonly PatrimoineRepository $patrimoineRepository)
    {
    }

    #[Route(path: '/', name: 'patrimoine_home')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('patrimoine_index');
    }

    #[Route(path: '/api', name: 'patrimoine_api')]
    public function api(): JsonResponse
    {
        $data = [];
        foreach ($this->patrimoineRepository->findAllSorted() as $patrimoine) {
            $data[] = [
                'id' => $patrimoine->getId(),
                'nom' => $patrimoine->nom,
                'rue' => $patrimoine->rue,
                'numero' => $patrimoine->numero,
                'code_postal' => $patrimoine->getCodePostal(),
                'localite' => $patrimoine->localite,
                'latitude' => $patrimoine->latitude,
                'longitude' => $patrimoine->longitude,
                'descriptif' => $patrimoine->descriptif,
                'type' => $patrimoine->getTypePatrimoine(),
                'statut' => $patrimoine->getStatutTxt(),
                'geopoint' => $patrimoine->getGeopoint(),
                'images' => $patrimoine->getImages(),
                'photo' => $patrimoine->photo,
            ];
        }

        return $this->json($data);
    }
}
