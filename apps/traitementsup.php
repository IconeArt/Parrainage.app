<?php
    require "db_config.php";
    require "session.php";
    init_session();

    //echo "ok".$_SESSION['supdes'];

    

    try
                    {
                        $options = 
                        [
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_EMULATE_PREPARES => false
                        ];

                        $PDO = new PDO($driver_db, $utilisateur_db, $pass_utilisateur_db, $options);

                        $sqllistefilleul = $PDO->query("SELECT * FROM parrains");
                        $listefilleul = $sqllistefilleul->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listefilleul as $supplie) {
                            if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'ss'.$supplie['mat_parrain'])
                            {
                                $mat = $supplie['mat_parrain'];
                                //Suppression de l'articles
                                $req = "DELETE FROM parrains WHERE mat_parrain = :mat;";

                                $id_fil = $PDO->prepare($req);
                                $id_fil->bindParam("mat", $mat);
                                $id_fil->execute();

                                $message = "<i>".$_SESSION['par']." à été supprimer avec succes</i>";

                                header('Location: liste.php');
                            }
                        }

                        $sqllistefilleul = $PDO->query("SELECT * FROM filleuls");
                        $listefilleul = $sqllistefilleul->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listefilleul as $supplie) {
                            if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'ss'.$supplie['mat_filleul'])
                            {
                                $mat1 = $supplie['mat_filleul'];
                                //Suppression de l'articles
                                $req = "DELETE FROM filleuls WHERE mat_filleul = :mat;";
                                $id_fil1 = $PDO->prepare($req);
                                $id_fil1->bindParam("mat", $mat1);
                                $id_fil1->execute();

                                $message = "<i>".$_SESSION['fil']." à été supprimer avec succes</i>";

                                header('Location: liste.php');
                            }
                        }
                    }
                    catch(PDOException $pe)
                    {
                        echo "Erreur : ".$pe->getMessage();
                    }

?>