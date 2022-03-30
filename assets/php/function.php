
<?php

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

// Base files 
require '../assets/email/PHPMailer-master/src/Exception.php';
require '../assets/email/PHPMailer-master/src/PHPMailer.php';
require '../assets/email/PHPMailer-master/src/SMTP.php';


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
    /*if(DeciderOrder()){
        $sqlProcedure = "CALL AfficherTous ";
    }
    else{
        $type = $_GET['type'];
        $prixMax = $_GET['prix'];
        $poidsMax = $_GET['poids'];
        $ordre = $_GET['ordre'];
        $sqlProcedure = "CALL AfficherAvecCritère($type , $prixMax , $poidsMax , $ordre)";
    }*/
    $sql = "CALL AfficherTous";
    $stmt = $pdo->query($sql);

    foreach($stmt as $row){
        $id = $row['idObjet'];
        $nom = $row['NomObjet'];
        $quantité = $row['QuantiteStock'];
        $typeItem = $row['TypeObjet'];
        $prix = $row['Prix'];
        $poids = $row['Poids'];
        $photo = $row['Photo'];
        AjouterObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo);
    }
}
function AjouterObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo){
    echo "<div class='col'>
                    <div class='border border-dark border-2 card m-2 shadow p-3 bg-light'>
                        <div class='card-img-top text-center'>
                            <img src='../assets/img/$photo' alt='photo' height='250' width='250' class='rounded-3'>
                        </div>
                        <div class='row row-cols-2 mt-3 card-body'>
                            <div class='w-100'><h3 class='title card-title'>$nom</h3></div>
                            <div class='col text-start card-text'>
                                <div>Quantité: $quantité</div>
                                <div>Prix: $prix$</div>
                                <div>Poids: $poids lbs</div>
                            </div>
                            <div class='col d-block'>
                                <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>
                                <input type='submit' name='ajouterPanier' value='Acheter' class='btn btn-dark'>
                            </div>

                        </div>
                    </div>
                </div>";
}
function DeciderOrder(){
    foreach($_GET as $val){
        if(!empty($val)){
            return True;
        }
    }
    return False;
        
}
function AjouterJoueur($pseudonyme , $nom , $prenom , $adresseCourriel , $motPass){
    $pdo = GetPdo();
    $sql = "CALL AjouterUser(?,?,?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudonyme , $nom , $prenom , $adresseCourriel , $motPass]);       
    }catch (\Exception $e) {
         
    }
}
  function getIDJoueur(){
    $pdo = getPdo();
    $sql = "select LAST_INSERT_ID() from Joueurs";
    $stmt = $pdo->query($sql);

    return 1;
}
function EnvoyerEmail($email , $id){
    $mail = new PHPMailer(true);                              
try {
    $mail->isSMTP(); // using SMTP protocol                                     
    $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = 'knapsak18@gmail.com';  // sender gmail host   
    $mail->Password = 'wukqvnwcmughiwwo'; // sender gmail host password                          
    $mail->SMTPSecure = 'tls';  // for encrypted connection                           
    $mail->Port = 587;   // port for SMTP     

    $mail->setFrom('knapsak18@gmail.com', "Knapsak18"); // sender's email and name
    $mail->addAddress($email, "Receiver");  // receiver's email and name
    $mail->Subject = 'Confirmer inscription a Knapsak !!!!!!!!!';
    $mail->Body    = 'Aller sur ce lien pour confirmer votre email : http://167.114.152.54/~knapsak18/KnapSack/page/verifierEmail.php?id='.$id;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) { // handle error.
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}
function ConfirmerInscription($id){
    $pdo = GetPdo();
    $sql = "CALL confirmerEmail(?)";
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);  
        return True;
    }
    catch(Exception $e){
        return False;
    }
   

}
function AjouterPanier(){

}
  ?>

