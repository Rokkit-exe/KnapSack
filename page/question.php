<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<?php 
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['filtre'])) {
            GetEnigme($_SESSION['idJoueur'] ,  $_GET['filtre']);
        }
        
    }   
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (ValiderEnigme($_SESSION['idJoueur'], $_POST['idEnigme'], $_POST['reponse'])){
            AjouterCaps($_SESSION['idJoueur'], $_SESSION['nbCaps']);
            echo Alert("Bravo!");
        }
        else {
            echo Alert("Zut !");
        }
    }
?>

<div class="container mt-5">
    <div class="text-light p-5 rounded" style='background-color: rgba(33,37,41,0.7);'>
        <form method="GET">
            <div class="">
                <div class="d-inline">
                    <Select name="filtre">
                        <option value="Random" selected>Random</option>
                        <option value="Facile">Facile</option>
                        <option value="Moyen">Moyen</option>
                        <option value="Difficile">Difficile</option>
                    </Select>
                
                </div>
                <div class="d-inline">
                    <button  class="btn btn-primary">Changer la difficulter</button>
                </div>
            </div>
        </form>
        <?php if(isset($_SESSION['idEnigme'] , $_SESSION['Enonce'] , $_SESSION['nbCaps'])){ AffichezEnigme($_SESSION['idEnigme'] , $_SESSION['Enonce'] , $_SESSION['nbCaps']);}?>
    </div>
</div>
<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->