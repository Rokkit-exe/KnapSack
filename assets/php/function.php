
<?php

// ----------------------------------------------- connection BD ---------------------------------------------------------
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

// ---------------------------------------------------------- inscription/ php mailer ---------------------------------------------------

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

// Base files 
require '../assets/email/PHPMailer-master/src/Exception.php';
require '../assets/email/PHPMailer-master/src/PHPMailer.php';
require '../assets/email/PHPMailer-master/src/SMTP.php';

function EnvoyerEmail($email , $id){
    $mail = new PHPMailer(true);                              
try {
    $mail->isSMTP(); // using SMTP protocol                                     
    $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = 'louisphilippe.rousseau248@gmail.com';  // sender gmail host   
    $mail->Password = 'bupduxiydxhcccvq'; // sender gmail host password                          
    $mail->SMTPSecure = 'tls';  // for encrypted connection                           
    $mail->Port = 587;   // port for SMTP     

    $mail->setFrom('louisphilippe.rousseau248@gmail.com', "Louis-Philippe Rousseau"); // sender's email and name
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

function AjouterJoueur($pseudonyme , $nom , $prenom , $adresseCourriel , $motPass){
    $pdo = GetPdo();
    $sql = "CALL AjouterUser(?,?,?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudonyme , $nom , $prenom , $adresseCourriel , $motPass]);       
    }catch (\Exception $e) {
        $message = "impossible de créer l'utilisateur";
        echo `<p>`.$message.`</p>`;
        $_SESSION['erreur'] = $message;
        header('location:inscription.php');
    }
}


// ------------------------------------------------ Connection ----------------------------------------------------

function VerifierLogin($email , $password){
    $pdo = GetPdo();
    try{
        $sql = "CALL VerifierLogin(?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        foreach($stmt as $row){
            if(password_verify($password ,$row['motdepasse']) && ($row['emailConfirmer'] == '1')){
                session_start();
                $_SESSION['idJoueur'] = $row['idJoueur'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['erreur'] = null;
                echo "oui";
                //header('location:index.php');
            }
            else{
                $message = 'Erreur ! Email ou Mot de Passe incorrect';
                echo `<p>$message</p>`;
                $_SESSION['erreur'] = $message;
                header('location:connection.php');
            }
        }
    }catch(\Exception $e){
        echo "error";
    }
}

// --------------------------------------------------------- get objets / afficher tous index -----------------------------------------

function getObjet(){
    $pdo = GetPdo();
    if(!ContrainteOuPas()){
        $sqlProcedure = "CALL AfficherTous";
    }
    else{
        $type = $_GET['type'];
        $prixMax = $_GET['prixMax'];
        $poidsMax = $_GET['poidsMax'];
        $ordre = $_GET['tri'];
        
        if($prixMax == ""){
            $prixMax = "500";
        }
        if($poidsMax == ""){
            $poidsMax = "100";
        }
        if($ordre == ""){
            $ordre = "'Prix'";
        }
        $sqlProcedure = "CALL AfficherAvecCritère($type , $prixMax , $poidsMax , $ordre)";
    }
    $stmt = $pdo->query($sqlProcedure);

    foreach($stmt as $row){
        $id = $row['idObjet'];
        $nom = $row['NomObjet'];
        $quantité = $row['QuantiteStock'];
        $typeItem = $row['TypeObjet'];
        $prix = $row['Prix'];
        $poids = $row['Poids'];
        $photo = $row['photo'];
        AfficherObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo);
    }
}

// ------------------------------------------------------- Ajouter objet -----------------------------------------------------
function AfficherObjet($id , $nom , $quantité , $typeItem , $prix , $poids , $photo){
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
                                <a href='details.php?id=$id&typeItem=$typeItem' class='btn btn-dark'>Details</a>";
                            if ($quantité >= 1 && isset($_SESSION['idJoueur'])) {
                                echo "<form method='POST'>
                                        <input type='hidden' name='idObjet' value='$id'>
                                        <input type='hidden' name='idJoueur' value='". $_SESSION['idJoueur'] . "'>
                                        <input type='hidden' name='quantité' value='1'>
                                        <button class='btn btn-dark'>Acheter</button>
                                    </form>";
                            }
                        echo "</div>
                        </div>
                    </div>
                </div>";
}

function ContrainteOuPas(){
    foreach($_GET as $val){
        if($val != ""){
            return True;
        }
    }
    return False;
        
}


function getIDJoueur($email){
    $pdo = getPdo();
    $sql = "CALL getUserID(?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        
        foreach($stmt as $row){
            return $row['idJoueur'];
        }
    }catch (\Exception $e) {
        echo `<p>`.$e.`</p>`;
        $_SESSION['erreur'] = $e;
    }
    return null;
    
}

// ----------------------------------------------------- Ajouter Panier ------------------------------------------------------

// modifier la procedure stocker pour augmenter la quantité et non une nouvelle ligne
function AjouterPanier($idJoueur, $idObjet, $quantité){
    

    $pdo = GetPdo();
    $sql = "CALL AjouterPanier(?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur, $idObjet, $quantité]);
        $_SESSION['erreur'] = null;
        header('location:index.php');
    }catch (\Exception $e) {
        $message = "impossible d'ajouter l'objet au panier";
        $_SESSION['erreur'] = $message;
        header('location:index.php');
    }
}

?>

