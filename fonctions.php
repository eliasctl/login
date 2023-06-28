<?php

function doit_etre_connecte()
{
    // cette fonction permet de vérifier si une personne est connecté
    // si elle n'est pas connecté on la renvoie sur la page de connexion
    if (!isset($_SESSION["pseudo"])) {
        echo "<script type='text/javascript'>alert('Vous devez être connecter pour accéder à cette page'); window.location.href='connexion.php';</script>";
    }
}

function doit_etre_admin()
{
    // on vérifie si la personne est admin pour lui autoriser l'accès à la page
    // si elle ne l'est pas alors on affiche un popup alert et redirection vers la page d'accueil
    if ($_SESSION["type"] !== 'admin') {
        echo "<script type='text/javascript'>alert('Cette page est réservée aux administrateurs'); window.location.href='index.php';</script>";
    }
}

function recuperer_les_utilisateurs()
{
    // cette fonction permet de récupérer les utilisateurs de la base de données
    // Sortie: tableau_de_utilisateurs[id][pseudo]
    //                                  [email]
    //                                  [type]
    //                                  [code]
    //                                  [id]
    //                                  [panier]
    //                                  [achats]
    //                                  [argent]

    global $conn;
    $query = "SELECT * FROM `utilisateurs`";
    $res = mysqli_query($conn, $query);
    $tableau_de_utilisateurs = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $tableau_de_utilisateurs[$row['id']]['pseudo'] = $row['pseudo'];
        $tableau_de_utilisateurs[$row['id']]['email'] = $row['email'];
        $tableau_de_utilisateurs[$row['id']]['type'] = $row['type'];
        $tableau_de_utilisateurs[$row['id']]['code'] = $row['code'];
        $tableau_de_utilisateurs[$row['id']]['id'] = $row['id'];
        $tableau_de_utilisateurs[$row['id']]['panier'] = $row['panier'];
        $tableau_de_utilisateurs[$row['id']]['achats'] = $row['achats'];
        $tableau_de_utilisateurs[$row['id']]['argent'] = $row['argent'];
    }
    return $tableau_de_utilisateurs;
}

function changer_de_code($id_utilisateur, $nouveau_code)
{
    $Code = hash('sha256', $nouveau_code);
    global $conn;
    $query = "UPDATE `utilisateurs` SET `code` = '" . $Code . "' WHERE `id` = '" . $id_utilisateur . "'";
    $res = mysqli_query($conn, $query);
    if ($res) {
        echo "Ok! Le code a été changé";
    } else {
        echo "Une erreur est survenue";
    }
}

function supprimer_un_utilisateur($id_utilisateur)
{
    global $conn;
    $query = "DELETE FROM `utilisateurs` WHERE `id` = '" . $id_utilisateur . "'";
    $res = mysqli_query($conn, $query);
    if ($res) {
        echo "Ok! L'utilisateur a été supprimé";
    } else {
        echo "Une erreur est survenue";
    }
}
?>