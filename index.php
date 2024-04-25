<?php
session_start();

function chargeClass($class)
{
    require $class . '.class.php';
}

spl_autoload_register('chargeClass');

$dataBase = new DataBase();
$baseClass = new BaseClass();
$firstPersonViewgetView = new FirstPersonView();
$firstPersonTextgetText = new FirstPersonText();

error_log("post " . print_r($_POST, 1));
//error_log("session " . print_r($_SESSION, 1));

if (empty($_POST)) {
    $baseClass->setCurrentX(0);
    $baseClass->setCurrentY(1);
    $baseClass->setCurrentAngle(0);

    $firstPersonViewgetView->setCurrentX(0);
    $firstPersonViewgetView->setCurrentY(1);
    $firstPersonViewgetView->setCurrentAngle(0);
    error_log("init");

} else {

    $baseClass->setCurrentX($_POST['currentX']);
    $baseClass->setCurrentY($_POST['currentY']);
    $baseClass->setCurrentAngle($_POST['currentAngle']);

    $firstPersonViewgetView->setCurrentX($_POST['currentX']);
    $firstPersonViewgetView->setCurrentY($_POST['currentY']);
    $firstPersonViewgetView->setCurrentAngle($_POST['currentAngle']);

    if (!isset($_SESSION['currentX'])) {
        $_SESSION['currentX'] = 1;
    }
    if (!isset($_SESSION['currentY'])) {
        $_SESSION['currentY'] = 2;
    }
    if (!isset($_SESSION['currentAngle'])) {
        $_SESSION['currentAngle'] = 0;
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action'])) { // verification supplémentaire
            $action = $_POST['action'];

            switch ($action) {
                case 'Forward':
                    //$_SESSION['currentX']++;
                    $baseClass->moveForward();
                    $firstPersonViewgetView->moveForward();
                    break;
                case 'Backward':
                    //$_SESSION['currentX']--;
                    $baseClass->moveBackward();
                    $firstPersonViewgetView->moveBackward();
                    break;
                case 'Left':
                    //$_SESSION['currentY']--;
                    $baseClass->moveLeft();
                    $firstPersonViewgetView->moveLeft();
                    break;
                case 'Right':
                    //$_SESSION['currentY']++;
                    $baseClass->moveRight();
                    $firstPersonViewgetView->moveRight();
                    break;
                case 'T.Left':
                    //$_SESSION['currentAngle']--;
                    $baseClass->turnLeft();
                 
                    break;
                case 'T.Right':
                    //$_SESSION['currentAngle']++;
                    $baseClass->turnRight();
                    
                    break;
            }

        }
    }
}

$imageSrc = $firstPersonViewgetView->getView($baseClass->getCurrentX(), $baseClass->getCurrentY(), $baseClass->getCurrentAngle());

error_log("Image source: " . $imageSrc);

preg_match('/Image Path: ..\/images\/(.*?)<\/p>/', $imageSrc, $matches);
$imageSrc = '/Projet_Serval_PHP_POO/images/' . ($matches[1] ?? '');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div id="fireCanvas"></div>
    <img class="logo" src="./assets/doom_logo.png" alt="Doom">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-top: 4rem;">
                <img src="<?php echo $imageSrc; ?>" alt="Game State"
                    style="border: 5px solid #edb750; margin-top: 4rem;">
                <div class="col-md-12 d-flex justify-content-center align-items-center">

                    <form action="index.php" method="POST" class="mx-auto my-auto">
                        <br>
                        <div class="container3 d-flex flex-column align-items-center">
                            <div>
                                <input type="submit" name="action" value="Forward" <?php 
                                if ($baseClass->checkMove($baseClass->getCurrentX(), $baseClass->getCurrentY(), $baseClass->getCurrentAngle(), 0)){
                                    echo "";
                                } else {
                                    echo "disabled";
                                } ?>>
    
                            </div>

                            <div class="d-flex justify-content-between mt-1rem " style="width: 500px;">

                            <input type="submit" name="action" value="T.Left" <?php echo $baseClass->checkTurnLeft() ? "" : "disabled";  ?>>
                                
                                <input type="submit" name="action" value="Left" <?php 
                                if ($baseClass->checkMove($baseClass->getCurrentX(), $baseClass->getCurrentY(), $baseClass->getCurrentAngle(), 1)){
                                    echo "";
                                } else {
                                    echo "disabled";
                                } ?>>
                                
                                <input type="submit" name="action" value="Right" <?php 
                                
                                if ($baseClass->checkMove($baseClass->getCurrentX(), $baseClass->getCurrentY(), $baseClass->getCurrentAngle(), 2)) {
                                    echo "";
                                } else {
                                    echo "disabled";
                                }
                                ?>>

                                <input type="submit" name="action" value="T.Right" <?php echo $baseClass->checkTurnRight() ? "" : "disabled"; ?>>
                            </div>

                            <div>
                                <input type="submit" name="action" value="Backward" <?php
                                  if ($baseClass->checkMove($baseClass->getCurrentX(), $baseClass->getCurrentY(), $baseClass->getCurrentAngle(), 4)) {
                                    echo "";
                                } else {
                                    echo "disabled";
                                }
                                ?>>
                            </div>

                            <input type="hidden" name="currentX" value="<?php echo $baseClass->getCurrentX() ?>">
                            <input type="hidden" name="currentY" value="<?php echo $baseClass->getCurrentY() ?>">
                            <input type="hidden" name="currentAngle" value="<?php echo $baseClass->getcurrentAngle() ?>">
                    </form>
                </div>
                <!-- <br>
                    <img class="img2" width="100%" src="./assets/compass.png" alt="compass"> -->
            </div>
            <div class="container2">
                <h1>
                    <?php
                    echo "Current X: " . $baseClass->getCurrentX() . "<br>";
                    echo "Current Y: " . $baseClass->getCurrentY() . "<br>";
                    echo "Current Angle: " . $baseClass->getcurrentAngle() . "<br>";
                    // echo $baseClass->checkMove($baseClass->getCurrentX(), $baseClass->getCurrentY(), $baseClass->getCurrentAngle()) ? "Move is possible" : "Move is not possible";
                   
                    $text = $firstPersonTextgetText->getText($X, $Y, $A);
                   
                    ?>
                </h1>
            </div>
        </div>
    </div>
    <button type="button" id="sound-button">Play Sound</button>
    <audio id="audio-player" src="assets/Doom OST - E1M1 - At Dooms Gate.mp3" preload="auto"></audio>


    <style>

    </style>

    <!-- // Must call my actions and define them within Ajax query  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        document.getElementById('sound-button').addEventListener('click', function () {
            let audioPlayer = document.getElementById('audio-player');
            if (audioPlayer.paused) {
                audioPlayer.play();
            } else {
                audioPlayer.pause();
            }
        });
    </script>
    <script src="fire.js"></script>
</body>

</html>