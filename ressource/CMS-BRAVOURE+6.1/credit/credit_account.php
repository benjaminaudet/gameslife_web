<?php
session_start();
 header("Content-type: text/html; charset=utf-8");
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once("../configuration/baseDonnees.php");
  require_once("../configuration/fonctions.php");
  
 $titre = "Créditer mon compte";
require_once ("../jointures/head.php");
actualisation_session($bdd);

require_once("../jointures/header.php");

function historique($offre, $nombre_points_insert, $bdd){ 
    if(isset($_SESSION["utilisateur"]) && !empty($_SESSION["utilisateur"])) 
    {
                $time = time();
                $point_after = $_SESSION["utilisateur"]["user_pseudo"] + $nombre_points_insert;
                
                $req = $bdd->prepare("INSERT INTO historique_credit(joueur, date_achat, nom_offre, adresse_ip, user_points_after) VALUES(:joueur, :date_achat, :nom_offre, :adresse_ip, :user_points_after)");
                $req -> bindParam(":joueur", $_SESSION["utilisateur"]["user_pseudo"], PDO::PARAM_STR);
                $req -> bindParam(":date_achat", $time, PDO::PARAM_STR);
                $req -> bindParam(":nom_offre", $offre, PDO::PARAM_STR);
                $req -> bindParam(":adresse_ip", $_SERVER["REMOTE_ADDR"]);
                $req -> bindParam(":user_points_after", $point_after);
                $req -> execute();
    }
}	
?>

    <section class="content-block default-bg">

        <div class="container">

          <div class="section-title">		
            <h2>Créditer mon compte</h2>
            <div class="line"></div>
            <p>Vérification de votre code ...</p>
          </div><br><br>

              <?php if (isset($_SESSION["utilisateur"])){?>
					
               
            <div class="box-shadow well">
               
			<?php
				if(isset($_POST["DATAS"])) 
				{

			// Déclaration des variables
			$ident=$idp=$ids=$idd=$codes=$code1=$code2=$code3=$code4=$code5="";
					$datas = $_POST["DATAS"];
					
					if($datas == $idd_1 && $_SESSION["type_achat"] == $idd_1)
					{
						$Idd = $idd_1;
						$Idp = $idp_1;
						$nombre_points_insert = $nombre_points_1;
						$offre_nom = "Offre 1 - ".$nombre_points_1." points";
					}
					elseif($datas == $idd_2 && $_SESSION["type_achat"] == $idd_2)
					{
						$Idd = $idd_2;
						$Idp = $idp_2;
						$nombre_points_insert = $nombre_points_2;
						$offre_nom = "Offre 2 - ".$nombre_points_2." points";
					}
					elseif($datas == $idd_3 &&	$_SESSION["type_achat"] == $idd_3)
					{
						$Idd = $idd_3;
						$Idp = $idp_3;
						$nombre_points_insert = $nombre_points_3;
						$offre_nom = "Offre 3 - ".$nombre_points_3." points";
					}

			$idp = $Idp;

			$idd = $Idd;
			$ident=$idp.";".$ids.";".$idd;

				if(isset($_POST["code1"])) $code1 = $_POST["code1"];
				if(isset($_POST["code2"])) $code2 = ";".$_POST["code2"];
				if(isset($_POST["code3"])) $code3 = ";".$_POST["code3"];
				if(isset($_POST["code4"])) $code4 = ";".$_POST["code4"];
				if(isset($_POST["code5"])) $code5 = ";".$_POST["code5"];
			$codes=$code1.$code2.$code3.$code4.$code5;

				
			// On encode les trois chaines en URL
				$ident=urlencode($ident);
				$codes=urlencode($codes);
				$datas=urlencode($datas);

			/* Envoi de la requête vers le serveur StarPass
			Dans la variable tab[0] on récupère la réponse du serveur
			Dans la variable tab[1] on récupère l"URL d"accès ou d"erreur suivant la réponse du serveur */
			$get_f=@file("http://script.starpass.fr/check_php.php?ident=$ident&codes=$codes&DATAS=$datas");
			if(!$get_f)
			{
				exit('Votre serveur n"a pas accès au serveur de Starpass, merci de contacter votre hébergeur.');
			}
			$tab = explode("|",$get_f[0]);

			if(!$tab[1]) {
				$url = "http://script.starpass.fr/erreur.php";
			}
			else {
				$url = $tab[1];
			}

				// dans $pays on a le pays de l"offre. exemple "fr"
				$pays = $tab[2];
				// dans $palier on a le palier de l"offre. exemple "Plus A"
				$palier = urldecode($tab[3]);
				// dans $id_palier on a l"identifiant de l"offre
				$id_palier = urldecode($tab[4]);
				// dans $type on a le type de l"offre. exemple "sms", "audiotel, "cb", etc.
				$type = urldecode($tab[5]);

					if(substr($tab[0],0,3) != "OUI")
					{
						$show->showError('<h4 class="alert-heading">Erreur dans la vérification!</h4><Font color="black"> Le code entré semble être eronné. </font><br><a href="../support/" class="btn btn-danger">Support Client</a> &nbsp;&nbsp;<a href="../credit/" class="btn btn-secondary btn-thicker space">Recommencer</a>');
					}
					else
					{
						$show->showSuccess("Le code entré est validé");
														
								$user_points = $_SESSION["utilisateur"]["user_points"] + $nombre_points_insert; 
														
								$update = $bdd->prepare("UPDATE joueurs SET user_points = :user_points WHERE user_pseudo = :user_pseudo");
								$update -> bindParam(":user_points", $user_points);
								$update -> bindParam(":user_pseudo", $_SESSION["utilisateur"]["user_pseudo"]);	 
								$update -> execute();
                                
                                // Insertion dans l"historique crédit
                                historique($offre_nom, $nombre_points_insert, $bdd);
														
						}

					}
					else
					{
						echo ('<div class="alert alert-block alert-error fade in"><h4 class="alert-heading">Erreur : Problème de vérification.</h4><Font color="black"> Erreur dans la mise en place du code. En avez-vous mis un ?</font><br><br><a href="../credit/" class="btn btn-secondary btn-thicker space">Recommencer</a></div>');
					}
			?>					
			</div>	
			<?php
			}
			 else
			 {
				$show->showError('<h4 class="alert-heading">Erreur : Problème avec la connexion.</h4><Font color="black"> Vous devez être connecté pour pouvoir accéder à cette page. Merci de vous connecter. </font><br><a href="../inscription/" class="btn btn-danger">Inscription</a> &nbsp;&nbsp;<a href="../connexion/" class="btn">Se connecter</a> ');
			 }
		
			?>
	    </div>
    </section>

    <div class="footer-copyright">
          <?php require_once("../jointures/footer.php");?>  
	</div>
