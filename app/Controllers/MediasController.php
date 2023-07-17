<?php

namespace App\Controllers;

use App\Models\MediaModel;

class MediasController
{
    private $mediaModel;



    public function __construct(MediaModel $mediaModel)
    {
        $this->mediaModel = $mediaModel;
    }


    public function uploadImage($userId)
    {
        if (isset($_FILES['img'])) {
            $targetDirectory = __DIR__ . "/../../public/img/";
            $targetFile = $targetDirectory . basename($_FILES['img']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Vérification de la taille du fichier (2 Mo maximum)
            $maxFileSize = 2 * 1024 * 1024; // 2 Mo
            if ($_FILES['img']['size'] > $maxFileSize) {
                echo "Le fichier est trop volumineux. Veuillez choisir un fichier de taille inférieure à 2 Mo.";
                return;
            }


            // Vérification de l'extension du fichier (seulement les formats JPEG, PNG et GIF)
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedExtensions)) {
                echo "Les extensions de fichiers autorisées sont : JPG, JPEG, PNG et GIF.";
                return;
            }

            // Vérification si le fichier est une image valide
            $check = getimagesize($_FILES['img']['tmp_name']);
            if ($check === false) {
                echo "Le fichier n'est pas une image valide.";
                return;
            }

            // Déplacement du fichier téléversé dans le dossier approprié
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
                echo "Une erreur s'est produite lors de l'upload du fichier.";
                return;
            }

            // Appeler addUserImg pour stocker les informations de l'image
            $imageName = basename($_FILES['img']['name']);
            $imagePath = 'public/img/' . $imageName;
            $this->mediaModel->addUserImg($imageName, $imagePath, $userId);
        }
    }
}
