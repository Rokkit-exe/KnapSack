<?php
function GetPdo(){
    if(empty($pdo)){
        $host = '167.114.152.54';
        $db = 'dbknapsak18'; // nom de la base de données
        $user = 'joueur18';
        $pass = '9b5y9ze6';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try 
        {
            $pdo = new PDO($dsn, $user, $pass, $options);
            // echo "Connexion établie";
        } 
        catch (\PDOException $e) 
        {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    return $pdo;
}

function getObjet(){
    $pdo = GetPdo();
    $sql = "select idObjet , nomObjet, quantiteStock , typeItem , prix , poids , photoUrl from Objet";//.DeciderOrder();
    $stmt = $pdo->query($sql);

    foreach($stmt as $row){
        $id = $row['idObjet'];
        $nom = $row['nomObjet'];
        $quantité = $row['quantiteStock'];
        $typeItem = $row['typeItem'];
        $prix = $row['prix'];
        $poids = $row['poids'];
        $photo = $row['photoUrl'];

        echo'<div class="col text-center">';
        echo"<h3 class='title'>$nom</h3>";
        echo"<div><img src=$photo alt='photo' class='img-thumbnail rounded'></div>";
        echo"<div class='row row-cols-2'>
                <div class='col text-start'>
                    <div>Quantité: $quantité</div>
                    <div>Prix: $prix$</div>
                    <div>Poids: $poids lbs</div>
                </div>
                <div class='col align-content-end'>
                    <a href='details.php?id=$id&typeItem=$typeItem>Details</a>
                    <br>
                    <a href='acheter.php?id=$id'&typeItem=$typeItem>Acheter</a>
                </div>
            </div>
        </div>";
    }

}

?>