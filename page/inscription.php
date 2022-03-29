<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
    <form class="container mt-3">
        <!-- alias, nom, prenom, email, mdp -->
        <div class="mb-3 w-25">
            <label for="Username" class="form-label">Username</label>
            <input type="username" class="form-control" id="Username" aria-describedby="usernameHelp">
            <div id="usernameHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-25">
            <label for="Prenom" class="form-label">Prenom</label>
            <input type="prenom" class="form-control" id="Prenom" aria-describedby="prenomHelp">
            <div id="prenomHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-25">
            <label for="Nom" class="form-label">Nom</label>
            <input type="nom" class="form-control" id="Nom" aria-describedby="nomHelp">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-25">
            <label for="Email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="Email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3 w-25">
            <label for="Password" class="form-label">Password</label>
            <input type="password" class="form-control" id="Password">
        </div>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </form>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->