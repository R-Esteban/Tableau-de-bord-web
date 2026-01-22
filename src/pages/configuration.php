<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? '') === "save_stock") {

    $poste = $_POST["poste"] ?? 1;
    $pieces = $_POST["piece"] ?? [];
    $quantites = $_POST["quantite"] ?? [];

    // Chemin ABSOLU vers data
    $dataDir = realpath(__DIR__ . "/../../data");

    if ($dataDir === false) {
        die("❌ Le dossier data n'existe pas. Crée-le manuellement.");
    }

    $filename = $dataDir . "/Poste{$poste}_stock.csv";

    $file = fopen($filename, "w");
    if ($file === false) {
        die("❌ Impossible de créer le fichier CSV (droits insuffisants)");
    }

    fputcsv($file, ["Nom_piece", "Quantite_stock"]);

    for ($i = 0; $i < count($pieces); $i++) {
        if (!empty($pieces[$i]) && $quantites[$i] !== "") {
            fputcsv($file, [$pieces[$i], $quantites[$i]]);
        }
    }

    fclose($file);

    echo "<p style='color:green;'>✅ Stock enregistré pour Poste {$poste}</p>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["action"] ?? '') === "save_etapes") {

    $poste = $_POST["poste"] ?? 1;
    $numero_etape = $_POST["numero_etape"] ?? 1;
    $pieces = $_POST["piece"] ?? [];
    $quantites = $_POST["quantite"] ?? [];

    $dataDir = realpath(__DIR__ . "/../../data");
    if ($dataDir === false) {
        die("❌ Le dossier data n'existe pas. Crée-le manuellement.");
    }

    $filename = $dataDir . "/Poste{$poste}_Etape.csv";

    $file = fopen($filename, "a"); // append pour ne pas écraser les étapes précédentes
    if ($file === false) {
        die("❌ Impossible de créer le fichier CSV (droits insuffisants)");
    }

    $row = [$numero_etape];
    for ($i = 0; $i < count($pieces); $i++) {
        if (!empty($pieces[$i]) && $quantites[$i] !== "") {
            $row[] = $pieces[$i];
            $row[] = $quantites[$i];
        }
    }

    fputcsv($file, $row);
    fclose($file);

    echo "<p style='color:green;'>✅ Étape {$numero_etape} enregistrée pour Poste {$poste}</p>";
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Configuration des postes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        h1 {
            margin-bottom: 20px;
        }
        section {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, button {
            margin-top: 5px;
            padding: 5px;
        }
    </style>
</head>

<script>
function addPiece() {
    const container = document.querySelector('.pieces');
    const newDiv = document.createElement('div');
    newDiv.innerHTML = `
        <label>Nom de la pièce :</label>
        <input type="text" name="piece[]" required>
        <label>Quantité utilisée :</label>
        <input type="number" name="quantite[]" required min="1">
    `;
    container.appendChild(newDiv);
}
</script>

<body>

<h1>Configuration des postes de travail</h1>

<section>
    <h2>1️⃣ Choix du poste</h2>

    <form method="post">
        <label for="poste">Poste de travail :</label>
        <select name="poste" id="poste">
            <option value="1">Poste 1</option>
            <option value="2">Poste 2</option>
            <option value="3">Poste 3</option>
        </select>
    </form>
</section>



<section>
    <h2>2️⃣ Stock initial</h2>

    <form method="post">
        <input type="hidden" name="action" value="save_stock">

        <label>Nom de la pièce :</label>
        <input type="text" name="piece[]" required>

        <label>Quantité en stock :</label>
        <input type="number" name="quantite[]" required>

        <br><br>

        <button type="submit">💾 Enregistrer le stock</button>
    </form>
</section>


<section>
    <h2>3️⃣ Étapes du poste</h2>

    <form method="post">
        <input type="hidden" name="action" value="save_etapes">

        <label>Numéro de l'étape :</label>
        <input type="number" name="numero_etape" required min="1">

        <h3>Pièces utilisées</h3>

        <div class="pieces">
            <label>Nom de la pièce :</label>
            <input type="text" name="piece[]" required>

            <label>Quantité utilisée :</label>
            <input type="number" name="quantite[]" required min="1">
        </div>

        <button type="button" onclick="addPiece()">➕ Ajouter une pièce</button>
        <br><br>

        <button type="submit">💾 Enregistrer l'étape</button>
    </form>
</section>


</body>
</html>
