<?php
@session_start();
 @header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
  
  echo '<br>';
	if ($_SESSION['out'] == true): 

		$inputString = $pseudo = $_SESSION['Pseudo_String'];
		$date = time();

		$selection = $bdd -> prepare('SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo');
		$selection -> bindParam(':user_pseudo', $inputString);
		$selection -> execute();

		if($selection->rowCount() == 1) :

			$siteVOTE = $bdd->prepare('SELECT * FROM vote_sites WHERE id = :id');
			$siteVOTE->bindParam(':id', $_SESSION['vote_sites.id']);
			$siteVOTE->execute();

			if($siteVOTE->rowCount() == 1) :

				$returnSITE = $siteVOTE->fetch(PDO::FETCH_OBJ);
				
				// Définitions des variables
				$idSITE = $returnSITE->id;
				$nomSITE = $returnSITE->nom;
				$tempsSITE = $returnSITE->temps;
				$imageSITE = $returnSITE->image;
				$urlSITE = $returnSITE->url;

				$query = $bdd->prepare('SELECT * FROM vote_ip WHERE ip = :ip AND nom = :nom');
				$query->bindParam(':ip', $ip);
				$query->bindParam(':nom', $nomSITE);
				$query->execute();

				$infoVOTEIP = $query->fetch(PDO::FETCH_OBJ);
				$heureVOTEIP = $infoVOTEIP->date_vote;
				$tempsRESTANT = (time() - $heureVOTEIP) / 60;

				if($tempsRESTANT > $tempsSITE) :

					$infoVote = $bdd->prepare('SELECT * FROM vote_joueurs WHERE user_pseudo = :user_pseudo AND nom = :nom');
					$infoVote->bindParam(':user_pseudo', $inputString);
					$infoVote->bindParam(':nom', $nomSITE);
					$infoVote->execute();
					
					$infoJOUEUR = $infoVote->fetch(PDO::FETCH_OBJ); 
					$heureVOTE = $infoJOUEUR->date;

					$tempsRESTANT = (time() - $heureVOTE) / 60;

					if($tempsRESTANT > $tempsSITE) :
						// TRAITEMENT
							$update = $bdd->prepare('UPDATE vote_ip SET date_vote = :date_vote WHERE ip = :ip AND nom = :nom');
							$update -> bindParam(':date_vote', $date);
							$update -> bindParam(':ip', $ip);
							$update ->bindParam(':nom', $nomSITE);
							$update -> execute();

							if($update->rowCount() == 1) :
								$update_joueurs = $bdd->prepare('UPDATE vote_joueurs SET date = :date_vote WHERE user_pseudo = :user_pseudo AND nom = :nom');
								$update_joueurs -> bindParam(':date_vote', $date);
								$update_joueurs -> bindParam(':user_pseudo', $inputString);
								$update_joueurs -> bindParam(':nom', $nomSITE);
								$update_joueurs -> execute();								

								$update_user = $bdd->prepare('UPDATE joueurs SET vote = vote +1 WHERE user_pseudo = :user_pseudo');
								$update_user -> bindParam(':user_pseudo', $inputString);
								$update_user -> execute();

								if(($update_joueurs->rowCount() == 1) && ($update_joueurs->rowCount() == 1)) :
									
									if($_GET['verification'] == "stocked")  : 
										$update = $bdd->prepare('UPDATE joueurs SET recompenses = recompenses + 1 WHERE user_pseudo = :user_pseudo');
										$update -> bindParam(':user_pseudo', $inputString);	 
										$update -> execute();

										$show->showSuccess("Félicitation ! Vous pouvez désormais récupérer vos récompense(s) en allant dans la gestion de votre compte.");
									else :
										$query = $bdd->prepare('SELECT SUM(p) AS somme FROM probabilites');
										$query->execute();
										$string = $query->fetch();
										$nbr_items = $string['somme'];
										
										$query = $bdd->prepare ("SELECT * FROM probabilites");
										$query->execute();
									
										$prob = 1000;
										$rand = mt_rand(0, $prob);						
									
										$items = array();

										while($resultats = $query->fetch(PDO::FETCH_OBJ)):
											$items[$resultats->quantite.'|'.$resultats->nom.'|'.$resultats->commande.''] = $resultats->p / $nbr_items;
										endwhile;

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

										echo '<br>';
										if($commande_exp[0] == 'POINTS'):
											$requete = str_replace("POINTS ", "", $commande);		
											$VoteBoutique = $requete;
											
											$show->showSuccess('<b> Succès</b> : '.$pseudo.' vous venez d\'obtenir le cadeau suivant : <b> '.$quantite.' '.$nom.' </b>');
											
											$update = $bdd->prepare('UPDATE joueurs SET user_points = user_points + :user_points WHERE user_pseudo = :user_pseudo');
											$update -> bindParam(':user_points', $VoteBoutique);
											$update -> bindParam(':user_pseudo', $pseudo);	 
											$update -> execute();
										
											$connexion_1->call("runConsoleCommand", array("broadcast ".$pseudo." vient de gagner ".$quantite." ".$nom." en votant."));
										else :
											$show->showSuccess('<b> Succès</b> : Vous venez d\'obtenir le cadeau suivant : <b> '.$quantite.' '.$nom.' </b>.');
											
											$commande = str_replace('pseudo_var', $pseudo, $commande);
											$connexion_1->call("runConsoleCommand", array("".$commande.""));
											$connexion_1->call("runConsoleCommand", array("broadcast ".$pseudo." vient de gagner ".$quantite." ".$nom." en votant."));

										endif;
										
									endif;

									$_SESSION['out'] = false;
								else :
									$show->showError("Code erreur #N8009");
								endif;
							else :
								$show->showError("Code erreur #N76050");
							endif;

						// TRAITEMENT
					else :
						echo '<br>';
						$show->showError("Vous devez attendre ".$tempsRESTANT." minutes.");
					endif;

				else :
					echo '<br>';
					$show->showError("Votre IP a déjà été utilisée pour voter sur ".$nomSITE."!");
				endif;

			else :
				$show->showError("Code erreur #N0148");
			endif;

		else :
			$show->showError("Personnage non trouvé.");
		endif;	

	elseif ($_SESSION['out'] == false) :
		$show->showError('<b>Erreur</b> : Votre récompense a déjà été obtenue.');
	endif;
			
?>