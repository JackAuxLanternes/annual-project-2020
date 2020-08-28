<nav class="navbar navbar-light">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $currentdirectory;?>/api/index.php">Perfect concierge</a>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="quote/select_quote.php">Demander un devis</a>
            <div class="btn-group">
                <button type="button"
                        class="btn btn-warning dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    Compte
                </button>
                <div class="dropdown-menu">
                    <?php
                    if(!$connected){
                        echo "
                        <a class='dropdown-item' href='$currentdirectory/api/auth/signin.php'>Se connecter</a>
                        <a class='dropdown-item' href='$currentdirectory/api/auth/signup.php'>S'inscrire</a>
                        ";
                    }
                    else{
                        $userdata = $database->find("SELECT * FROM user WHERE email = '" . $_SESSION['user'] . "'");

                        switch ($userdata['statut']){
                            case "admin" :
                                echo "
                                <h6 class='dropdown-header'>Administration</h6>
                                <a class='dropdown-item' href='$currentdirectory/api/admin/booking/booking_list.php'>Gérer les réservations</a>
                                <a class='dropdown-item' href='$currentdirectory/api/admin/service/service_list.php'>Gérer les services</a>
                                <a class='dropdown-item' href='$currentdirectory/api/admin/provider/provider_list.php'>Gérer les prestataires</a>
                                ";
                                break;

                            case "provider" :
                                echo "
                                <h6 class='dropdown-header'>Prestation</h6>
                                <a class='dropdown-item' href='$currentdirectory/api/auth/signout.php'>Planning</a>
                                ";
                                break;

                            default:
                                echo "<a class='dropdown-item' href='$currentdirectory/api/account/account.php'>Compte de " . $userdata['first_name'] . "</a>";
                        }

                        echo "
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='$currentdirectory/api/auth/signout.php'>Se déconnecter</a>
                        ";
                    }
                    ?>
                </div>
            </div>

        </nav>
    </div>
</nav>