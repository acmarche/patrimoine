<?php


namespace AcMarche\Patrimoine\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AcMarche\Patrimoine\Controller
 * @IsGranted("ROLE_PATRIMOINE_ADMIN")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="patrimoine_home")
     */
    public function index()
    {
        return $this->redirectToRoute('patrimoine_index');
    }
}
