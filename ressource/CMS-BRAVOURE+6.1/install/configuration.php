<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<?php
@session_start();
('Content-type: text/html; charset=utf-8');
 //ini_set("display_errors",0);
 //error_reporting(0);
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');

 $titre = 'Installation de SamantCMS';
require_once ("../jointures/head.php");
?>

<body>
<div class="container">

        <center><img src="../install/samant.png"></center>

          <!-- Jumbotron -->
          <div class="jumbotron">
            <center><h1 class="bold">Etape 4 : <strong>Configuration générale</strong></h1>
<?php
          if(isset($_POST['etape4']))
          {
            if(empty($_POST['nom_serveur']) || empty($_POST['vote']) || empty($_POST['skype']) || empty($_POST['ip_serveur']) || empty($_POST['description']))
            {
              echo '<div class="alert alert-danger">Vous devez rentrer vos informations serveur.</div>';
            }
            else
            {
                        $nom = htmlspecialchars($_POST['nom_serveur']);
                        $vote = htmlspecialchars($_POST['vote']);
                        $skype = htmlspecialchars($_POST['skype']);
                        $ip_serveur = htmlspecialchars($_POST['ip_serveur']);
                        $description = htmlspecialchars($_POST['description']);
						$fb = htmlspecialchars($_POST['fb']);
						$tw = htmlspecialchars($_POST['tw']);
              
                $data = '
              <?php
                  // Ne pas toucher
                  define("ROOTPATH", "http://".$_SERVER["HTTP_HOST"]."", true);
                  $ip = $_SERVER["REMOTE_ADDR"];
                  // Ne pas toucher

                  // Remplacer Samant par le nom de votre site
                  define("SITE", "'.$nom.'", true);
                  define("JSONAPI", "1", true); // 0 : fermé / 1 : ouvert
                  define("NombreServeur", "1", true); // nombre de serveur
                  define("tw", "'.$tw.'", true);
				  define("fb", "'.$fb.'", true);
                      $skype = "'.$skype.'"; // skype du modérateur
                      $ip_serveur = "'.$ip_serveur.'"; // IP serveur
                      $description = "'.$description.'"; // description sur la page accueil
					  $commentaire = "'.$commentaire.'"; // 
                    
                      /*************************************************************************/
                      /************************** SYSTEME DE VOTE  *****************************/
                      /*************************************************************************/  
                    $rpgURL = "'.$vote.'"; 

                      /*************************************************************************/
                      /************* BOUTIQUE - Modifications des images - Bug *****************/
                      /*************************************************************************/  

                      $largeur_image = "60"; // la largeur des images dans la boutique en pixels
                      $longueur_image = "100"; // la longueur des images dans la boutique en pixels

                      /*************************************************************************/
                      /************* SYSTEME JSONAPI CONNEXION /!\ ATTENTION /!\   *************/
                      /*************************************************************************/  
                      if (JSONAPI == 1) 
                      { 
                          include("../configuration/jsonapi_configuration.php");
                      }

                      /*******************************************************************/
                      /************* SYSTEME DE PAIEMENT /!\ ATTENTION /!\   *************/
                      /*******************************************************************/  

                          include ("../configuration/starpass.php");


                      /**********************************/
                      /************* PAYPAL *************/
                      /**********************************/  

                      include ("../configuration/paypal.php");


                      /****************************************************************************/
                      /************* MODIFIER LA COULEUR DE VOTRE SITE (BackGround)   *************/
                      /****************************************************************************/ 

                      include "../configuration/couleurs.php";


              ?>

              ';

                $fp = fopen("../configuration/configuration.php","w+");
                fwrite($fp, $data);
                fclose($fp);

                echo '<div class="alert alert-success">Etape validée redirection vers la suivante dans 3 secondes</div>';
                header ("Refresh: 3;URL=../install/achats.php");

                echo '<a href="../install/achats.php" class="btn btn-secondary btn-thicker space">Etape suivante</a><br><br>';

            }
          } ?>
            <form action="" method="post">
                <div class="form-group">
                  <label for="">Nom du serveur</label>
                  <input type="text" class="form-control" name="nom_serveur">              
                </div>

                <div class="form-group">
                  <label for="">Lien de vote</label>
                  <input type="text" class="form-control" name="vote">              
                </div>

                <div class="form-group">
                  <label for="">Skype</label>
                  <input type="text" class="form-control" name="skype">              
                </div>

                <div class="form-group">
                  <label for="">IP du serveur</label>
                  <input type="text" class="form-control" name="ip_serveur">              
                </div>
                <div class="form-group">
                  <label for="">Facebook</label>
                  <input type="text" class="form-control" name="fb">              
                </div>
				<div class="form-group">
                  <label for="">Twitter</label>
                  <input type="text" class="form-control" name="tw">              
                </div>
                <div class="form-group">
                  <label for="">Description sur l'accueil</label>
                  <textarea class="form-control" name="description"></textarea>     
                </div>
                <input type="submit" name="etape4" class="btn btn-secondary btn-thicker space" value="Valider">
            </form>
		  
			<br><br>
			  <div class="news-article box-shadow well">
			  <center><h2><i class="fa fa-refresh fa-spin"></i> Progression de l'installation <strong>50%</strong></h2></center>
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                <span class="skill"><i class="val">50%</i></span>
				</div>
              </div>
			  </div>
			
          </div>
          <!-- /Jumbotron -->
</div>

  </div>  <?php require_once("../install/footer.php");?>  

  </div>