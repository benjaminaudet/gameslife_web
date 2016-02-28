<?php
session_start();
$serveur = $_SESSION['serveur'];
if(isset($_SESSION['admin'])) 
{
	
    //----------------------------------//
	require_once 'database/mysql.php';
	set_session($bdd);
	$titre = 'Boutique';
	//----------------------------------//

	require 'inc/head.php';
	if($_POST['action'] == 'edit')
	{
		$update = $bdd->prepare('UPDATE boutique SET ordre_id = :ordre_id, nom = :nom, description = :description, categorie = :categorie, commande = :commande, prix = :prix, image = :image  WHERE id = :id');
		$update -> bindParam(':ordre_id', $_POST['ordre_id']);
		$update -> bindParam(':nom', $_POST['nom']);
		$update -> bindParam(':description', $_POST['description']);
		$update -> bindParam(':categorie', $_POST['categorie']);
		$update -> bindParam(':commande', $_POST['commande']);
		$update -> bindParam(':prix', $_POST['prix']);
		$update -> bindParam(':image', $_POST['image']);
		$update -> bindParam(':id', $_POST['id']);
		$update -> execute();
		
		echo '<div class="alert alert-success">Succès : Vous avez modifié l\'item.</div>';
	}
	
	if($_POST['action'] == 'create')
	{
		$req = $bdd->prepare('INSERT INTO boutique(nom, ordre_id, description, categorie, commande, serveur, prix) VALUES(:nom, :ordre_id, :description, :categorie, :commande, :serveur, :prix)');
		$req -> bindParam(':nom', $_POST['nom']);
		$req -> bindParam(':ordre_id', $_POST['ordre_id']);
		$req -> bindParam(':description', $_POST['description']);
		$req -> bindParam(':categorie', $_POST['categorie']);
		$req -> bindParam(':commande', $_POST['commande']);
		$req -> bindParam(':serveur', $serveur);
		$req -> bindParam(':prix', $_POST['prix']);
		$req -> execute();
		
		echo '<div class="alert alert-success">Succès : Vous avez ajouté l\'item.</div>';
	}
}
?>