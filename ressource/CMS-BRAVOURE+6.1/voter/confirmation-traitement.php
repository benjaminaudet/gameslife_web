<?php
@session_start();
 @header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');


	$ip = $_SERVER['REMOTE_ADDR'];
	$inputString = $_SESSION['Pseudo_String'];

	$selection = $bdd -> prepare('SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo');
	$selection -> bindParam(':user_pseudo', $inputString);
	$selection -> execute();	
	
	if($selection->rowCount() == 1) :

		if(!isset($_SESSION['out_faux'])) { $_SESSION['out_faux'] = ''; }
		
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


			if($query->rowCount() == 0) :
				$_SESSION['out_faux'] = 0;	

				$time = 0;
				
				$historique = $bdd->prepare('INSERT INTO vote_ip (ip, date_vote, nom) VALUE (:ip, :date_vote, :nom)');
				$historique -> bindParam(':ip', $ip);
				$historique -> bindParam(':date_vote', $time);
				$historique -> bindParam(':nom', $nomSITE);
				$historique -> execute();
			endif;

			$tempsRESTANT = (time() - $heureVOTEIP) / 60;

			if($tempsRESTANT > $tempsSITE) :

				$_SESSION['out'] = true;
				echo '<br />';
				echo '<a href="" class="btn btn-primary"  style="margin-right:25px;" onclick="request(\'recompenses.php?verification=items\',\'xmlhttp\');return(false)">Obtenir ma récompense</a>';
				echo '<a href="" class="btn btn-primary" onclick="request(\'recompenses.php?verification=stocked\',\'xmlhttp\');return(false)">Plus tard</a>';
				echo '<br /><div id="xmlhttp"></div>';	

			else :
				echo '<br>';
				$show->showError("Votre IP a déjà été utilisée pour voter sur ".$nomSITE."!");
			endif;

		endif;

	else :
		$show->showError("Personnage non trouvé, veuillez ré-essayer.");
	endif;
?>