<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo 'posting';
    $bool = true;
    $erreur="";
    foreach($_POST as $val){
        if($val == null){
            $bool = false;
        }
    }

    if(!$bool) {
       $erreur = "Un champ ou des champs n'ont pas été remplis ou ils sont invalides!";
    }
    else {
       
        try{
            $hash = password_hash($_POST["Password"] , PASSWORD_DEFAULT);
            AjouterJoueur($_POST['alias'] , $_POST['nom'] , $_POST['prenom'] , $_POST['email'] , $hash);
            EnvoyerEmail($_POST['email'] , getIDJoueur());
        }
        catch(Exception $e){

        }
       header('location:index.php');
    }
}
?>
<!-- body -->
    <form class="container mt-3" method="POST">
        <!-- message erreur création du compte -->
        <?php if (isset($_SESSION['erreur'])) { echo `<p>`.$_SESSION['erreur'].`</p>`;}?>
        <!-- alias, nom, prenom, email, mdp -->
        <div class="mb-3">
            <label for="alias" class="form-label">alias</label>
            <input type="username" name="alias" class="form-control" id="alias" aria-describedby="usernameHelp">
            <div id="aliasHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Prenom" class="form-label">Prenom</label>
            <input type="prenom" name="prenom" class="form-control" id="Prenom" aria-describedby="prenomHelp">
            <div id="prenomHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Nom" class="form-label">Nom</label>
            <input type="nom" name="nom" class="form-control" id="Nom" aria-describedby="nomHelp">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label">adresse email</label>
            <input type="email" name="email" class="form-control" id="Email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Password" class="form-label">mot de passe</label>
            <input type="password" class="form-control" id="Password" name="Password">
        </div>
        <p style="color: red;"><?$erreur?></p>
        <button type="submit" class="btn btn-primary">Créer votre compte</button>
        
    </form>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->

