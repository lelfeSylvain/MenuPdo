<!DOCTYPE html>
<?php
/* Projet menu du self v2 
  sylvain mars 2016
 */
require_once 'inc/fonctions.php'; //appelle tous les 'include' et fonctions utilitaires


/*
 * examinons les paramètres get 
 */
if (!isset($_REQUEST['uc'])) {//s'il n'y a pas d'uc alors on consulte le menu
    $uc = 'lecture';
    $num = 'actuelle';
} else { // s'il y a un uc, on l'utilise après l'avoir nettoyé
    $uc = clean($_REQUEST['uc']);
    if (isset($_REQUEST['num'])) {
        $num = clean($_REQUEST['num']);
    } else {
        $num = "actuelle";
    }
}
if ($uc === 'login') {
    include('controleurs/c_login.php');
}
// si l'utilisateur n'est pas identifié, il doit le faire
elseif (!Session::isLogged()) {
    include('controleurs/c_semaine.php');
} else {// à partir d'ici, l'utilisateur est forcément connecté
    // instanciation de la fabrique de vue
    //$vue = FabriqueVue::getFabrique();

    // justement on enregistre la dernière activité de l'utilisateur dans la BD
    $pdo->setDerniereCx($_SESSION['numUtil']);
//echo $uc.EOL;
    // gère le fil d'ariane : TODO à gérer
    //include_once 'controleurs/c_ariane.php';
    //aiguillage principal
    switch ($uc) {
        case 'lecture': {// uc lecture du menu 
                include("controleurs/c_semaine.php");
                break;
            }
        case 'ecrire': {// uc création d'un repas
                include("controleurs/c_creation.php");
                break;
            }
        case 'creerUtil': // créer un nouvel utilisateur (seulement SUser)
        case 'changer': {// uc modification du mot de passe
                include("controleurs/c_changerMDP.php");
                break;
            }
/* vieux chemin permettant de migrer la BD
        case 'convertir': {// conversion de la base
                include("controleurs/c_conversion.php");
                break;
            }*/
        default :  // par défaut on consulte les posts
            include("controleurs/c_semaine.php");
    }
}
/*
 * une visite a lieu, mémorisons-la
 */
include('controleurs/c_visite.php');

