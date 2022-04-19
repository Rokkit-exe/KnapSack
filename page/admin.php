
<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->
<?php 

if(isset($_GET['typeItem'])){
  if($_GET['typeItem'] == 'Arme'){
    $_SESSION['munition'] = getMunitions();
  }
}
?>

<div class="container text-light p-5 rounded mb-3" style="background-color: rgba(33,37,41,0.7);">
<div class="card text-dark" style="width: 18rem;">
  <?php //ici get les demandes des usagers?>
  <div class="card-body">
    <h5 class="card-title">Demande des pauvres</h5>
    <p class="card-text">ici on va choisir si on donne du $ au joueurs</p>
    <a href="#" class="btn btn-primary">Donner</a>
  </div>
</div>

<form method="POST">
  <h1>Ajouter Item</h1>
  <form method="GET">
    <select name="typeItem" id="type">
      <option value="Arme">Arme</option>
      <option value="Armure">Armure</option>
      <option value="Medicament">Médicament</option>
      <option value="Nourriture">Nourriture</option>
      <option value="Munition">Munition</option>
  </select>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  <div class="mb-3">
    <label for="nomItem" class="form-label">Nom Item</label>
    <input type="text" name="nomItem" class="form-control" id="nomItem" aria-describedby="">
    <div id="nomItemHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="desc" class="form-label">Description</label>
    <input type="text" name="desc" class="form-control" id="desc">
  </div>
  <div class="mb-3">
  <label class="form-check-label" for="qtyStock">Quantité en stock</label>
  <input type="text" class="form-check-input" nom="qtyStock" id="qtyStock">
    
  </div>
  <div class="mb-3">
    <label for="prix" class="form-label">Prix individuel</label>
    <input type="number" class="form-control" id="prix" name="prixIndividuelle" aria-describedby="">
    <div id="prixHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="poids" class="form-label">Poids individuelle</label>
    <input type="numeric" class="form-control" id="poids" name="poidsIndividuelle" aria-describedby="">
    <div id="poidsHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="url" class="form-label">Url Image</label>
    <input type="text" class="form-control" id="url" name="url" aria-describedby="">
    <div id="urlHelp" class="form-text"></div>
  </div>
  
  <?php //ici section pour les differente données (Armes , Armures , Medicaments , etc?>
  <?php if(isset($_GET['typeItem'])){
    AfficherFormTypeItem($_GET['typeItem']);
  }?>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>
<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->