<?php
@session_start();
 @header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');

	if(isset($_SESSION['utilisateur'])) 
	{
		if($_GET['verification'] == "recuperer") 
		{	
			if($_SESSION['utilisateur']['recompenses'] > 0)
			{
				$pseudo = $_SESSION['utilisateur']['user_pseudo'];
				$countafter = $_SESSION['utilisateur']['recompenses'] -1;
				$NbrPoints = $_SESSION['utilisateur']['user_points'];

				$update = $bdd->prepare('UPDATE joueurs SET recompenses = recompenses-1 WHERE user_pseudo = :user_pseudo');
				$update -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo']);	 
				$update -> execute();
				
				if($update->rowCount() == 1)		
				{		
					$countRecompense = $bdd->prepare ("SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo");
					$countRecompense -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo']);	 
					$countRecompense->execute();

					$stringCountRecompense = $countRecompense->fetch(PDO::FETCH_OBJ);

					//echo $stringCountRecompense->recompenses;

					if($stringCountRecompense->recompenses >= 0)
					{

						$query = $bdd->prepare('SELECT SUM(p) AS somme FROM probabilites');
						$query->execute();
						$string = $query->fetch();
						$nbr_items = $string['somme'];
						
						$query = $bdd->prepare ("SELECT * FROM probabilites");
						$query->execute();
						
						$prob = 1000;
						$rand = mt_rand(0, $prob);						
						
						$items = array();

						while($resultats = $query->fetch(PDO::FETCH_OBJ))
						{
							$items[$resultats->quantite.'|'.$resultats->nom.'|'.$resultats->commande.''] = $resultats->p / $nbr_items;
						}
						asort($items);
																						
						$i = 0;
						foreach ($items as $name => $value) 
						{
							if ($rand <= $i+=($value * $prob)) 
							{
								$item = $name;
								break;
							}
						}

						list($quantite, $nom, $commande) = explode("|", $item);		
						$commande_exp = explode(" ", $commande);		


						if($commande_exp[0] == 'POINTS')
						{
							$requete = str_replace("POINTS ", "", $commande);		
							$VoteBoutique = $requete;
							
							$show->showSuccess('<b> Succès</b> : '.$pseudo.' vous venez d\'obtenir le cadeau suivant : <b> '.$quantite.' '.$nom.' </b>.');
							
							$update = $bdd->prepare('UPDATE joueurs SET user_points = user_points + :user_points WHERE user_pseudo = :user_pseudo');
							$update -> bindParam(':user_points', $VoteBoutique);
							$update -> bindParam(':user_pseudo', $pseudo);	 
							$update -> execute();
						
							$connexion_1->call("runConsoleCommand", array("sayme ".$pseudo." vient de gagner ".$quantite." ".$nom." en votant pour le serveur."));
						}
						
						else
						{
							$show->showSuccess('<b> Succès</b> : Vous venez d\'obtenir le cadeau suivant : <b> '.$quantite.' '.$nom.' </b>.');
							
							$commande = str_replace('pseudo_var', $pseudo, $commande);
							$connexion_1->call("runConsoleCommand", array("".$commande.""));
							$connexion_1->call("runConsoleCommand", array("sayme ".$pseudo." vient de gagner ".$quantite." ".$nom." en votant pour le serveur."));
						}
					}
					else
					{
						$show->showError("Rafraichissez votre page pour récupérer une autre récompense.");
					}

				}
				else
				{
					$show->showError("Rafraichissez votre page pour récupérer une autre récompense.");
				}
			}
			else
			{
				$show->showError("Impossible d'effectuer cette transaction. Vous devez avoir accumulé au moins une récompense.");
			}
		}
	}
	else
	{
		$show->showError('Vous devez être connecté pour recevoir votre récompense.');
	}
			
?>