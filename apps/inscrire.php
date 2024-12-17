<?php
    require "db_config.php";
    require "session.php";
    init_session();

    $err = "";
    $matriculetd = "";
    $nometd = "";
    $prenometd = "";
    $fillieretd = "";
    $niveautd = "";
    $photoetd = "";
    $ecoletd = "";

    if(isset($_POST['inscrire']))
        if(isset($_POST['matriculetd']) && isset($_POST['nometd']) && isset($_POST['prenometd']) && isset($_POST['fillieretd']) && isset($_POST['niveautd']) && isset($_POST['photoetd']) && isset($_POST['ecoletd']) )
        {
            if( !empty($_POST['matriculetd']) && !empty($_POST['nometd']) && !empty($_POST['prenometd']) && !empty($_POST['fillieretd']) && !empty($_POST['niveautd']) && !empty($_POST['photoetd']) && !empty($_POST['ecoletd']) )
            {
                $matriculetd = htmlspecialchars($_POST['matriculetd']);
                $nometd = htmlspecialchars($_POST['nometd']);
                $prenometd = htmlspecialchars($_POST['prenometd']);
                $fillieretd = htmlspecialchars($_POST['fillieretd']);
                $niveautd = htmlspecialchars($_POST['niveautd']);
                $photoetd = htmlspecialchars($_POST['photoetd']); 
                $ecoletd = htmlspecialchars($_POST['ecoletd']);   

                $filiere = htmlspecialchars($_POST['fillieretd']);
                
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

                    if ($niveautd == "1ere année") 
                    {
                        $mat_filf = $PDO->query("SELECT mat_filleul, photo_filleul FROM filleuls");
                        $mat_filf->setFetchMode(PDO::FETCH_ASSOC);
                        $sqllistmatf = $mat_filf->fetchAll();
                        foreach($sqllistmatf as $mat)
                        {
                            //echo $mat['mat_filleul'];
                            if($matriculetd == $mat['mat_filleul'])
                            {
                                $err = '<em>Cet matricule est déjà utilisé<br><br></em>';
                                $matriculf = true;
                                break;
                            }
                            
                        }

                        foreach($sqllistmatf as $mat)
                        {
                            //echo $mat['photo_filleul'];
                            if($photoetd == $mat['photo_filleul'])
                            {
                                $err = '<em>Cette image est déjà utilisée<br><br></em>';
                                $matriculf = true;
                                break;
                            }
                            
                        }


                        if (!isset($matriculf)) 
                        {
                            $sqlnouveaufil = $PDO->prepare("INSERT INTO `filleuls` (`mat_filleul`, `nom_filleul`, `pre_filleul`,`niv_filleul`,  `photo_filleul`,  `filiere_filleul`,  `ecole_filleul`)
                            VALUES (:mat, :nom, :prenom, :niv, :photo, :fil, :ecole);");

                            $sqlnouveaufil->bindParam(":mat", $matriculetd);
                            $sqlnouveaufil->bindParam(":nom", $nometd);
                            $sqlnouveaufil->bindParam(":prenom", $prenometd);
                            $sqlnouveaufil->bindParam(":fil", $id_filiere);
                            $sqlnouveaufil->bindParam(":niv", $niveautd);
                            $sqlnouveaufil->bindParam(":photo", $photoetd);
                            $sqlnouveaufil->bindParam(":ecole", $ecoletd);

                            $sqlnouveaufil->execute();
                            $sqlnouveaufil->closeCursor();
                            $err = "<em>Etudiant(e) enregistré(e) avec success</em>";
                        }
                        
                    }
                    elseif ($niveautd == "2e année") {
                        $mat_filp = $PDO->query("SELECT mat_parrain FROM parrains");
                        $mat_filp->execute();
                        $mat_filp->setFetchMode(PDO::FETCH_ASSOC);
                        $sqllistmap = $mat_filp->fetchAll();

                        foreach($sqllistmap as $mat)
                        {
                            //echo $mat['mat_parrain'];exit;
                            if($matriculetd == $mat['mat_parrain'])
                            {
                                $err = '<em>Cet matricule est déjà utilisé<br><br></em>';
                                $matriculp = true;
                                break;
                            }
                            
                        }

                        $mat_filp->closeCursor();
                        if (!isset($matriculp)) 
                        {
                            $sqlnouveaupar = $PDO->prepare("INSERT INTO `parrains` (`mat_parrain`, `nom_parrain`, `pre_parrain`,`niv_parrain`,  `photo_parrain`,  `filiere_parrain`,  `ecole_parrain`)
                            VALUES (:mat, :nom, :prenom, :niv, :photo, :fil, :ecole);");

                            $sqlnouveaupar->bindParam(":mat", $matriculetd);
                            $sqlnouveaupar->bindParam(":nom", $nometd);
                            $sqlnouveaupar->bindParam(":prenom", $prenometd);
                            $sqlnouveaupar->bindParam(":fil", $id_filiere);
                            $sqlnouveaupar->bindParam(":niv", $niveautd);
                            $sqlnouveaupar->bindParam(":photo", $photoetd);
                            $sqlnouveaupar->bindParam(":ecole", $ecoletd);


                            $sqlnouveaupar->execute();
                            $err = "<em>Etudiant(e) enregistré(e) avec success</em>";
                        }
                        
                    }
 
                }
                catch(PDOException $pe)
                {
                    echo "Erreur : ".$pe->getMessage();
                }
            }
            else
            {
                $err = '<em>Veuillez remplir tous les champs !!!</em>';
                $matriculetd = htmlspecialchars($_POST['matriculetd']);
                $nometd = htmlspecialchars($_POST['nometd']);
                $prenometd = htmlspecialchars($_POST['prenometd']);
                $fillieretd = htmlspecialchars($_POST['fillieretd']);
                $niveautd = htmlspecialchars($_POST['niveautd']);
                $photoetd = htmlspecialchars($_POST['photoetd']); 
                $ecoletd = htmlspecialchars($_POST['ecoletd']);
            }
                
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
        <h1>Enregistrer un nouvel etudiant</h1>
        <form method="POST" action="">
            <label for="matricul">Matricul</label><input type="text" name="matriculetd" maxlength="10" size=30 placeholder="2020ETC000" value="<?php echo $matriculetd; ?>"><br>
            <label for="nom">Nom</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" maxlength="40" name="nometd" size=30 placeholder="Koffi" value="<?php echo $nometd; ?>"><br>

            <label for="prenom">Prenom</label>&nbsp;&nbsp;<input type="text" name="prenometd"  maxlength="50"  size=30 placeholder="Rosine" value="<?php echo $prenometd; ?>"><br>

            <label for="filliere">Filliere</label>&nbsp;&nbsp;
            <select name="fillieretd" value="<?php echo $fillieretd; ?>">
                <option>ATPA</option>
                <option>ATPV</option>
                <option>ELT</option>
                <option>FCGE</option>
                <option>GEC</option>
                <option>IACC</option>
		<option>IDA</option>
                <option selected>GERNA</option>
                <option>RIT</option>
            </select><br>

            <label for="niveau">Niveau</label>&nbsp;&nbsp;
            <select name="niveautd" value="<?php echo $niveautd; ?>">
                <option selected>1ere année</option>
                <option>2e année</option>
            </select><br>
            

            <label for="PHOTO">Photo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="photoetd" value="<?php echo $photoetd; ?>"><br>

            <label for="ecole">Ecole</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ecoletd" size=30 placeholder="ESETEC" value="<?php echo $ecoletd; ?>"><br>
            <input type="submit" class="parrain" value="S'inscrire" name="inscrire"><br>
            <?php echo $err; ?>
        </form><br>
        
    </div>

</body>

</html>