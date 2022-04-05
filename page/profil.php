<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
<div class="container">
        <h1>Profil</h1>
    </div>
    <form class="container mt-3 justify-content-center" method="POST">
        <!-- alias, nom, prenom, email, mdp -->
        <div class="mb-3 w-50">
            <label for="alias" class="form-label">alias</label>
            <input type="username" name="alias" class="form-control" id="alias" value="Rokkit-exe" aria-describedby="usernameHelp">
            <div id="aliasHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-50">
            <label for="Prenom" class="form-label">Prenom</label>
            <input type="prenom" name="prenom" class="form-control" id="Prenom" value="Francis" aria-describedby="prenomHelp">
            <div id="prenomHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-50">
            <label for="Nom" class="form-label">Nom</label>
            <input type="nom" name="nom" class="form-control" id="Nom" value="Di-Folco" aria-describedby="nomHelp">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-50">
            <label for="Email" class="form-label">adresse email</label>
            <label for="Email" class="form-control text-muted">Francki0723@gmail.com</label>
            <div id="emailHelp" class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
    <form class="container mt-4 justify-content-center" method="POST">
        <div class="mb-3 w-50">
            <label for="Password" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="Password" name="Password">
        </div>
        <div class="mb-3 w-50">
            <label for="PasswordConfirmation" class="form-label">confirmer mot de passe</label>
            <input type="password" class="form-control" id="PasswordConfirmation" name="PasswordConfirmation" >
        </div>
        <button type="submit" class="btn btn-primary">Modifier Mot de Passe</button>
    </form>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->