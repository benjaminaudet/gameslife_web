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

	$titre = 'Voter';
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section class="page-info-block">

	    <div class="container">	

		      	<ol class="breadcrumb">
		      		<h2 style="color:white;">Statut du vote</h2>
		      		
			      		<div id="bip" class="display">
			      			<div class="alert">Sélectionnez un vote ci-dessous.</div>
			      		</div>
		      		<div class="clear" style="margin: 20px;"></div>
		      	</ol>
		      	
					<?php
					if(isset($_POST['inputString'])) :
						$inputString = htmlspecialchars($_POST['inputString']);
						$_SESSION['Pseudo_String'] = $inputString;
						$i=1;

						/* SELECTION DU JOUEUR */
						$query = $bdd->prepare('SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo');
						$query->bindParam(':user_pseudo', $inputString);
						$query->execute();
					
						if($query->rowCount() == 1) :

							$sites = $bdd -> prepare('SELECT * FROM vote_sites');
							$sites -> execute();	
							 
							while($returnSITE = $sites->fetch(PDO::FETCH_OBJ)) :
								$idSITE = $returnSITE->id;
								$nomSITE = $returnSITE->nom;
								$tempsSITE = $returnSITE->temps;
								$imageSITE = $returnSITE->image;
								$urlSITE = $returnSITE->url;


								$infoVote = $bdd->prepare('SELECT * FROM vote_joueurs WHERE user_pseudo = :user_pseudo AND nom = :nom');
								$infoVote->bindParam(':user_pseudo', $inputString);
								$infoVote->bindParam(':nom', $nomSITE);
								$infoVote->execute();

								if($infoVote->rowCount() == 0) :
									$time = 0;

									$insertion = $bdd->prepare('INSERT INTO vote_joueurs(user_pseudo, nom, date) VALUE (:user_pseudo, :nom, :date)');
									$insertion -> bindParam(':user_pseudo', $inputString);
									$insertion -> bindParam(':nom', $nomSITE);
									$insertion -> bindParam(':date', $time);
									$insertion -> execute();
									if($insertion->rowCount() == 1) :
										$verificationVOTE = true;
										$heureVOTE = 0;
									endif;
								else : 
									$infoJOUEUR = $infoVote->fetch(PDO::FETCH_OBJ); 

									$verificationVOTE = true;
									$heureVOTE = $infoJOUEUR->date;
								endif;

								if($verificationVOTE == true) :
									$tempsRESTANT = (time() - $heureVOTE) / 60;

									if($tempsRESTANT > $tempsSITE) :
									?>
										<h2 style="color:white;">Votez sur <?php echo $nomSITE; ?></h2>
										<center>

										    Cliquez sur l'image ci-dessous, s'il vous plaît.<br><br>
										    <img src="<?php echo $imageSITE; ?>"  target="_vote" onClick="window.open('../voter/return.php?id=<?php echo $idSITE;?>'); start();" style="border-radius:5px; cursor:pointer;">

										</center>
										<br>
									<?php
									else :
										echo '<h2 style="color:white;">Votez sur '.$nomSITE.'</h2>';
										$tempsRESTANT = round($tempsSITE - $tempsRESTANT, 0);
										$show->showError("Vous devez encore patienter ".$tempsRESTANT." minutes avant de pouvoir revoter !.");
									endif;
								endif;

								$i++;
							endwhile;

						else :
							$show->showError('Personnage non trouvé, veuillez vous inscrire pour voter.');
						endif;
						
							
					endif;
				?>

			<br /><br />

	    </div>			
    </section>

    <?php include '../jointures/footer.php'; ?>