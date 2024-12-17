<?php
    require "db_config.php";
    require "session.php";
    init_session();
    
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


    foreach ($listeparrain as $et) {
        if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'sm'.$et['mat_parrain'])
        {
            
            //loop:

            $_SESSION['id'] = $et['mat_parrain'];
            //echo $id;exit;
            $sqllisteparrain = $PDO->prepare("SELECT * FROM parrains WHERE mat_parrain = :parr");
            $sqllisteparrain->bindParam("parr", $_SESSION['id']);                       
            $sqllisteparrain->execute();
            $result = $sqllisteparrain->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $res) {
                $matriculetd = $res['mat_parrain'];
                $nometd = $res['nom_parrain'];
                $prenometd = $res['pre_parrain'];
                $fillieretd = $res['filiere_parrain'];//exit;
                $niveautd = $res['niv_parrain'];
                $photoetd = $res['photo_parrain'];
                $ecoletd = $res['ecole_parrain'];
            }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="menu" id="except">
        <nav>
            <ul>
                <li> <a href="index.php"> Accueil </a> </li>
                <li> <a href="inscrire.php"> Inscriptions </a> </li>
                <li> <a href="contact.html"> Contact </a> </li>
            </ul>
        </nav>
    </div>

    <div class="debut">
        <button class="btn" type="button"> <a href="debut_par.php"> DEBUTER LE PARRAINAGE ! </a> </button>
    </div>

    <div id="connexion">
        <h1>Modifier les infos d'un etudiant</h1>
        <form method="POST" action="">
            <label for="matricul">Matricul</label><input type="text" name="matriculetd" size=30 placeholder="2020ETC000" value="<?php echo $matriculetd; ?>"><br>
            <label for="nom">Nom</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nometd" size=30 placeholder="Koffi" value="<?php echo $nometd; ?>"><br>

            <label for="prenom">Prenom</label>&nbsp;&nbsp;<input type="text" name="prenometd" size=30 placeholder="Rosine" value="<?php echo $prenometd; ?>"><br>

            <label for="filliere">Filliere</label>&nbsp;&nbsp;
            <select name="fillieretd" value="<?php echo $fillieretd; ?>">
                <option>ATPA</option>
                <option>ATPV</option>
                <option>ELT</option>
                <option>FCGE</option>
                <option>GEC</option>
                <option>IACC</option>
                <option selected>IDA</option>
                <option>RIT</option>
            </select><br>

            <label for="niveau">Niveau</label>&nbsp;&nbsp;
            <select name="niveautd" value="<?php echo $niveautd; ?>">
                <option selected>1ere année</option>
                <option>2e année</option>
            </select><br>
            

            <label for="PHOTO">Photo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="photoetd" value="<?php echo $photoetd; ?>"><br>

            <label for="ecole">Ecole</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ecoletd" size=30 placeholder="ESETEC" value="<?php echo $ecoletd; ?>"><br>
            <input type="submit" class="parrain" value="Modifier" name="inscrire"><br>
            <?php //echo $err; ?>
        </form><br>
        
    </div>

</body>

</html>
<?php }} ?>