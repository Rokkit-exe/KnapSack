<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<div class="container mt-5">
    <div class="card">
        <form action="" method="post">
            <input type="hidden" name="idEnigme" value="">
            <input type="hidden" name="idReponse" value="">
            <h3 class="card-title">Question: <?php echo "question" ;?></h3>
            <div class="card-body">
                <label for="idReponse1"><?php echo "reponse 1" ;?></label><input type="radio" name="idReponse1" id="">
                <label for="idReponse2"><?php echo "reponse 2" ;?></label><input type="radio" name="idReponse2" id="">
                <label for="idReponse3"><?php echo "reponse 3" ;?></label><input type="radio" name="idReponse3" id="">
                <label for="idReponse4"><?php echo "reponse 4" ;?></label><input type="radio" name="idReponse4" id="">
            </div>
            <button>Soumettre</button>
        </form>
    </div>
</div>


<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->