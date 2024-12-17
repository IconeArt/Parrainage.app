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
    <title>creer un compte</title>
</head>
<body> 
          
    <div id="connexion">
        <h1>Creer son compte <br><em>SALAM Côte d'Ivoire</em></h1><br><br>
        <form method="POST" action="inscription.php">
            <label for="nom">Nom</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nom"><br><br>

            <label for="prenom">Prenom</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="prenom"><br><br>

            <label for="email">Email</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email"><br><br>

            <label for="tel">Contact</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="tel"><br><br>

            <label for="mdp">Mot de passe</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="motdepasse"><br><br>

            <label for="mdpConfirm">Confirmer mot de passe</label>&nbsp;&nbsp;&nbsp;<input type="password" name="mdpConfirm"><br><br>
            <button name="envoyer">S'inscrire</button><br><br>
            <a href="index.php" class="mdpo">Se connecter</a>    
        </form>
    </div><br><br>

    <?php
        if(isset($_POST['envoyer']))
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['motdepasse']) && isset($_POST['mdpConfirm']))
            {
                if( !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['tel']) && !empty($_POST['motdepasse']) && !empty($_POST['mdpConfirm']) )
                {
                    $nom_utilisateur = htmlspecialchars($_POST['nom']);
                    $prenom_utilisateur = htmlspecialchars($_POST['prenom']);
                    $email_utilisateur = htmlspecialchars($_POST['email']);
                    $contact = htmlspecialchars($_POST['tel']);
                    $mdp_utilisateur = htmlspecialchars($_POST['motdepasse']);
                    $mdpConfirm_utilisateur = htmlspecialchars($_POST['mdpConfirm']);    
                    
                    $mdp_utilisateur = password_hash($mdp_utilisateur, PASSWORD_BCRYPT);
                    if(!password_verify($mdpConfirm_utilisateur, $mdp_utilisateur) || $mdp_utilisateur == '             ')
                        {
                            echo '<h1><mark>Mot de passe non valide<br><br></mark></h1>';
                            exit;
                        }
                    
                    try
                    {
                        $options = 
                        [
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_EMULATE_PREPARES => false
                        ];

                        $PDO = new PDO($driver_db, $utilisateur_db, $pass_utilisateur_db, $options);
                        $sqlemail = $PDO->query("SELECT email_utilisateur, tel_utilisateur FROM utilisateur");
                        $sqlemail->setFetchMode(PDO::FETCH_ASSOC);
                        $sqllisteemail = $sqlemail->fetchAll();
                        foreach($sqllisteemail as $email)
                        {
                            if($email_utilisateur == $email['email_utilisateur'])
                            {
                                echo '<h1><mark>Cet email est déjà utilisé<br><br></mark></h1>';
                                exit;
                            }
                            if($contact == $email['tel_utilisateur'])
                            {
                                echo '<h1><mark>Cet contact est déjà utilisé<br><br></mark></h1>';
                                exit;
                            }
                        }
                        $sqlemail->closeCursor();

                        $sqlnouveauclient = $PDO->prepare("INSERT INTO `utilisateur` (`nom_utilisateur`, `prenom_utilisateur`, `email_utilisateur`,`pass_utilisateur`,  `tel_utilisateur`)
                        VALUES (:nom, :prenom, :email, :pass, :tel);");

                        $sqlnouveauclient->bindParam(":nom", $nom_utilisateur);
                        $sqlnouveauclient->bindParam(":prenom", $prenom_utilisateur);
                        $sqlnouveauclient->bindParam(":email", $email_utilisateur);
                        $sqlnouveauclient->bindParam(":pass", $mdp_utilisateur);
                        $sqlnouveauclient->bindParam(":tel", $contact);

                        $sqlnouveauclient->execute();
                        header("Location: index.php");
                            
                        
                    }
                    catch(PDOException $pe)
                    {
                        echo "Erreur : ".$pe->getMessage();
                    }
                }
                else
                    echo '<h1><mark>Veuillez remplir tous les champs !!!<br><br></mark></h1>';
            }      
            
    ?>
    
</body>
</html>
