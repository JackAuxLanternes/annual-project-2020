<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Erreur !</title>
    </head>
    <body>
        <?php

            if(isset($_GET['error'])){
                $error = $_GET['error'];

                switch ($error){

                    case 401:
                        echo "Tu n'as pas les droits pour accéder à cette page !";
                        break;
                }

            }

         ?>
    </body>
</html>



