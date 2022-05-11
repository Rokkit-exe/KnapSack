<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<?php 
    if (isset($_GET['filtre'])) {
        GetEnigme($_GET['filtre']);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ValiderEnigme($_SESSION['idJoueur'], $_POST['idEnigme'], $_POST['reponse']);
    }
?>

<div class="container mt-5">
    <div class="text-light p-5 rounded" style='background-color: rgba(33,37,41,0.7);'>
        <div class="">
            <div class="d-inline">
                <button formaction="http://167.114.152.54/~knapsak18/KnapSack/page/question.php?filtre='Random'" class="btn btn-primary">Aléatoire</button>
            </div>
            <div class="d-inline">
                <button formaction="http://167.114.152.54/~knapsak18/KnapSack/page/question.php?filtre='Facile'" class="btn btn-primary">Facile</button>
                <button formaction="http://167.114.152.54/~knapsak18/KnapSack/page/question.php?filtre='Moyen'" class="btn btn-primary">Moyen</button>
                <button formaction="http://167.114.152.54/~knapsak18/KnapSack/page/question.php?filtre='Difficile'" class="btn btn-primary">Difficile</button>
            </div>
        </div>
        <?php AffichezEnigme($_SESSION['idEnigme'] , $_SESSION['Enonce'] , $_SESSION['nbCaps'])?>
    </div>
</div>


<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->