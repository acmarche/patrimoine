<?php


namespace AcMarche\Patrimoine\Controller;

use AcMarche\Bottin\Entity\Fiche;
use AcMarche\Bottin\Entity\FicheImage;
use AcMarche\Patrimoine\Entity\Image;
use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Form\ImageType;
use AcMarche\Patrimoine\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\UploadHandler;

/**
 * Class DefaultController
 * @package AcMarche\Patrimoine\Controller
 */
class ImageController extends AbstractController
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var UploadHandler
     */
    private $uploadHandler;

    public function __construct(
        ImageRepository $imageRepository,
        UploadHandler $uploadHandler
    ) {
        $this->imageRepository = $imageRepository;
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * @Route("/images/{id}", name="patrimoine_images")
     */
    public function index(Patrimoine $patrimoine)
    {
        $image = new Image($patrimoine);
        $form = $this->createForm(
            ImageType::class,
            $image,
            [
                'action' => $this->generateUrl('patrimoine_image_upload', ['id' => $patrimoine->getId()]),
            ]
        );

        return $this->render(
            '@AcMarchePatrimoine/image/edit.html.twig',
            [
                'patrimoine' => $patrimoine,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/image/upload/{id}", name="patrimoine_image_upload")
     *
     */
    public function upload(Request $request, Patrimoine $patrimoine)
    {
        $image = new Image($patrimoine);
        /**
         * @var UploadedFile $file
         */
        $file = $request->files->get('file');

        $nom = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
        $image->setMime($file->getMimeType());
        $image->setFileName($file->getClientOriginalName());
        $image->setFile($file);

        try {
            $this->uploadHandler->upload($image, 'file');
        } catch (\Exception $exception) {
            return $this->render(
                '@AcMarchePatrimoine/upload/_response_fail.html.twig',
                ['error' => $exception->getMessage()]
            );
        }

        $this->imageRepository->persist($image);
        $this->imageRepository->flush();

        return $this->render('@AcMarchePatrimoine/upload/_response_ok.html.twig');
    }

    /**
     * Finds and displays a Image entity.
     *
     * @Route("/image/{id}", name="patrimoine_image_show", methods={"GET"})
     */
    public function show(Image $image)
    {
        return $this->render(
            '@AcMarchePatrimoine/image/show.html.twig',
            [
                'image' => $image,
                'patrimoine' => $image->getPatrimoine(),
            ]
        );
    }

    /**
     * @Route("/image/{id}", name="patrimoine_image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Image $image): Response
    {
        $patrimoine = $image->getPatrimoine();
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $this->imageRepository->remove($image);
            $this->imageRepository->flush();
            $this->addFlash('success', "L'image a bien été supprimée");
        }

        return $this->redirect($this->generateUrl('patrimoine_show', ['id' => $patrimoine->getId()]));
    }
}
