<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 

// validation serveur des info du login
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    VerifierLogin($_POST['email'], $_POST['password']);
}

// alert de confirmation de la création du compte
if (isset($_SESSION['confirmer'])) {
    Alert($_SESSION['confirmer']);
}
?>



<!-- body -->
<div class=" container rounded p-4" style="background-color: rgba(33,37,41,0.7)">
    <h1 class="text-light">Connection</h1>
    <form method="POST" class="container mt-3 text-light">
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

    <div class="text-center text-light">Vous n'avez pas de compte?</div>
    <div class="d-flex justify-content-center"><a href="inscription.php" class="nav-link active">Inscription</a></div>
</div>

<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->