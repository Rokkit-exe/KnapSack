<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['supprimerEval'])){
        SupprimerEvaluation($_POST['idObjet'] , $_POST['idJoueur']);
    }
    if(empty($_POST['comment']) || empty($_POST['note'])){
        //mettre comment et note pas bonne
    }
    else{
        if($_POST['editOuAdd'] == 'Add'){
            AddEvaluation($_SESSION['idJoueur'], $_POST['idObjet'] , $_POST['comment'] , $_POST['note']);
            
        }
        else{
            editCommentaire($_SESSION['idJoueur'], $_POST['idObjet'] , $_POST['comment'] , $_POST['note']);
        }
    }
}
?>
<!-- body -->
<?php GetDetails($_GET['id'])?>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->