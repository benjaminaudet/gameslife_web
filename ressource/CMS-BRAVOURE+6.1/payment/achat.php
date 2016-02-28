<?php 
@session_start();
 @header('Content-type: text/html; charset=utf-8');
 
if (isset($_SESSION['utilisateur']) && !empty($_SESSION['utilisateur'])) 
{ 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');


	if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['serveur']) && !empty($_POST['serveur']))
	{
		$id = intval($_POST['id']);
		
		$serveur_get = htmlspecialchars($_POST['serveur']);

		$explode_serveur = explode("_", $serveur_get);
		$serveur_get = $explode_serveur[1];

			$i = array(1,2,3,4,5,6,7,8,9,10);
			if (in_array($serveur_get, $i)) 
			{
				for ($i = 1; $i <= 10; $i++) 
				{
					if($serveur_get == $i)
					{
						$serveur = 'connexion_'.$i.'';
					}
				}
			}
			else
			{
				$serveur = 'connexion_1';	
			}

		function historique($offre, $bdd)
		{ 
			if(isset($_SESSION['utilisateur']) && !empty($_SESSION['utilisateur'])) 
			{
				$time = time();
				$req = $bdd->prepare('INSERT INTO historique(joueur, date_achat, nom_offre, adresse_ip) VALUES(:joueur, :date_achat, :nom_offre, :adresse_ip)');
				$req -> bindParam(':joueur', $_SESSION['utilisateur']['user_pseudo'], PDO::PARAM_STR);
				$req -> bindParam(':date_achat', $time, PDO::PARAM_STR);
				$req -> bindParam(':nom_offre', $offre, PDO::PARAM_STR);
				$req -> bindParam(':adresse_ip', $_SERVER["REMOTE_ADDR"]);
				$req -> execute();
			}
		}	
		
			$query = $bdd->prepare ("SELECT * FROM boutique WHERE id = :id");
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->execute();
			
			if($query->rowCount() == 1)
			{
				$res = $query->fetch(PDO::FETCH_OBJ); 
		
				if ($_SESSION['buy'] == true) 
				{	
					if ($res->serveur == $serveur)
					{
						$deduction = false;
						if($res->prix_promotion == 0){
                        	$payer = $res->prix;
                        } else {
                        	$payer = $res->prix_promotion;
                        }
                        
						if ($_SESSION['utilisateur']['user_points'] - $payer >= 0)
						{
							
							if($serveur == 'connexion_1')
							{
								$connexion_serveur = $connexion_1;
							}
							elseif ($serveur == 'connexion_2') {
								$connexion_serveur = $connexion_2;
							}
							elseif ($serveur == 'connexion_3') {
								$connexion_serveur = $connexion_3;
							}
							elseif ($serveur == 'connexion_4') {
								$connexion_serveur = $connexion_4;
							}
							elseif ($serveur == 'connexion_5') {
								$connexion_serveur = $connexion_5;
							}
							elseif ($serveur == 'connexion_6') {
								$connexion_serveur = $connexion_6;
							}
							elseif ($serveur == 'connexion_7') {
								$connexion_serveur = $connexion_7;
							}
							elseif ($serveur == 'connexion_8') {
								$connexion_serveur = $connexion_8;
							}
							elseif ($serveur == 'connexion_9') {
								$connexion_serveur = $connexion_9;
							}
							elseif ($serveur == 'connexion_10') {
								$connexion_serveur = $connexion_10;
							}

								if($serveur == $res->serveur)
								{
									$playerconnect = $connexion_serveur->call("getPlayer", array($_SESSION['utilisateur']['user_pseudo']));
									$connect = $playerconnect["success"]["ip"]; 
									
									if($connect =="offline")
									{
										$show->showError('Vous devez être connecté en jeu.');
									}
									else
									{
										$user_points = $_SESSION['utilisateur']['user_points'] - $payer;
										
										$update = $bdd->prepare('UPDATE joueurs SET user_points = :user_points WHERE user_pseudo = :user_pseudo');
										$update -> bindParam(':user_points', $user_points);
										$update -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo']);	 
										$update -> execute();
											
										if($update->rowCount() == 1)
										{
											if($res->ordre_id == 'cape' OR $res->ordre_id == 'skin') 
											{
												if($res->ordre_id == 'cape')
												{
													$update = $bdd->prepare('UPDATE joueurs SET user_cloak = :user_cloak WHERE user_pseudo = :user_pseudo'); 
													$update->execute(array(
														'user_cloak' => '1',
														'user_pseudo' => $_SESSION['utilisateur']['user_pseudo']
													));

													$buyer = true;
													$show->showSuccess('L\'achat a été effectué avec succès.');	
												}
												elseif($res->ordre_id == 'skin')
												{
													$update = $bdd->prepare('UPDATE joueurs SET user_skin = :user_skin WHERE user_pseudo = :user_pseudo'); 
													$update->execute(array(
														'user_skin' => '1',
														'user_pseudo' => $_SESSION['utilisateur']['user_pseudo']
													));

													$buyer = true;
													$show->showSuccess('L\'achat a été effectué avec succès.');	
												}
											} 
											elseif($res->grade_necessaire ==! '')
											{
												$show->showSuccess('L\'achat a été effectué avec succès.');									
												$pseudo = $_SESSION['utilisateur']['user_pseudo'];
												$commander= $res->commande;
												$commande_exp = explode(" ", $commander);
												$requeteBing = str_replace('pseudo_var', $pseudo, $commander);
													
												$commande_incite = explode(";", $requeteBing);
												$count_Commande = substr_count($requeteBing, ';').'<br />';
													
												for ($i = 0; $i < $count_Commande; $i++)
												{
													$connexion_serveur->call("runConsoleCommand", array("".$commande_incite[$i].""));
												}

												$connexion_serveur->call("runConsoleCommand", array("bcast Boutique : ".$pseudo." vient d'acheter ".$res->nom."."));
											}
											else
											{

												$show->showSuccess('L\'achat a été effectué avec succès.');									
												$pseudo = $_SESSION['utilisateur']['user_pseudo'];
												$commander= $res->commande;
												$commande_exp = explode(" ", $commander);
												$requeteBing = str_replace('pseudo_var', $pseudo, $commander);
													
												$commande_incite = explode(";", $requeteBing);
												$count_Commande = substr_count($requeteBing, ';').'<br />';
													
												for ($i = 0; $i < $count_Commande; $i++)
												{
													$connexion_serveur->call("runConsoleCommand", array("".$commande_incite[$i].""));
												}

												$connexion_serveur->call("runConsoleCommand", array("bcast Boutique : ".$pseudo." vient d'acheter ".$res->nom."."));
											}

											historique($id, $bdd);
											$_SESSION['utilisateur']['user_points'] = $_SESSION['utilisateur']['user_points'] - $payer;
											
										}
									}
								}


								
								$_SESSION['buy'] = false;
								
						}
						else
						{
							$show->showError('Solde insufisant.');
						}
				

					}
					else
					{
						$show->showError('Item inconnu.');
						exit;
					}
				}
				elseif ($_SESSION['buy'] == false)
				{
					$show->showError('<b> Vous avez déjà effectué l\'achat.</div>');
				}
		
			}
			else
			{
				$show->showError('Item inconnu.</div>');
				exit;
			}
		
		}	
		else
		{
			$show->showError('<b>Erreur</b>');
			exit;
		}
}
else
{
	$show->showError('Vous devez vous connecter afin de pouvoir effectuer cet achat.</div>');
}

?>