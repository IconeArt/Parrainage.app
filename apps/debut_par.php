<?php
    require "session.php";
    require "db_config.php";
    init_session();
    $error = "";
    $srcf = "ETC.jpg";
    $srcp = "ETC.jpg";
    
    

    //$connect = false;

    if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'chg' )
    {
        //detruire_session();
        unset($_SESSION['connect']); 
        header('Location: debut_par.php');
    }

    if( (isset($_GET['envoi']) && !empty($_GET['envoi']))  )//or (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'deb' ))
    {
        $_SESSION['fil'] = htmlspecialchars($_GET['fil']);
        $filiere = $_SESSION['fil'];
        header('Location: compt_rebour.php');
    }

    if( (isset($_GET['envoi3']) && !empty($_GET['envoi3']))  )
    {
        $_SESSION['imgf']++;
        $_SESSION['imgp']++;
        //echo $_SESSION['imgp'];
        $srcf = $_SESSION['liste_photo_filleul'][$_SESSION['imgf']];
        $srcp = $_SESSION['liste_photo_parrain'][$_SESSION['imgp']];
    }
    if( (isset($_GET['envoi2']) && !empty($_GET['envoi2']))  )
    {
       // header('Location: compt_rebour.php');
        
        $_SESSION['connect'] = true;
        //detruire_session();
        $_SESSION['imgf'] = 0;
        $_SESSION['imgp'] = 0;

        //$num1 = &$_SESSION['imgf'];
        //$num2 = &$_SESSION['imgp'];

        /* $_SESSION['fil'] = htmlspecialchars($_GET['fil']);
        $filiere = $_SESSION['fil']; */
        //echo $num1.'<br><br><br>'; exit;
        
        try
        { 

            $options = 
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $PDO = new PDO($driver_db, $utilisateur_db, $pass_utilisateur_db, $options);

            //$_SESSION['connect'] = true;
            $id_fil = $PDO->prepare("SELECT id_fil FROM filieres WHERE sigle_fil = :filiere;");
            $id_fil->bindParam("filiere", $_SESSION['fil']);
            $id_fil->execute();
            $fil = $id_fil->fetch(PDO::FETCH_ASSOC);
            $id_filiere = $fil['id_fil'];

            // Recuperation des photos et des matricules parrains dans un tableau associatif

            $sqllisteparrain = $PDO->prepare("SELECT * FROM parrains WHERE filiere_parrain = :parr;");
            $sqllisteparrain->bindParam("parr", $id_filiere);                            
            $sqllisteparrain->execute();
            $listeparrain = $sqllisteparrain->fetchAll(PDO::FETCH_ASSOC);
            $sqllisteparrain->closeCursor();

            // Mise des photos et des nom des parrains dans un tableau indicé

            $_SESSION['liste_photo_parrain'] = [];
            $_SESSION['liste_nom_parrain'] = [];
            $_SESSION['liste_prenom_parrain'] = [];

            $i = 0;
            foreach ($listeparrain as $parrain) {
                //echo '<p>'.$parrain['photo_parrain'].'</p>';

                $_SESSION['liste_photo_parrain'][$i] = $parrain['photo_parrain'];
                $_SESSION['liste_nom_parrain'][$i] = $parrain['nom_parrain'];
                $_SESSION['liste_prenom_parrain'][$i] = $parrain['pre_parrain'];
                $i++;
            }

            //else
            //    echo 'Tirage Parrain en cour ...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

            // Recuperation des photos et des matricules des filleuls dans un tableau associatif

            $sqllistefilleul = $PDO->prepare("SELECT * FROM filleuls WHERE filiere_filleul = :fil;");
            $sqllistefilleul->bindParam("fil", $id_filiere);                            
            $sqllistefilleul->execute();
            $listefilleul = $sqllistefilleul->fetchAll(PDO::FETCH_ASSOC);
            $sqllistefilleul->closeCursor();
            // Mise des photos et des matricules des filleuls dans un tableau indicé
            $_SESSION['liste_photo_filleul'] =  [];
            $_SESSION['liste_mat_filleul'] =  [];

            $j = 0;
            foreach ($listefilleul as $filleul)
            {
                //echo '<p>'.$filleul['mat_filleul'].'</p>';
                $_SESSION['liste_photo_filleul'][$j] = $filleul['photo_filleul'];
                $_SESSION['liste_mat_filleul'][$j] = $filleul['mat_filleul'];
                $j++;
            }

            $nbfilleul = count($_SESSION['liste_photo_filleul']);
            $nbparrain = count($_SESSION['liste_photo_parrain']);

            if ($nbparrain > $nbfilleul)
            {
                $difference1 = $nbparrain - $nbfilleul;

                /* $sqllistefilleul1 = $PDO->prepare("SELECT * FROM filleuls LIMIT $difference1 WHERE filiere_filleul = :fil; ");

                $sqllistefilleul1->bindParam("fil", $id_filiere);                            
                $sqllistefilleul1->execute();
                $listefilleul1 = $sqllistefilleul1->fetchAll(PDO::FETCH_ASSOC);
                $sqllistefilleul1->closeCursor(); */

                $l = 1;
                foreach ($listefilleul as $filleul)
                {
                    if ($l == $difference1) {
                        break;
                     }
                    //echo '<p>'.$filleul['mat_filleul'].'</p>';
                    array_push($_SESSION['liste_photo_filleul'], $filleul['photo_filleul']);
                    array_push($_SESSION['liste_mat_filleul'], $filleul['mat_filleul']);
                    $l++;
                }
                
                //echo $difference1; exit;
            }
            //echo count($_SESSION['liste_photo_parrain']);exit;
            //echo $difference1; exit;

            if ($nbparrain < $nbfilleul)
            {
                $difference2 =  $nbfilleul - $nbparrain;

                /* $sqllisteparrain2 = $PDO->prepare("SELECT * FROM parrains WHERE filiere_parrain = :parr;");
                $sqllisteparrain2->bindParam("parr", $id_filiere);                            
                $sqllisteparrain2->execute();
                $listeparrain2 = $sqllisteparrain2->fetchAll(PDO::FETCH_ASSOC);
                $sqllisteparrain2->closeCursor(); */

                $k = 1;
                foreach ($listeparrain as $parrain)
                {
                    //echo '<p>'.$parrain['photo_parrain'].'</p>';
                    if ($k == $difference2) {
                       break;
                    }
                    array_push($_SESSION['liste_photo_parrain'], $parrain['photo_parrain']);
                    array_push($_SESSION['liste_nom_parrain'], $parrain['nom_parrain']);
                    array_push($_SESSION['liste_prenom_parrain'], $parrain['pre_parrain']);
                    $k++;
                }
                
                
            }
            //echo $difference2; exit;//count($_SESSION['liste_photo_parrain']); exit;

            
            //echo $srcf; exit;
            if ($_SESSION['liste_mat_filleul'] == NULL and $_SESSION['liste_photo_parrain'] == NULL)
            {
                $error = '<em>Aucun filleul et aucun parrain enregistré en '.$_SESSION['fil'].'<br></em>';
                $_SESSION['error']  = '<em>Aucun filleul et aucun parrain enregistré en '.$_SESSION['fil'].'<br></em>';
                unset($_SESSION['connect']); 
                header('Location: debut_par.php');
                //break;
            }

            if( $_SESSION['liste_photo_parrain'] == NULL and $_SESSION['liste_mat_filleul'] != NULL)
            {
                $error = '<em>Aucun parrain enregistré en '.$_SESSION['fil'].'<br></em>';
                $_SESSION['error'] = '<em>Aucun parrain enregistré en '.$_SESSION['fil'].'<br></em>';
                unset($_SESSION['connect']); 
                header('Location: debut_par.php');
                //break;
            }

            if( $_SESSION['liste_photo_parrain'] != NULL and $_SESSION['liste_mat_filleul'] == NULL)
            {
                $error = '<em>Aucun filleul enregistré en '.$_SESSION['fil'].'<br></em>';
                $_SESSION['error'] = '<em>Aucun filleul enregistré en '.$_SESSION['fil'].'<br></em>';
                unset($_SESSION['connect']); 
                header('Location: debut_par.php');
                //break;
            }

            $srcf = $_SESSION['liste_photo_filleul'][$_SESSION['imgf']];
            $srcp = $_SESSION['liste_photo_parrain'][$_SESSION['imgp']];

            
            /* if (!isset($aucun)) {
                $nbparrain = count($_SESSION['liste_photo_parrain']);
                $nbfilleul = count($_SESSION['liste_photo_filleul']);

                $srcf = $_SESSION['liste_photo_filleul'][$num1];
                $srcp = $_SESSION['liste_photo_parrain'][$num2];
                /* echo "<img src=../img/";
                echo $srcp.">"; exit; 
            } */
            

            //else
            //    echo 'Tirage filleul en cour ...<br>';
            /* echo "<br><br>--------------------<br><br>";
            foreach ($liste_mat_filleul as $filleul) {
                echo '<p>'.$filleul.'</p>'; 
            } */

            
            
            /* for ($i=1; $i < count( $_SESSION['liste_photo_parrain']); $i++) { 
                while((isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'suiv'))
                {
                    $srcp = $_SESSION['liste_photo_parrain'][$i];
                }
            } */
            // $_SESSION['connect'] = true;
        }
        
        catch(PDOException $pe)
        {
            echo "Erreur :".$pe->getMessage();
        }

       
        
    }

    //header('Location: compt_rebour.php');

   if((isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'suiv'))
    {
        if ($_SESSION['liste_photo_filleul'] == NULL or $_SESSION['liste_photo_parrain'] == NULL ) {
            $error = '<em>Aucun filleul ou parrain enregistrer en '.$_SESSION['fil'].'<br></em>';
        }
        elseif ($_SESSION['imgf'] >=  count($_SESSION['liste_photo_filleul'])-1 or $_SESSION['imgp'] >= count($_SESSION['liste_photo_parrain'])-1)//$nbfilleul or $_SESSION['imgp'] >= $nbparrain )// )
        {
	    $error = '<em>Aucun filleul à parrainer en '.$_SESSION['fil'].'<br></em>';

            $_SESSION['error'] = '<em>Aucun filleul à parrainer en '.$_SESSION['fil'].'<br></em>';
            unset($_SESSION['connect']); //exit;
            header('Location: debut_par.php');

        } else{

            /* $_SESSION['imgf']++;
            $_SESSION['imgp']++;
            //echo $_SESSION['imgp'];
            $srcf = $_SESSION['liste_photo_filleul'][$_SESSION['imgf']];
            $srcp = $_SESSION['liste_photo_parrain'][$_SESSION['imgp']]; */

            header('Location: compt_rebour2.php');
        }
            
            //echo "<img src=../img/";
            //echo $srcp.">"; exit;
        

    }

    if((isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'fin'))
    {
        unset($_SESSION['connect']); //exit;
        header('Location: index.php');

    }
    
 
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PARRAINAGE</title>
</head>
<body>

<?php if(est_parrainer()) : ?>

   

    <div class="loader">
        <span class="lettre">C</span>
        <span class="lettre">H</span>
        <span class="lettre">A</span>
        <span class="lettre">R</span>
        <span class="lettre">G</span>
        <span class="lettre">E</span>
        <span class="lettre">M</span>
        <span class="lettre">E</span>
        <span class="lettre">N</span>
        <span class="lettre">T</span>
        <span class="lettre">.</span>
        <span class="lettre">.</span>
        <span class="lettre">.</span>
    </div>
    
    <script>
        const loader = document.querySelector('.loader');
        
        window.addEventListener('load', () =>{

            loader.classList.add('fondu-out');
        }
        
        )
        //alert("Les parrains et filleuls sont prêt. Cliquer sur OK");
    </script>
    
    <div class="img">
        <nav>
            <ul>
                <li> <a href="index.php"> Accueil </a> </li>
                <li> <a href="inscrire.php"> Inscriptions </a> </li>
            </ul>
        </nav>
    </div><br><br><br>
<?php echo '<center>'.$error.'</center>'; ?>
    <div class="main" id="acceuil">
        <div class="leftp">
            <h2 class="">PARRAIN</h2>
            <img src="img/<?php echo $srcp ?>"><?php echo ""; ?>
        </div>
        <div class="righp">
            <h2 class="">FILLEUL</h2>
            <img src="img/<?php echo $srcf ?>"><?php echo ""; ?>
        </div>
    </div>
    <br><br>
    <div class="main">
        <a href="debut_par.php?action=suiv" class="debpar">Continuer</a>
        <a href="debut_par.php?action=chg" class="debpar">Changer de fillière</a>
        <a href="debut_par.php?action=fin" class="debpar">Fin</a>
    </div><br>
    
    <!-- <input type="submit" class="parrain" value="Continuer" name="envoi">
    <input type="submit" class="parrain" value="Changer filliere" name="chg"> -->
<?php else:?>
    <br><br><br><br>
    <h1 class="titre">BIENVENU A LA CEREMONIE DE PARRAINAGE</h1>
    <h3 class="titre"><?php echo $error; if(isset($_SESSION['error'])) {echo $_SESSION['error']; /*unset($_SESSION['error']);*/} ?></h3>
    <div class="img">
        <nav>
            <ul>
                <li> <a href="index.php"> Accueil </a> </li>
                <li> <a href="inscrire.php"> Inscriptions </a> </li>
            </ul>
        </nav>
    </div><br><br><br>
    <div class="main">
        <ul>
            <li>   
                <form method = "GET">
                    <label for = 'fil'>Choisissez une fillière</label>
                    <select name="fil">
                        <option>IDA</option>
                        <option>FCGE</option>
                        <option>RIT</option>
                        <option>IACC</option>
                        <option>GERNA</option>
                    </select>
                    <!-- <a href="compt_rebour.php" class="debpar">Debuter</a> -->
                    <input type="submit" class="parrain" value="Top !" name="envoi">
                </form>
            </li>
            
        </ul>
        
    </div>
<?php endif; ?>

    
   
</body>
</html>