<main>
  <?php
    require_once __DIR__. '/../config/db.php';

    $sql = "SELECT * FROM T_POSTE;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <h1>Home Page</h1>
    <h2>Chaine de production</h2>
    <ul>
        <?php foreach ($positions as $position): ?>
            <li>
                ID: <?= htmlspecialchars($position['ID_POSTE']) ?>,
                Numéro de postes: <?= htmlspecialchars($position['NOM_POSTE']) ?>,
                Numéro employés: <?= htmlspecialchars($position['ID_PERSONNE']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>