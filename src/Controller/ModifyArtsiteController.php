<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Handler\UploadHandler;

final class ModifyArtsiteController extends AbstractController{
    #[Route('/api/artiste/modify/{id}', name: 'app_modify_artsite', methods: ['POST'])]
    public function index(
        int $id,
        Request $request,
        ArtisteRepository $artisteRepository,
        EntityManagerInterface $em,
        UploadHandler $uploadHandler

        ): JsonResponse
    {
        $data = $request->request->all();
        $file = $request->files->get('imageFile');

        
        $artiste = $artisteRepository->find($id);

        if (!$artiste) {
            return new JsonResponse(['error' => 'Artiste non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }
        
        if (isset($data['name'])) {
            $artiste->setName($data['name']);
        }

        if (isset($data['date'])) {
            $artiste->setDate(new \DateTimeImmutable($data['date']));
        }
        if (isset($data['time'])) {
            $artiste->setTime(new \DateTimeImmutable($data['time']));
        }
        if (isset($data['stage'])) {
            $artiste->setStage($data['stage']);
        }
        if (isset($data['style'])) {
            $artiste->setStyle($data['style']);
        }
        if (isset($data['description'])) {
            $artiste->setDescription($data['description']);
        }
        if (isset($data['videoLink'])) {
            $artiste->setVideoLink($data['videoLink']);
        }
        
        if ($file instanceof UploadedFile) {
            if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png'])) {
                return new JsonResponse(['error' => 'Format d’image non valide'], JsonResponse::HTTP_BAD_REQUEST);
            }
        
            try {
                $artiste->setImageFile($file);
                $uploadHandler->upload($artiste, 'imageFile');
            } catch (FileException $e) {
                return new JsonResponse(['error' => 'Erreur lors de l’upload de l’image'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        

        $em->persist($artiste);
        $em->flush();

        return new JsonResponse([
            'message' => 'Artiste modifié avec succès',
            'artiste' => [
                'id' => $artiste->getId(),
                'name' => $artiste->getName(),
                'date' => $artiste->getDate()?->format('Y-m-d'),
                'time' => $artiste->getTime()?->format('H:i:s'),
                'stage' => $artiste->getStage(),
                'style' => $artiste->getStyle(),
                'description' => $artiste->getDescription(),
                'videoLink' => $artiste->getVideoLink(),
                'imageName' => $artiste->getImageName()
            ]
        ]);
    }
}
