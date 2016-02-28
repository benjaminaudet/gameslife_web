<?php
@session_start();
 header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');


	if(isset($_GET['id']) && !empty($_GET['id'])) :

		$id = intval($_GET['id']);

		$query = $bdd->prepare('SELECT * FROM vote_sites WHERE id = :id');
		$query->bindParam(':id', $id);
		$query->execute();

		if($query->rowCount() == 1) :
			$siteURL = $query->fetch(PDO::FETCH_OBJ);

			$_SESSION['vote_sites.id'] = $id;

			$URLSITE = $siteURL->url;
			
			if(isset($_SESSION['vote_sites.id'])) :
				header("Location: ".$URLSITE);
				?> <meta http-equiv="refresh" content="0; URL=<?php echo $URLSITE; ?>"> <?php
			endif;
		endif;
		

	endif;
?>

<img src="loadingPopup.gif">