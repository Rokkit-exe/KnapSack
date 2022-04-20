<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php if(isset($_POST['demande'])){
  EnvoyerCaps($_POST['nom']);
}?>
<div class="container text-light p-5 rounded mb-3" style="background-color: rgba(33,37,41,0.7);">
<form method="POST">
  <input type="hidden" name="demande" id="demande">
  <?php getDemandesCaps(); ?>
</form>
</div>

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->