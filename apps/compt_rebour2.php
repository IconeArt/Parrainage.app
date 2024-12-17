<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rebour</title>
</head>

<body>
    <a href="debut_par.php?action=chg"><<<
    <div class="menu">

        <div class="img">
            <h2 class="tit">Compte à rebour</h2>
            <div class="decompte" id="decompte">
            </div>
        </div>

        <div class="main" id="acceuil">
        <div class="leftp">
            <h2 class="">PARRAIN</h2>
            <img src="img/util/par.gif"><?php echo ""; ?>
        </div>
        <div class="righp">
            <h2 class="">FILLEUL</h2>
            <img src="img/util/fil.gif"><?php echo ""; ?>
        </div>
    </div>
    <?php
    ?>
        <script>
            function compte()
            {
                var decompte = function(i) {
                document.getElementById('decompte').innerHTML = i + ' s';
                if (i == 15) {
                   
                    location.href = 'compt_rebour.php';
                    window.location.assign('debut_par.php?envoi3=go');
               }
            }


            var affichage = function() {
                document.getElementById('decompte').innerHTML = 'Fin';

            }

            var temp = 0;
            var decrement = function() {
                for (var i = 20; i > -1; i--) {


                    setTimeout((function(s) {

                        return function() {
                            decompte(s);
                        }

                    

                    })(i), temp);

                    
                    temp += 1000;

                }


            }


            decrement();

            setTimeout(affichage, temp - 1000);
            }
            
            compte();
        </script>
    </div>
</body>

</html>