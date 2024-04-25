<?php 

class FirstPersonText extends BaseClass
{
    const TEXT_TABLE = 'fpview_Partie1/';
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();

        error_log("FirstPersonText _constructed");
    }

    private $_currentMapId;

    public function setMapId(int $currentMapId)
    {
        if ($currentMapId && $currentMapId > 0) {
            $this->_currentMapId = $currentMapId;
        }
    }

    public function getMapId()
    {
        error_log("Getting Map ID: " . $this->_currentMapId);
        return $this->_currentMapId;
    }
    
    public function getText($X, $Y, $A) {
        error_log("getText : ".$X . " " . $Y . " " . $A);

        $sql = "SELECT text FROM fpview JOIN map ON map.id = fpview_Partie1.map_id WHERE coordx=:currentX AND coordy=:currentY AND direction=:currentAngle";

        try {
            $stmt = $this->dataBase->prepare($sql);

            $stmt->bindParam(':currentX', $X, PDO::PARAM_INT);
            $stmt->bindParam(':currentY', $Y, PDO::PARAM_INT);
            $stmt->bindParam(':currentAngle', $A, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("result" . print_r($result, 1));

            if ($result && isset($result['text'])) {
                return $result['text'];
            } else {
                return "Vous regardez autour de vous mais rien d'intéressant à signaler.";
            }
        } catch (PDOException $e) {
            error_log("Error while executing SQL query: " . $e->getMessage());
            return "Une erreur s'est produite lors de la récupération du texte.";
        }
    }
}


// INSERT INTO `text` (id, map_id, `text`)
// VALUES 
// (1, 1, 'Je dois trouver une clé pour sortir d\'ici...'),
// (2, 2, 'Un mur m\'empêche de passer...'),
// (3, 3, 'Je dois trouver une clé pour sortir d\'ici...'),
// (7, 9, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur'),
// (6, 4, 'Rien par ici'),
// (11, 14, 'Voici un bien joli vase !'),
// (8, 10, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur'),
// (9, 11, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur'),
// (10, 12, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur');