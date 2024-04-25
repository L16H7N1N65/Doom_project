<?php

class FirstPersonView extends BaseClass
{
    // Folder images
    const IMAGES_FOLDER = '../images/';
    // connexion à la base des données
    private $dataBase;
    // methode construct pour la connexion à la base
    public function __construct()
    {
        $this->dataBase = new DataBase;
        error_log("FirstPersonView _constructed");
    }
    
    // propriété (int) l’identifiant de la position courante sur la carte
    private $_currentMapId;

    

    public function setMapId(int $currentMapId)
    {
        if ($currentMapId && $currentMapId > 0) {
            $this->_currentMapId = $currentMapId;
            error_log("Map ID set to: " . $currentMapId);
        }
    }

    public function getMapId()
    {
        error_log("Getting Map ID: " . $this->_currentMapId);
        return $this->_currentMapId;
    }
// Methode renvoie le chemin vers le fichier image à afficher


    public function getView($X, $Y, $A)
    {
        error_log("getView : ".$X . " " . $Y . " " . $A);
        $imageSrc = "SELECT path FROM images JOIN map ON map.id = images.map_id WHERE coordx=:currentX AND coordy=:currentY AND direction=:currentAngle";
        $stmt = $this->dataBase->prepare($imageSrc);

        $stmt->bindParam('currentX', $X, PDO::PARAM_INT);
        $stmt->bindParam('currentY', $Y, PDO::PARAM_INT);
        $stmt->bindParam('currentAngle', $A, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("result" . print_r($result, 1));

        $view = '';
        $view .= '<p>Position: ' . $X . ', ' . $Y . '</p>';
        $view .= '<p>Direction: ' . $A . '</p>';

        if (!empty($result) && isset($result['path'])) {
            $view .= '<p>Image Path: ' . self::IMAGES_FOLDER . $result['path'] . '</p>';
        } else {
            $view .= '<p>Image Path: ' . self::IMAGES_FOLDER . '01-0.jpg' . '</p>';
        }

        return $view;
    }

    // Returns the animation compass for the current direction
    public function getAnimCompass()
    {
        $direction = $this->getCurrentAngle();
        error_log("Getting Animation Compass for direction: " . $direction);
        switch ($direction) {
            case 0:
                return "rotate(0deg)";
            case 90:
                return "rotate(90deg)";
            case 180:
                return "rotate(180deg)";
            case 270:
                return "rotate(270deg)";
            default:
                return "rotate(0deg)";
        }
    }
}

