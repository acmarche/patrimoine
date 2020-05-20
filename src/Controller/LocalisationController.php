<?php


namespace AcMarche\Patrimoine\Controller;

use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Form\LocalisationType;
use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LocalisationController
 * @package AcMarche\Patrimoine\Controller
 * @Route("/localisation")
 */
class LocalisationController extends AbstractController
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
     * @IsGranted("ROLE_PATRIMOINE_ADMIN")
     * @Route("/{id}", name="patrimoine_localisation_update", methods={"POST"})
     */
    public function update(Request $request, Patrimoine $patrimoine)
    {
        $form = $this->createForm(LocalisationType::class, $patrimoine);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->patrimoineRepository->flush();
            $this->addFlash("success", "La situation a bien été modifiée");
        }

        return $this->redirectToRoute('patrimoine_show', ['id' => $patrimoine->getId()]);
    }
}
