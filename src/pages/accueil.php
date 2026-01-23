<main>
  <?php
    require_once __DIR__. '/../config/db.php';

    $sql = "SELECT * FROM T_POSTE;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <h1>Page d'Accueil</h1>
    <h2>Chaine de production</h2>
    <ul>
        <?php foreach ($positions as $position): ?>
            <li>
               <p> ID: <?= htmlspecialchars($position['ID_POSTE']) ?>,</p>
            </li>
            <li>
                <p>Numéro de postes: <?= htmlspecialchars($position['NOM_POSTE']) ?>,</p>
            </li>
            <li>
               <p> Numéro employés: <?= htmlspecialchars($position['ID_PERSONNE']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</main>