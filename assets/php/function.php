
<?php
session_start();


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
        console_log("email confirmer du joueur : $id");
    }
    catch(Exception $e){
        console_log($e);
    }
}

function AjouterJoueur($pseudonyme , $nom , $prenom , $adresseCourriel , $motPass){
    $pdo = GetPdo();
    $sql = "CALL AjouterUser(?,?,?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudonyme , $nom , $prenom , $adresseCourriel , $motPass]);
        console_log("Joueur $pseudonyme ajouter");   
    }catch (\Exception $e) {
        console_log($e);
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
                $_SESSION['nom'] = $row['Nom'];
                $_SESSION['prenom'] = $row['Prenom'];
                $_SESSION['flag'] = $row['flag'];
                console_log("Login sucessful !");
                header('location:index.php');
            }
            else{
                $message = 'Erreur ! Email ou Mot de Passe incorrect';
                echo `<p>$message</p>`;
                $_SESSION['erreur'] = $message;
                console_log("Login unsucessful");
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


function ContrainteOuPas(){
    foreach($_GET as $val){
        if($val != ""){
            return True;
        }
    }
    return False;
}

function GetUserInfo($idJoueur) {
    $pdo = getPdo();
    $sql = "CALL getUser(?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur]);
        foreach($stmt as $row){
            $_SESSION['alias'] = $row['alias'];
            $_SESSION['Prenom'] = $row['Prenom'];
            $_SESSION['Nom'] = $row['Nom'];
            $_SESSION['email'] = $row['email'];
        }
    }catch (\Exception $e) {
        echo `<p>`.$e.`</p>`;
        $_SESSION['erreur'] = $e;
        console_log($e);
    }
}

function UpdatePassword($password, $passwordConfirmation) {
    $pdo = GetPdo();
    $sql = "CALL UpdatePassword(?)";
    if ($password == $passwordConfirmation) {
        $password = password_hash($password , PASSWORD_DEFAULT);
        try{
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$password]);
            $_SESSION['erreur'] = null;
            console_log("Mot de passe modifier avec succès!");
        }catch (\Exception $e) {
            $message = "Impossible de modifier le mot de passe";
            $_SESSION['erreur'] = $message;
            console_log($message + " " + $e);
        }
    }
    else {
        $message = "Les mot de passe ne corespondent pas!";
        $_SESSION['erreur'] = $message;
    }
}

function UpdateProfil($idJoueur, $alias, $prenom, $nom) {
    $pdo = GetPdo();
    $sql = "CALL UpdateProfil(?,?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur, $alias, $prenom, $nom]);
        $_SESSION['erreur'] = null;
        console_log("Profil modifier avec succès");
    }catch (\Exception $e) {
        $message = "impossible de modifier le profil";
        $_SESSION['erreur'] = $message;
        console_log($message + " " + $e);
    }
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
        console_log($e);
    }
    return null;
    
}

// ----------------------------------------------------- Ajouter Panier ------------------------------------------------------

function AjouterPanier($idJoueur, $idObjet, $quantité){
    $pdo = GetPdo();
    $sql = "CALL AjouterPanier(?,?,?)";
    
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur, $idObjet, $quantité]);
        $_SESSION['erreur'] = null;
        console_log("item : $idObjet ajouter au panier de $idJoueur : qty : $quantité");
        $_SESSION['nbItemPanier'] = getQtyItemPanier($_SESSION['idJoueur']);
        header('location:index.php');
    }catch (\Exception $e) {
        $message = "impossible d'ajouter l'objet au panier";
        $_SESSION['erreur'] = $message;
        console_log($message + " " + $e);
        header('location:index.php');
    }
}

function GetPanier($id){
    $_SESSION['PrixPanierTotale'] = 0;
    $_SESSION['PoidsPanierTotale'] = 0;
    $pdo = GetPdo();
    $sql = 'CALL AfficherPanier(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    foreach($stmt as $row){
        AfficherPanier($row);
    }
}
function GetCaps($id){
    $pdo = GetPdo();
    $sql = 'CALL getCapsJoueur(?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        foreach($stmt as $row){
            return $row['caps'];
        }
        
    }
    catch(Exception $e){
        console_log($e);
    }

}


function GetTotalPanier(){
    $pdo = GetPdo();
    $sql = "CALL GetTotalPanier(?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur']]);

    foreach($stmt as $row){
        AfficherTotalPanier($row);
    }
}



function GetQuantiteObjet($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL getQuantiteObjet(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idObjet]);

    foreach($stmt as $row){
        return $row['QuantiteStock'];
    }
}

function AjouterUnItemPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL ModifierQuantitéPanier(?,?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['idJoueur'], $idObjet , 1]);
        console_log("item : $idObjet qty augmenter de 1");
    }
    catch(Exception $e){
        console_log($e);
    }
}
function EnleverUnItemPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL ModifierQuantitéPanier(?,?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['idJoueur'], $idObjet , 0]);
        console_log("item : $idObjet qty réduite de 1");
    }
    catch(Exception $e){
        console_log($e);
    }
}

function SupprimerDuPanier($idObjet){
    $pdo = GetPdo();
    $sql = 'CALL SupprimerDuPanier(?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['idJoueur'], $idObjet]);
        console_log("Suppression du panier complété");
    }
    catch(Exception $e){
        console_log($e);
    }
}

// ------------------------------------------------------ Sac à dos ---------------------------------------------------
function GetSac($id){
    $pdo = GetPdo();
    $sql = 'CALL AfficherSac(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    foreach($stmt as $row){
        AfficherSac($row);
    }
}




function Alert($message){
    echo 
    "<script type ='text/JavaScript'>
        let message = $message
        alert(message)  
    </script>";
}
function AcheterPanier(){
    $pdo = GetPdo();
    $sql = 'CALL getDataAchat(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['idJoueur']]);

    foreach($stmt as $row){
        VérifierAchat($row);
    }
}
function VérifierAchat($row){
    $prix = $row['Prix'];
    $qty = $row['quantité'];
    $qtyStock = $row['QuantiteStock'];
    $capitale = $row['capital'];
    $idObjet = $row['idObjet'];
    $poids = $row['Poids'];

    if($capitale >= $prix * $qty && $qty <= $qtyStock){
        CompleterAchat($_SESSION['idJoueur'] , $qty , $idObjet, $prix, $poids);
    }
}

function CompleterAchat($id ,$qty,$idObjet,$prix,$poids){
    $pdo = GetPdo();
    $sql = 'CALL CompleterAchat(?,?,?,?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id , $idObjet , $qty , $prix, $poids]);
        console_log("Achat complété");
        updateDexteriter($_SESSION['idJoueur']);
    }
    catch(Exception $e){
        console_log($e);
    }
    
}
function getQtyItemPanier($id){
    $pdo = GetPdo();
    $sql = 'Call GetQtyPanier(?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        foreach($stmt as $row){
            return $row['nbItems'];
        }
    }
    catch(Exception $e){
        console_log($e);
    }
}

function updateDexteriter($id) {
    $pdo = GetPdo();
    $poids = getPoids($id);
    $sql = 'CALL UpdateDexteriter(?,?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $poids - 50]);
        console_log("Update de dextérité fait");
    }
    catch(Exception $e){
        console_log($e);
    }
        
}
function console_log($message){
    echo "<script type ='text/JavaScript'>console.log($message)</script>";
}
function getPoids($id){
    $pdo = GetPdo();
    $sql = 'CALL getPoids(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    foreach($stmt as $row){
        return $row['PoidsTotalSac'];
    }
}

function getDexteriter($id) {
    $pdo = GetPdo();
    $sql = 'CALL getDexteriter(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    foreach($stmt as $row){
        return $row['Dexteriter'];
    }
}

function GetDetails($id){
    $pdo = GetPdo();
    $sql = 'Call getObjet(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    foreach($stmt as $row){
        AfficherDetails($row);
    }
}


function getMunitions(){
    $pdo = GetPdo();
    $sql = 'CALL getMunition';
    try{
        
        $stmt = $pdo->query($sql);
        $tab = array();
        foreach($stmt as $row){
            array_push( $tab , [$row['Nom'] ,$row['idMunition']]);
        }
        if($tab != null){
            return $tab;
        }
        else{
            return null;
        }
        
    }
    catch(Exception $e){
        console_log($e);
        return null;
    }   
}
function AfficherListeDeroulante($tabMunition){
    echo"<select name='idMunition'>";
    foreach($tabMunition as $row){
        $nom = $row[0];
        $id = $row[1];
        echo"<option value='$id'>$nom</option>";
    }
    echo"</select>";

}

function AfficherFormTypeItem($type){
    switch($type){
        case 'Arme':
            AfficherFormArme();
            break;
        case 'Armure':
            AfficherFormArmure();

            break;
        case 'Nourriture':
            AfficherFormNourriture();

            break;
        case 'Munition';
            AfficherFormMunition();

            break;
        case 'Medicament':
            AfficherFormMedicament();
            break;
    }
}

function getPourcentageNote($listeEvaluation) {
    
    if ($listeEvaluation != null){
        $nbEvaluation = count($listeEvaluation);
        $note1 = 0;
        $note2 = 0;
        $note3 = 0;
        $note4 = 0;
        $note5 = 0;
        foreach($listeEvaluation as $row){
            if ($row[4] == 1)
                $note1 += 1;
            if ($row[4] == 2)
                $note2 += 1;
            if ($row[4] == 3)
                $note3 += 1;
            if ($row[4] == 4)
                $note4 += 1;
            if ($row[4] == 5)
                $note5 += 1;
        }
        $listePourcentage = array(Pourcentage($note1,$nbEvaluation), 
                                Pourcentage($note2,$nbEvaluation), 
                                Pourcentage($note3,$nbEvaluation), 
                                Pourcentage($note4, $nbEvaluation), 
                                Pourcentage($note5,$nbEvaluation));
    }
    else {
        $listePourcentage = array(0, 0, 0, 0, 0);
    }
    return $listePourcentage;
}

function Pourcentage($note, $nb){
    return $note * 100 / $nb;
}

function Moyenne($liste, $nb) {
    $total = 0;
    foreach($liste as $item) {
        $total += $item;
    }
    return $total / $nb;
}

function GetListeNotes($listeEvaluation) {
    $listeNote = array();
    if (count($listeEvaluation) > 0){
        foreach($listeEvaluation as $eval) {
            array_push($listeNote, $eval[4]);
        }
    }
    else {
        $listeNote = null;
    }
    return $listeNote;
}

function getEvaluation($idObjet) {
    $pdo = GetPdo();
    $sql = 'Call getEvaluation(?)';
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idObjet]);
        $tab = array();
        foreach($stmt as $row){
            array_push( $tab , [$row['idObjet'] ,$row['idJoueurs'], $row['alias'], $row['Commentaire'], $row['Note']]);
        }
        if($tab != null){
            return $tab;
        }
        else{
            return null;
        }
        
    }
    catch(Exception $e){
        console_log($e);
        return null;
    }
}
function AjouterObjet($donner){
    if(isset($_SESSION['type'])){
        if(strlen($donner['nomItem']) > 50 || strlen($donner['nomItem']) < 0){
            return 'Nom trop long ou trop petit';
        }
        $regexUrl = "/^https?:\\/\\/(?:www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b(?:[-a-zA-Z0-9()@:%_\\+.~#?&\\/=]*)$/";

        if(!preg_match($regexUrl ,  $donner['url'])){
            return 'Erreur url invalide';
        }
        if($donner['qtyStock'] <= 0){
            return 'Erreur , ne pas ajouter un objet ayant moin de 1 en stock';
        }
        if($donner['prixIndividuelle'] >= 100 || $donner['prixIndividuelle'] < 0 ){
            return 'Erreur , le prix doit être entre 1 et 100 caps';
        }
        if($donner['poidsIndividuelle'] >= 50 || $donner['poidsIndividuelle'] < 0){
            return 'Erreur , le poids doit être entre 1 et 50 lbs';
        }
        if(strlen($donner['desc']) < 1){
            return 'Erreur , la description doit contenir au moin un charactère';
        }
        switch($_SESSION['type']){
            case 'Arme':
                return AjouterArme($donner);
                break;
            case 'Armure':
                return AjouterArmure($donner);
                break;
            case 'Nourriture':
                return AjouterNourriture($donner);
                break;
            case 'Medicament':
                return AjouterMedicament($donner);
                break;
            case 'Munition':
                return AjouterMunition($donner);
                break;
            default :
                return 'what';
                break;
        }
    }
}
function AjouterArmure($donner){
    $pdo = GetPdo();
    $sql =  'CALL AjouterArmure(?,?,?,?,?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$donner['nomItem'],$donner['desc'],$donner['qtyStock'],$donner['prixIndividuelle'],$donner['poidsIndividuelle'],$donner['url'],$donner['taille'],$donner['matiere']]);
        return True;
    }
    catch(Exception $e){
        console_log($e);
        return False;
    }
}
function AjouterNourriture($donner){
    $pdo = GetPdo();
    $sql =  'CALL AjouterNourriture(?,?,?,?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$donner['nomItem'],$donner['desc'],$donner['qtyStock'],$donner['prixIndividuelle'],$donner['poidsIndividuelle'],$donner['url'],$donner['pointsDeVie']]);
        return True;
    }
    catch(Exception $e){
        console_log($e);
        return false;
    }
}
function AjouterMedicament($donner){
    $pdo = GetPdo();
    $sql =  'CALL AjouterMédicament(?,?,?,?,?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$donner['nomItem'],$donner['desc'],$donner['qtyStock'],$donner['prixIndividuelle'],$donner['poidsIndividuelle'],$donner['url'],$donner['duree'],$donner['effet']]);
        return True;
    }
    catch(Exception $e){
        console_log($e);
        return false;
    }
}
function AjouterMunition($donner){
    $pdo = GetPdo();
    $sql =  'CALL AjouterMunition(?,?,?,?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$donner['nomItem'],$donner['desc'],$donner['qtyStock'],$donner['prixIndividuelle'],$donner['poidsIndividuelle'],$donner['url'],$donner['calibre']]);
        return True;
    }
    catch(Exception $e){
        console_log($e);
        return false;
    }
}
function AjouterArme($donner){
    $pdo = GetPdo();
    $sql =  'CALL AjouterArme(?,?,?,?,?,?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$donner['nomItem'],$donner['desc'],$donner['qtyStock'],$donner['prixIndividuelle'],$donner['poidsIndividuelle'],$donner['url'],$donner['efficaciter'],$donner['genreArme'],$donner['idMunition']]);
        return True;
    }
    catch(Exception $e){
        console_log($e);
        return false;
    }
}

function FaireDemandeCaps($id){
    $pdo = GetPdo();
    $sql = "CALL FaireDemandeCaps(?)";

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        if(VerifierDemandeCaps($id)){
            $_SESSION['erreurCaps'] = ' Erreur , vous avez déja fait 3 demande a ladmin ';
        }
    }
    catch(Exception $e){
        console_log($e);
    }
}
function VerifierDemandeCaps($id){
    $pdo = GetPdo();
    $sql = 'CALL getDemandeIds(?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        foreach($stmt as $row){
            if($row['nbDemandeCaps']>2){
                return True;
            }
        }
        return False;
    }
    catch(Exception $e){
        console_log($e);
    }
}

function getDemandesCaps(){
    $pdo = GetPdo();
    $sql = 'CALL getDemandeCaps';
    
    
    try{
        $stmt = $pdo->query($sql); 
        foreach($stmt as $row){
            echo AfficherDemandeCaps($row['id'] , $row['nom'] , $row['solde']);
        }
        
    }
    catch(Exception $e){

    }
}
function EnvoyerCaps($id){
    $pdo = GetPdo();
    $sql = "CALL EnvoyerCaps(?)";

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
    catch(Exception $e){
        console_log($e);
    }
}

function AddEvaluation($id ,$idObjet ,  $comment , $note){
    $pdo = GetPdo();
    
    $sql = 'CALL EvaluerItem(?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idObjet ,$id ,  $comment , $note]);
    }
    catch(Exception $e){
        console_log($e);
    }
}
function itemEstDansSac($idObjet , $idJoueur){
    $pdo = GetPdo();
    $sql = 'SELECT itemEstDansSac(?,?) as itemEstDansSac';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idObjet ,$idJoueur]);

        foreach($stmt as $row){
            return $row['itemEstDansSac'];
        }
    }
    catch(Exception $e){
        console_log($e);
    }
}
function editCommentaire($idJoueur , $idObjet , $comment , $note){
    $pdo = GetPdo();

    $sql = 'CALL EditCommentaire(?,?,?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur ,$idObjet ,  $comment , $note]);

    }
    catch(Exception $e){
        console_log($e);

    }
}
function EstCommenter($idJoueur , $idObjet){
    $pdo = GetPdo();
    $sql = 'SELECT EstCommenter(?,?) as EstCommenter';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idObjet ,$idJoueur]);

        foreach($stmt as $row){
            return $row['EstCommenter'];
        }
    }
    catch(Exception $e){
        console_log($e);
    }
}
function SupprimerEvaluation($idObjet , $idJoueur){
    $pdo = GetPdo();
    $sql = 'CALL SupprimerEvaluation(?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur ,$idObjet]);
    }
    catch(Exception $e){
        console_log($e);
    }

}
function VendreObjet($idJoueur , $idObjet){
    $pdo = GetPdo();
    $sql = 'CALL VendreObjet(?,?)';

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idJoueur ,$idObjet]);
    }
    catch(Exception $e){
        console_log($e);
    }
    
}
?>
