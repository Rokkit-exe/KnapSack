<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<div class="container mt-5 rounded p-5">
    <div class="text-light" style='background-color: rgba(33,37,41,0.7);'>
        <form action="" method="post">
            <input type="hidden" name="idEnigme" value="<?php echo "idEnigme"; ?>">
            <h3 class="">Question: <?php echo "question" ;?></h3>
            <div class="">
                <label for="reponse"><?php echo "this is a reponse to the question reponse 1" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse1" ;?>">
            </div>
            <div>
                <label for="reponse"><?php echo "this is a reponse to the question reponse 2" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse2" ;?>">
            </div>
            <div>
                <label for="reponse"><?php echo "this is a reponse to the question reponse 3" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse3" ;?>">
            </div>
            <div>
                <label for="reponse"><?php echo "this is a reponse to the question reponse 4" ;?></label>
                <input type="radio" name="reponse" value="<?php echo "idreponse4" ;?>">
            </div>
            <button class="btn btn-primary">Soumettre</button>
        </form>
    </div>
</div>


<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->