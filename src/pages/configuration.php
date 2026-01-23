<?php
// Connexion à la base de données
require_once __DIR__ . '/../config/db.php';
$sql = "SELECT * FROM T_EMPLOYES NATURAL JOIN T_personnes;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>

    <form action="create-post" method="post">
        <label for="">Name Poste:</label>
        <input type="text" name="name_post">
        <select name="id_employe" id="">
            <?php foreach ($employes as $employe): ?>
                <option value="<?= $employe['ID_PERSONNE'] ?>"><?= $employe['PER_NOM'] . ' ' . $employe['PER_PRENOM'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Create">
    </form>

</main>