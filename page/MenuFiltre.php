<div class="text-center text-light">
    <form class="d-block container-sm-d-inline p-2 border border-dark rounded mb-3 p-3" method="GET" action="" style="background-color: rgba(33,37,41,0.7)">
        <select class="me-3 rounded" name='type' id='type'>
            <option value="''" selected>Tout les types d'objets</option>
            <option value="'Arme'">Armes</option>
            <option value="'Armure'">Armures</option>
            <option value="'Munition'">Munitions</option>
            <option value="'Nourriture'">Nourriture</option>
            <option value="'Médicament'">Médicaments</option>
        </select>
        <label for="prixMax">Prix Maximum (caps): </label>
        <input class="me-3 rounded" type="number" name="prixMax" id="prixMax" min=<?= PRIX_MIN ?> max=<?= PRIX_MAX ?>>
        <label for="poidsMax">Poids Maximum (lbs): </label>
        <input class="me-3 rounded" type="number" name="poidsMax" id="poidsMax" min=<?= POIDS_MIN ?> max=<?= POIDS_MAX ?>>
        <select class="me-3" name='tri' id='tri'>
            <option value="0" selected>Trier</option>
            <option value="1">Prix ascendant</option>
            <option value="2">Poids ascendant</option>
            <option value="3">Prix descendant</option>
            <option value="4">poids descendant</option>
        </select>
        <select class="me-3" name='triEval' id='triEval'>
            <option value="0" selected>Trier Par evaluation</option>
            <option value="1">Évaluation ascendant</option>
            <option value="2">Évaluation Descendant</option>
        </select>
        <button class="btn btn-primary">Appliquer</button>
        
    </form>
</div>