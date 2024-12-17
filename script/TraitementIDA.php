<?php 
    session_start();
    session_regenerate_id();

    $_SESSION['code1'] = rand(1, 1); // Jusqu'a 9
        $_SESSION['code2'] = rand(1, 1); // Jusqu'a 12
        
        $code1 = $_SESSION['code1'];
        $code2 = $_SESSION['code2'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleIDA.css">
    <title>IDA</title>
</head>
<body>
    <a href="PageIDA.php"><<<</a>
    <?php

        if(isset($_GET['envoyer']))
        {
            

            switch ($code1) {
                case 1:
                    $filleul = "<h3>SORO S. KASSINIBIN</h3>";
                    break;
                case 2:
                    $filleul = "<h3>DJANE S. CYRILLE</h3>";
                    break;
                case 3:
                    $filleul = "<h3></h3>";
                    break;
                case 4:
                    $filleul = "<h3></h3>";
                    break;
                case 5:
                    $filleul = "<h3></h3>";
                    break;
                case 6:
                    $filleul = "<h3></h3>";
                    break;
                case 7:
                    $filleul = "<h3></h3>";
                    break;
                case 8:
                    $filleul = "<h3></h3>";
                    break;
                case 9:
                    $filleul = "<h3></h3>";
                    break;

                default:
                    break;
            }

            switch ($code2) {
                case 1:
                    $parrain = "<h3>SORO M. ADAMA</h3>";
                    break;
                case 2:
                    $parrain = "<h3></h3>";
                    break;
                case 3:
                    $parrain = "<h3></h3>";
                    break;
                case 4:
                    $parrain = "<h3></h3>";
                    break;
                case 5:
                    $parrain = "<h3></h3>";
                    break;
                case 6:
                    $parrain = "<h3></h3>";
                    break;
                case 7:
                    $parrain = "<h3></h3>";
                    break;
                case 8:
                    $parrain = "<h3></h3>";
                    break;
                case 9:
                    $parrain = "<h3></h3>";
                    break;
                case 10:
                    $parrain = "<h3></h3>";
                    break;
                case 11:
                    $parrain = "<h3></h3>";
                    break;
                case 12:
                    $parrain = "<h3></h3>";
                    break;

                default:
                    break;
            }

    ?>
        <h1 class="titre">PARRAINAGE IDA </h1>
        <div class="main">
            <div class="left">
                <h2 class="">PARRAIN</h2>
                <img src="../IDA2/<?php echo $code2 ?>.jpg"><?php echo $parrain; ?>
            </div>
            <div class="righ">
                <h2 class="">FILLEUL</h2>
                <img src="../IDA1/<?php echo $code1; ?>.jpg"><?php echo $filleul; ?>
            </div>
        </div>
        <a href="TraitementIDA.php?action=certificat"> Certificat </a>
    <?php
        }
        if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] = 'certificat')
        {
            switch ($code1) {
                case 1:
                    $filleul = "<h3>SORO S. KASSINIBIN</h3>";
                    break;
                case 2:
                    $filleul = "<h3>DJANE S. CYRILLE</h3>";
                    break;
                case 3:
                    $filleul = "<h3></h3>";
                    break;
                case 4:
                    $filleul = "<h3></h3>";
                    break;
                case 5:
                    $filleul = "<h3></h3>";
                    break;
                case 6:
                    $filleul = "<h3></h3>";
                    break;
                case 7:
                    $filleul = "<h3></h3>";
                    break;
                case 8:
                    $filleul = "<h3></h3>";
                    break;
                case 9:
                    $filleul = "<h3></h3>";
                    break;

                default:
                    break;
            }

            switch ($code2) {
                case 1:
                    $parrain = "<h3>SORO M. ADAMA</h3>";
                    break;
                case 2:
                    $parrain = "<h3></h3>";
                    break;
                case 3:
                    $parrain = "<h3></h3>";
                    break;
                case 4:
                    $parrain = "<h3></h3>";
                    break;
                case 5:
                    $parrain = "<h3></h3>";
                    break;
                case 6:
                    $parrain = "<h3></h3>";
                    break;
                case 7:
                    $parrain = "<h3></h3>";
                    break;
                case 8:
                    $parrain = "<h3></h3>";
                    break;
                case 9:
                    $parrain = "<h3></h3>";
                    break;
                case 10:
                    $parrain = "<h3></h3>";
                    break;
                case 11:
                    $parrain = "<h3></h3>";
                    break;
                case 12:
                    $parrain = "<h3></h3>";
                    break;

                default:
                    break;
            }
    ?>
    <br><br>
        <div class="certificat">
            <h1 class="entete">CERTIFICAT DE PARRAINAGE IDA ESETEC 2021</h1>
            <img class="logo1" src="../img/ETC.jpg"><img class="logo2" src="../img/SCI.png">
            <p>Nous déclaront que</p><br/>
            <em><?php echo $filleul; ?></em>
            <div class="vide"><div><br/>
            <p>
                a été
                <?php 
                    switch ($code1) {
                        case 1:
                            echo "parrainée";
                            break;
                        case 2:
                            echo "parrainé";
                            break;
                        case 3:
                            echo "parrainée";
                            break;
                        case 4:
                            echo "parrainée";
                            break;
                        case 5:
                            echo "parrainée";
                            break;
                        case 6:
                            echo "parrainée";
                            break;
                        case 7:
                            echo "parrainée";
                            break;
                        case 8:
                            echo "parrainée";
                            break;
                        case 9:
                            echo "parrainée";
                            break;
        
                        default:
                            break;
                    }
                ?>
                le 20 février 2021 par </p><br/>
                <em><?php echo $parrain; ?></em>

                <img src="../img/logoIDA.jpg" class="logoIDA">
        </div>
    <?php
        }
    ?>

</body>
</html>