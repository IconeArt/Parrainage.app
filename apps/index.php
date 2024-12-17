<?php
    require "session.php";
    require "db_config.php";
    //init_session();

    $error = "";
    $value = "";
    if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'deconnexion')
    {
        detruire_session();
        header('Location: index.php');
    }
 
    if(isset($_POST['submit']))
    {
        if( isset($_POST['login']) && isset($_POST['pass']) && !empty($_POST['login']) && !empty($_POST['pass']))
        {
            $login = htmlspecialchars($_POST['login']);
            $pass = htmlspecialchars($_POST['pass']);

            try
            {
                $options = 
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];
    
                $PDO = new PDO($driver_db, $utilisateur_db, $pass_utilisateur_db, $options);

                $sqlexistanceutilisateur = $PDO->prepare("SELECT * FROM utilisateur WHERE email_utilisateur = :mail;");

                $sqlexistanceutilisateur->bindParam(":mail", $login);                            
                $sqlexistanceutilisateur->execute();

                $hash = $sqlexistanceutilisateur->fetch(PDO::FETCH_ASSOC);

                if( password_verify($pass, $hash['pass_utilisateur'] ))
                {
                    $_SESSION['emailutilisateur'] = $login;
                    $_SESSION['nomutilisateur'] = $hash['nom_utilisateur'];
                   
                }
                else
                {
                    $error = "<em>Email ou mot de passe incorrect...</em>";
                    $value = $login;
                }
                                   
                
                $sqlexistanceutilisateur->closeCursor();

            }
    
            catch(PDOException $pe)
            {
                echo "Erreur :".$pe->getMessage();
            }
        }
        else {
            $error = "<em>Veuillez renseigner tous les champs</em>";
            $value = htmlspecialchars($_POST['login']);;
        }
    }
            
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>connexion</title>
</head>
<body>

<?php if(est_connecter()) : ?>
    <div class="centre">BIENVENUE A L'APPLICATION DE PARRAINAGE... </div>
    <div class="connecter">
        <a href="index.php?action=deconnexion"> Se deconnecter </a><br>
    </div><br><br><br><br><br>
    <div class="img">
        <img src="img/ETC.jpg" id="etc">
        <div class="menu">
            <nav>
                <ul>
                    <li> <a href=""> Accueil </a> </li>
                    <li> <a href="inscrire.php"> Inscriptions </a> </li>
                    <li> <a href="liste.php"> Liste des étudiants </a> </li>
                    <li> <a href="contact.html"> Contact </a> </li>
                </ul>
            </nav>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="img">
        <button class="btn" type="button"> <a href="debut_par.php?action=deb"> DEBUTER LE PARRAINAGE ! </a> </button>
    </div>

<?php else:?>
    <div id="connexion">
        <h1>Identifiez-vous pour avoir accès à l'application de <br><em>Parrainage</em></h1><br><br>
        <form method="POST" action="index.php">
            <label for="login">Login</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="login" value="<?php echo $value; ?>"><br><br>
            <label for="password">Mot de passe</label>&nbsp;&nbsp;&nbsp;<input type="password" name="pass" value=""><br><br>
            <input type="submit" value="se connecter" name="submit">
            <!-- <a href="#" class="mdpo">Mot de passe oublié</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="inscription.php" class="mdpo">Creer un compte</a><br><br> -->
            <?php echo $error; ?>
        </form>
        
    </div>
<?php endif; ?>


</body>
</html>