<?php

namespace AcMarche\Patrimoine\Controller;

use AcMarche\Patrimoine\Entity\Image;
use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Form\ImageType;
use AcMarche\Patrimoine\Repository\ImageRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Handler\UploadHandler;

#[IsGranted('ROLE_PATRIMOINE_ADMIN')]
class ImageController extends AbstractController
{
    public function __construct(private ImageRepository $imageRepository, private UploadHandler $uploadHandler)
    {
    }

    #[Route(path: '/images/{id}', name: 'patrimoine_images')]
    public function index(Patrimoine $patrimoine): Response
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

    #[Route(path: '/image/upload/{id}', name: 'patrimoine_image_upload', methods: ['POST'])]
    public function upload(Request $request, Patrimoine $patrimoine): RedirectResponse
    {
        $file = $request->files->get('file');
        if ($file instanceof UploadedFile) {
            $image = new Image($patrimoine);
            //$nom = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            $image->setMime($file->getMimeType());
            $image->setFileName($file->getClientOriginalName());
            $image->setFile($file);

            try {
                $this->uploadHandler->upload($image, 'file');
            } catch (Exception $exception) {
                $this->addFlash('danger', $exception->getMessage());
            }
            $this->imageRepository->persist($image);
        }
        $this->imageRepository->flush();

        return $this->redirectToRoute('patrimoine_show', ['id' => $patrimoine->getId()]);
    }

    /**
     * Finds and displays a Image entity.
     */
    #[Route(path: '/image/{id}', name: 'patrimoine_image_show', methods: ['GET'])]
    public function show(Image $image): Response
    {
        return $this->render(
            '@AcMarchePatrimoine/image/show.html.twig',
            [
                'image' => $image,
                'patrimoine' => $image->getPatrimoine(),
            ]
        );
    }

    #[Route(path: '/image/{id}', name: 'patrimoine_image_delete', methods: ['DELETE'])]
    public function delete(Request $request, Image $image): RedirectResponse
    {
        $patrimoine = $image->getPatrimoine();
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $this->imageRepository->remove($image);
            $this->imageRepository->flush();
            $this->addFlash('success', "L'image a bien été supprimée");
        }

        return $this->redirectToRoute('patrimoine_show', ['id' => $patrimoine->getId()]);
    }
}
