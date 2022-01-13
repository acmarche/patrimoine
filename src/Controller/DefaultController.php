<?php

namespace AcMarche\Patrimoine\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController.
 */
#[IsGranted(data: 'ROLE_PATRIMOINE_ADMIN')]
class DefaultController extends AbstractController
{
    #[Route(path: '/', name: 'patrimoine_home')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('patrimoine_index');
    }
}
