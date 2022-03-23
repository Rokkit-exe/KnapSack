<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <form class="container">
        <!-- alias, nom, prenom, email, mdp -->
        <div class="mb-3">
            <label for="Username" class="form-label">Username</label>
            <input type="username" class="form-control" id="Username" aria-describedby="usernameHelp">
            <div id="usernameHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Prenom" class="form-label">Prenom</label>
            <input type="prenom" class="form-control" id="Prenom" aria-describedby="prenomHelp">
            <div id="prenomHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Nom" class="form-label">Nom</label>
            <input type="nom" class="form-control" id="Nom" aria-describedby="nomHelp">
            <div id="nomHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="Email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="Password" class="form-label">Password</label>
            <input type="password" class="form-control" id="Password">
        </div>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </form>
</body>
</html>