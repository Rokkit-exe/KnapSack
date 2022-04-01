<?php 

// validation serveur des info du login
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    VerifierLogin($_POST['email'], $_POST['password']);
}

// alert de confirmation de la création du compte
if (isset($_SESSION['confirmer'])) {
    echo '<script type ="text/JavaScript">';  
    echo `alert('`.$_SESSION['confirmer'].`')`;  
    echo '</script>';
}
?>

<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
<form method="POST" class="container mt-3">
    <!-- affichage du message d'erreur login -->
    <?php if (isset($_SESSION['erreur'])) { echo `<p>`.$_SESSION['erreur'].`</p>`;}?>
    <div class="mb-3">
        <label for="Email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="Email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="Password">
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>

<div class="text-center">Vous n'avez pas de compte?</div>
<div class="d-flex justify-content-center"><a href="inscription.php" class="nav-link active">Inscription</a></div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->