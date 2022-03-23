<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<!-- body -->
<form class="container">
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
<!-- body -->

<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->