<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<?php 
    if (!isset($_POST['idEnigme']) && !isset($_POST['reponse'])) {
        /* getEnigme($_SESSION['idJoueur']); */
    }
    if (isset($_POST['idEnigme']) && isset($_POST['reponse'])) {
        /* validerEnigme($_SESSION['idJoueur'], $_POST['idEnigme'], $_POST['reponse']); */
    }
?>

<div class="container mt-5">
    <div class="text-light p-5 rounded" style='background-color: rgba(33,37,41,0.7);'>

        <form action="" method="post">
            <input type="hidden" name="idEnigme" value="<?php echo "idEnigme"; ?>">
            <h3 class="">Question: <?php echo "question" ;?></h3>
            <div class="mt-4">
                <div class="mt-2 mx-3">
                    <label for="reponse"><?php echo "this is a reponse to the question reponse 1" ;?></label>
                    <input type="text" name="reponse" value="" placeholder="Écrivez votre réponse ici...">
                </div>
            </div>
            <button class="btn btn-primary mt-4">Soumettre</button>
        </form>
    </div>
</div>


<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->