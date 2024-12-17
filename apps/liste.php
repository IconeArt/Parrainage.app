<?php
    require "db_config.php";
    require "session.php";
    init_session();
?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Liste étudiants</title>
</head>
<style>
    img{
        height: 50px;
        width: 50px;
    }
    body{
        text-align: center;
    }

    table{
        display: table;
        margin: 0 auto;
        background: white;
    }
</style>
<body>

    <div class="menu">
            <nav>
                <ul>
                    <li> <a href="index.php"> Accueil </a> </li>
                    <li> <a href="inscrire.php"> Inscriptions </a> </li>
                    <li> <a href="liste.php"> Liste des étudiants </a> </li>
                    <li> <a href="contact.html"> Contact </a> </li>
                </ul>
            </nav>
        </div>

    <?php
        try
        {
            $options = 
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $PDO = new PDO($driver_db, $utilisateur_db, $pass_utilisateur_db, $options);
            

            $sqllisteparrain = $PDO->query("SELECT * FROM parrains");
            //$sqllisteparrain->bindParam("parr", $id_filiere);                            
            //$sqllisteparrain->execute();
            $listeparrain = $sqllisteparrain->fetchAll(PDO::FETCH_ASSOC);
            $sqllisteparrain->closeCursor();
            

            // Recuperation des photos et des matricules des filleuls dans un tableau associatif

            $sqllistefilleul = $PDO->query("SELECT * FROM filleuls");
            //$sqllistefilleul->bindParam("fil", $id_filiere);                            
            //$sqllistefilleul->execute();
            $listefilleul = $sqllistefilleul->fetchAll(PDO::FETCH_ASSOC);
            $sqllistefilleul->closeCursor(); 
            
        }
        catch(PDOException $pe)
        {
            echo "Erreur : ".$pe->getMessage();
        }

?> 
    <div class="tab">
    <!-- STOCK FOURNITURE -->

    <table class="tableau" border="1" cellspacing="0">
        <h2>LISTE DES ETUDIANTS</h2>
        <thead>
            <tr>
                <th> NOMS & PRENOMS</th>
                <th> FILLIERES </th>
                <th> ANNEES </th>
                <th> PHOTO </th>
                <th colspan="1"> ACTION </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listeparrain as $etudiant){
                $sqlfilparrain = $PDO->query("SELECT sigle_fil FROM filieres WHERE id_fil =".$etudiant['filiere_parrain']);
            $filparrain = $sqlfilparrain->fetchAll(PDO::FETCH_ASSOC);
            $sqlfilparrain->closeCursor(); $_SESSION['par'] = $etudiant['mat_parrain'];?>
            <tr>
                <td><?php echo $etudiant['nom_parrain'].' '.$etudiant['pre_parrain'];?></td>
                <td><?php foreach($filparrain as $etudiant2){ echo $etudiant2['sigle_fil'];}?></td>
                <td><?php echo $etudiant['niv_parrain']; ?></td>
                <td><?php $img1 = $etudiant['photo_parrain']; echo "<img src='img/$img1'>"; ?></td>
                <!-- <td><a href="traitementmod.php?action=<?php //echo "sm".$_SESSION['par']; ?>">Modifier</a></td> -->
                <td><a href="traitementsup.php?action=<?php echo "ss".$_SESSION['par']; ?>">Supprimer<?php //echo $_SESSION['supdes']; ?></a></td>
            </tr>
            <?php } ?>

            <?php foreach($listefilleul as $etudiant){
                $sqlfilparrain = $PDO->query("SELECT sigle_fil FROM filieres WHERE id_fil =".$etudiant['filiere_filleul']);
                $filparrain = $sqlfilparrain->fetchAll(PDO::FETCH_ASSOC);
                $sqlfilparrain->closeCursor(); $_SESSION['fil'] = $etudiant['mat_filleul'];?>
            <tr>
                <td><?php echo $etudiant['nom_filleul'].' '.$etudiant['pre_filleul'];?></td>
                <td><?php foreach($filparrain as $etudiant2){ echo $etudiant2['sigle_fil'];}?></td>
                <td><?php echo $etudiant['niv_filleul']; ?></td>
                <td><?php $img = $etudiant['photo_filleul']; echo "<img src='img/$img'>"; ?></td>
                <!-- <td><a href="traitementmod.php?action=<?php //echo "sm".$_SESSION['fil']; ?>">Modifier</a></td> -->
                <td><a href="traitementsup.php?action=<?php echo "ss".$_SESSION['fil']; ?>">Supprimer<?php //echo  $_SESSION['supdes']; ?></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
