<!-- header -->
<?php 
    include('../assets/php/header.php');
    
    if (isset($_POST['Password']) && isset($_POST['PasswordConfirmation'])){
        UpdatePassword($_SESSION['idJoueur'], $_POST['Password'], $_POST['PasswordConfirmation']);
    }

    if (isset($_POST['alias']) && isset($_POST['Prenom']) && isset($_POST['Nom'])) {
        UpdateProfil($_SESSION['idJoueur'], $_POST['alias'], $_POST['Prenom'], $_POST['Nom']);
    }

    GetUserInfo($_SESSION['idJoueur']);
?>

<!-- header -->
<!-- body -->
<div class="container text-light p-5 rounded mb-3" style="background-color: rgba(33,37,41,0.7);">
    <h1>Profil</h1>
    <form class="container mt-3 justify-content-center" method="POST">
        <!-- alias, nom, prenom, email, mdp -->
        <div class="mb-3">
            <label for="alias" class="form-label">alias</label>
            <input type="username" name="alias" class="form-control" id="alias" value="<?php echo $_SESSION['alias']; ?>" aria-describedby="usernameHelp">
            <div id="aliasHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Prenom" class="form-label">Prenom</label>
            <input type="prenom" name="Prenom" class="form-control" id="Prenom" value="<?php echo $_SESSION['Prenom']; ?>" aria-describedby="prenomHelp">
            <div id="prenomHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Nom" class="form-label">Nom</label>
            <input type="nom" name="Nom" class="form-control" id="Nom" value="<?php echo $_SESSION['Nom']; ?>" aria-describedby="nomHelp">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label">Adresse email</label>
            <label for="Email" class="form-control text-muted"><?php echo $_SESSION['email']; ?></label>
            <div id="emailHelp" class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
    <form class="container mt-4 justify-content-center" method="POST">
        <div class="mb-3">
            <label for="Password" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="Password" name="Password">
        </div>
        <div class="mb-3">
            <label for="PasswordConfirmation" class="form-label">Confirmer mot de passe</label>
            <input type="password" class="form-control" id="PasswordConfirmation" name="PasswordConfirmation" >
        </div>
        <button type="submit" class="btn btn-primary">Modifier Mot de Passe</button>
    </form>
</div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->