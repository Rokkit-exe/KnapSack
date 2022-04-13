<?php 
    include('function.php');
    GetPdo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Knapsak</title>
</head>
<body style="
    background-image: url(https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwallpapercave.com%2Fwp%2Fwp3073549.jpg&f=1&nofb=1);
    backdrop-filter: blur(8px);
    ">
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg header shadow-lg">
        <div class="container ">
            <a href="index.php" class="navbar-brand">Knapsak</a>  
            <div class="collpase navbar-collapse justify-content-end">
                <ul class="navbar-nav mr-auto">
                    <li class="navbar-item">
                        <a href="about.php" class="nav-link active">About</a>
                    <li className="navbar-item">
                        <a href="index.php" class="nav-link active">Magasin</a>
                    </li>
                    <?php 
                        if(isset($_SESSION['idJoueur'])){
                            echo 
                                "<li className='navbar-item'>
                                    <a href='panier.php' class='nav-link active'>Panier</a>
                                </li>
                                <li className='navbar-item'>
                                    <a href='sac.php' class='nav-link active'>Sac à Dos</a>
                                </li>
                                <li className='navbar-item'>
                                    <a href='profil.php' class='nav-link active' >".$_SESSION['prenom']." ".$_SESSION['nom']."</a>
                                </li>
                                <li className='navbar-item'>
                                    <a href='deconecter.php' class='nav-link active'>Déconnecter</a>
                                </li>";
                                if($_SESSION['flag'] == 'A'){
                                    echo "<li className='navbar-item'>
                                        <a href='admin.php' class='nav-link active'>Admin</a>
                                        </li>";
                                }
                        }
                        
                        else{
                            echo 
                                "<li className='navbar-item'>
                                    <a href='connection.php' class='nav-link active'>Connexion</a>
                                </li>";
                        }
                        
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    
