<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<div class="container mt-5" style='background-color: rgba(33,37,41,0.7);'>
    <div class="card text-light">
        <form action="" method="post">
            <input type="hidden" name="idEnigme" value="<?php echo "idEnigme"; ?>">
            <h3 class="card-title">Question: <?php echo "question" ;?></h3>
            <div class="card-body d-block">
                <label for="reponse"><?php echo "reponse 1" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse1" ;?>">

                <label for="reponse"><?php echo "reponse 2" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse2" ;?>">

                <label for="reponse"><?php echo "reponse 3" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse3" ;?>">

                <label for="reponse"><?php echo "reponse 4" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse4" ;?>">
            </div>
            <button>Soumettre</button>
        </form>
    </div>
</div>


<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->