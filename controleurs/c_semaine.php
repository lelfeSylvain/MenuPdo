<?php

// quel jour sommes-nous ?
if (empty($_POST['date'])) {
    $m = new DateTime();
    $maDate = $m->format("Y-m-d");
    unset($m);
} else {
    $maDate = $_POST['date'];
}
$num = $_REQUEST['num'];
//effacer à partir d'ici
// ici on initialise pour des tests
// TODO en fin de projet effacer tout le else
// $maDate ="2015-10-01";

// effacer jusque là

$maSem = new Semaine($maDate);
$jour = $maSem->getLundi();
for ($i = 0; $i < 10; $i++) {
    $LesMenus[$i] = new V_Repas(new Repas($pdo->getLeRepas($maSem, $i + 1)));
}
$estMatin = "matin";
$selection=11;
if ($num === "actuelle") {// on consulte le menu de la semaine actuelle
    // le prochain repas
    // Quelle heure est-il ?
    $maintenant = new DateTime();
    $h = $maintenant->format("H");
    // Quel jour sommes-nous ? 1 : lundi, 5 : vendredi
    // x2 => 2 : lundi soir, 10 : vendredi soir
    $j = $maintenant->format("N") * 2;
    if ($h > 13) {
        $estMatin = "soir";
    } else {
        // si on pointe sur le matin on est sur le service du midi
        $estMatin = "matin";
        $j--;
    }
    // mais on peut être le week-end aussi
    if ($j > 9) { // du coup on recalcule tout
        $j = 1;
        $maSem = $maSem->getSemaineProchaine();
        $estMatin = "matin";
        $jour = $maSem->getLundi();
        for ($i = 0; $i < 10; $i++) {
            $LesMenus[$i] = new V_Repas(new Repas($pdo->getLeRepas($maSem, $i + 1)));
        }
    }
    // Service à mettre en valeur 
    $selection = $j;
}
include 'vues/v_semaine.php';
?>
