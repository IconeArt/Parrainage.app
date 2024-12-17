<?php
    require "session.php";
    require "db_config.php";
    init_session();
    $error = "";
    if( isset($_GET['envoi']) && !empty($_GET['envoi']) )
    {
        $filiere = htmlspecialchars($_GET['fil']);
        echo $filiere.'<br><br><br>'; //exit;
        try
            {
                $options = 
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];
    
                $PDO = new PDO($driver_db, $utilisateur_db, $pass_utilisateur_db, $options);

                $id_fil = $PDO->prepare("SELECT id_fil FROM filieres WHERE sigle_fil = :filiere;");
                $id_fil->bindParam("filiere", $filiere);
                $id_fil->execute();
                $fil = $id_fil->fetch(PDO::FETCH_ASSOC);
                $id_filiere = $fil['id_fil'];

                // Recuperation des photos et des matricules parrains dans un tableau associatif

                $sqllisteparrain = $PDO->prepare("SELECT * FROM parrains WHERE filiere_parrain = :parr;");
                $sqllisteparrain->bindParam("parr", $id_filiere);                            
                $sqllisteparrain->execute();
                $listeparrain = $sqllisteparrain->fetchAll(PDO::FETCH_ASSOC);
                
                // Mise des photos et des matricules des parrains dans un tableau indicé

                $liste_photo_parrain = [];
                $liste_mat_parrain = [];
                $i = 0;
                foreach ($listeparrain as $parrain) {
                    //echo '<p>'.$parrain['photo_parrain'].'</p>';

                    $liste_photo_parrain[$i] = $parrain['photo_parrain'];
                    $liste_mat_parrain[$i] = $parrain['mat_parrain'];
                    $i++;
                }

                if ($liste_mat_parrain == NULL) {
                    echo 'Aucun Parrain enregistrer en '.$filiere.'<br>';
                }
                else
                    echo 'Tirage Parrain en cour ...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                // Recuperation des photos et des matricules des filleuls dans un tableau associatif

                $sqllistefilleul = $PDO->prepare("SELECT * FROM filleuls WHERE filiere_filleul = :fil;");
                $sqllistefilleul->bindParam("fil", $id_filiere);                            
                $sqllistefilleul->execute();
                $listefilleul = $sqllistefilleul->fetchAll(PDO::FETCH_ASSOC);
                
                // Mise des photos et des matricules des filleuls dans un tableau indicé
                $liste_photo_filleul = [];
                $liste_mat_filleul = [];

                $i = 0;
                foreach ($listefilleul as $filleul) {
                    //echo '<p>'.$filleul['mat_filleul'].'</p>';
                    $liste_photo_filleul[$i] = $filleul['photo_filleul'];
                    $liste_mat_filleul[$i] = $filleul['mat_filleul'];
                    $i++;
                }

                if ($liste_mat_filleul == NULL) {
                    echo 'Aucun filleul enregistrer en '.$filiere.'<br>';
                }
                else
                    echo 'Tirage filleul en cour ...<br>';
                /* echo "<br><br>--------------------<br><br>";
                foreach ($liste_mat_filleul as $filleul) {
                    echo '<p>'.$filleul.'</p>';
                } */
                exit;

                if( password_verify($pass, $hash['pass_utilisateur'] ))
                {
                    $_SESSION['emailutilisateur'] = $login;
                    $_SESSION['nomutilisateur'] = $hash['nom_utilisateur'];
                    
                }
                else
                    $error = "<em>Email ou mot de passe incorrect...</em>";               
                
                $sqlexistanceutilisateur->closeCursor();

            }
        
                catch(PDOException $pe)
                {
                    echo "Erreur :".$pe->getMessage();
                }
    }
    
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <title>PARRAINAGE</title>
</head>
<body>

<h1 class="titre">BIENVENU A LA CEREMONIE DE PARRAINAGE</h1>
    <div class="main">
        <ul>
            <li>   
                <form method = "GET">
                    <label for = 'fil'>Choisissez une fillière</label>
                    <select name="fil">
                        <option>IDA</option>
                        <option>FCGE</option>
                        <option>RIT</option>
                    </select>
                    <input type="submit" class="parrain" value="Top !" name="envoi">
                </form>
            </li>
            
        </ul>
    </div>
   
</body>
</html>