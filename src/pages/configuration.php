<?php
// Connexion à la base de données
require_once __DIR__ . '/../config/db.php';

// Exemple très simplifié de traitement du formulaire
// (à adapter selon la structure réelle de votre base de données)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ici vous pourrez parcourir $_POST pour insérer en base
    // Exemple : $_POST['postes'], $_POST['etapes'], $_POST['pieces']
    
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
}
?>

<head>
    <meta charset="UTF-8">
    <title>Configuration des postes de travail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        fieldset { margin-bottom: 20px; padding: 15px; }
        legend { font-weight: bold; }
        .poste, .etape, .piece { border: 1px solid #ccc; padding: 10px; margin-top: 10px; }
        button { margin-top: 10px; }
        label { display: block; margin-top: 5px; }
    </style>
</head>
<body>

<h1>Configuration – Postes de travail</h1>

<form method="post">

    <label>
        Nombre de postes de travail :
        <input type="number" id="nbPostes" min="1" required>
    </label>

    <button type="button" onclick="genererPostes()">Créer les postes</button>

    <div id="postesContainer"></div>

    <button type="submit">Enregistrer la configuration</button>
</form>

<script>
function genererPostes() {
    const nbPostes = document.getElementById('nbPostes').value;
    const container = document.getElementById('postesContainer');
    container.innerHTML = '';

    for (let p = 1; p <= nbPostes; p++) {
        const posteDiv = document.createElement('div');
        posteDiv.className = 'poste';
        posteDiv.innerHTML = `
            <h3>Poste ${p}</h3>
            <input type="hidden" name="postes[${p}][id]" value="${p}">

            <label>Nombre d'étapes :
                <input type="number" min="1" name="postes[${p}][nb_etapes]" 
                       onchange="genererEtapes(${p}, this.value)" required>
            </label>

            <h4>Pièces en stock au début</h4>
            <div id="piecesStock${p}"></div>
            <button type="button" onclick="ajouterPieceStock(${p})">Ajouter une pièce</button>

            <div id="etapesContainer${p}"></div>
        `;
        container.appendChild(posteDiv);
    }
}

function ajouterPieceStock(poste) {
    const container = document.getElementById('piecesStock' + poste);
    const index = container.children.length;

    const div = document.createElement('div');
    div.className = 'piece';
    div.innerHTML = `
        <label>Nom de la pièce
            <input type="text" name="postes[${poste}][stock][${index}][nom]" required>
        </label>
        <label>Quantité en stock
            <input type="number" min="0" name="postes[${poste}][stock][${index}][quantite]" required>
        </label>
    `;
    container.appendChild(div);
}

function genererEtapes(poste, nbEtapes) {
    const container = document.getElementById('etapesContainer' + poste);
    container.innerHTML = '';

    for (let e = 1; e <= nbEtapes; e++) {
        const etapeDiv = document.createElement('div');
        etapeDiv.className = 'etape';
        etapeDiv.innerHTML = `
            <h4>Étape ${e}</h4>
            <label>Numéro de l'étape
                <input type="number" name="postes[${poste}][etapes][${e}][numero]" value="${e}" required>
            </label>

            <div id="piecesEtape${poste}_${e}"></div>
            <button type="button" onclick="ajouterPieceEtape(${poste}, ${e})">Ajouter une pièce</button>
        `;
        container.appendChild(etapeDiv);
    }
}

function ajouterPieceEtape(poste, etape) {
    const container = document.getElementById(`piecesEtape${poste}_${etape}`);
    const index = container.children.length;

    const div = document.createElement('div');
    div.className = 'piece';
    div.innerHTML = `
        <label>Nom de la pièce utilisée
            <input type="text" name="postes[${poste}][etapes][${etape}][pieces][${index}][nom]" required>
        </label>
        <label>Nombre de pièces utilisées
            <input type="number" min="1" name="postes[${poste}][etapes][${etape}][pieces][${index}][quantite]" required>
        </label>
    `;
    container.appendChild(div);
}
</script>

</body>
