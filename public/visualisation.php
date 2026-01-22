<?php
$dataDir = realpath(__DIR__ . "/../data");
$postes = range(1, 5);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visualisation CESI Bike</title>
</head>
<body>
<h1>Visualisation CESI Bike</h1>

<!-- Vue d'ensemble -->
<h2>Vue d’ensemble des postes</h2>
<table border="1" cellpadding="5">
<tr><th>Poste</th><th>% utilisation stock</th><th>Temps montage étape</th><th>Action</th></tr>

<?php foreach ($postes as $poste): 
    $stockFile = $dataDir . "/Poste{$poste}_stock.csv";
    $stockTotal = 0;
    if (file_exists($stockFile)) {
        if (($handle = fopen($stockFile, "r")) !== false) {
            $firstLine = true;
            while (($data = fgetcsv($handle)) !== false) {
                if ($firstLine) { $firstLine=false; continue; }
                $stockTotal += $data[1];
            }
            fclose($handle);
        }
    }
    $pctStock = $stockTotal > 0 ? round(100,1) : 0;
?>
<tr>
    <td>Poste <?= $poste ?></td>
    <td><?= $pctStock ?>%</td>
    <td>0 sec</td>
    <td><a href="visualisation.php?poste=<?= $poste ?>&etape=0">Voir poste</a></td>
</tr>
<?php endforeach; ?>
</table>

<!-- Vue d'un poste -->
<?php
if (isset($_GET['poste'])):
    $poste = $_GET['poste'];
    $etapeFile = $dataDir . "/Poste{$poste}_Etape.csv";
?>
<h2>Poste <?= $poste ?></h2>

<?php
// Stock
$stockFile = $dataDir . "/Poste{$poste}_stock.csv";
if (file_exists($stockFile)):
?>
<h3>État du stock</h3>
<table border="1" cellpadding="5">
<tr><th>Pièce</th><th>Quantité</th></tr>
<?php
if (($handle = fopen($stockFile, "r")) !== false):
    $firstLine=true;
    while (($data = fgetcsv($handle)) !== false):
        if ($firstLine) { $firstLine=false; continue; }
?>
<tr>
    <td><?= $data[0] ?></td>
    <td><?= $data[1] ?></td>
</tr>
<?php
    endwhile;
    fclose($handle);
endif;
?>
</table>
<?php endif; ?>

<!-- Étapes -->
<?php
if (file_exists($etapeFile)):
    $etapes = file($etapeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $currentStep = $_GET['etape'] ?? 0;
    if (isset($etapes[$currentStep])):
        $data = str_getcsv($etapes[$currentStep]);
        $numero = array_shift($data);
?>
<h3>Étape numéro <?= $numero ?></h3>
<table border="1" cellpadding="5">
<tr><th>Pièce</th><th>Quantité</th></tr>
<?php for ($i=0; $i<count($data); $i+=2): ?>
<tr>
    <td><?= $data[$i] ?></td>
    <td><?= $data[$i+1] ?></td>
</tr>
<?php endfor; ?>
</table>
<?php if ($currentStep+1 < count($etapes)): ?>
<a href="visualisation.php?poste=<?= $poste ?>&etape=<?= $currentStep+1 ?>">Suivant</a>
<?php endif; ?>
<?php endif; endif; ?>

<?php endif; ?>

</body>
</html>
