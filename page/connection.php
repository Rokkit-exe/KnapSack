<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
}
?>

<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
<form class="container mt-3">
    <div class="mb-3">
        <label for="Email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="Email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" class="form-control" id="Password">
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>

<div class="text-center">Vous n'avez pas de compte?</div>
<div class="d-flex justify-content-center"><a href="inscription.php" class="nav-link active">Inscription</a></div>
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->