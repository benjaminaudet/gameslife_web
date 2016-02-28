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
            <center><h1 class="bold">Etape 5 : <strong>Configuration des moyens de payements</strong></h1>
<?php if(isset($_POST['etape5']))
          {
            if(!isset($_POST['paypal_lv']))
            {
              echo '<div class="alert alert-danger">Vous devez renseigner si vous avez un paypal ou non.</div>';
            }
            else
            {
              if($_POST['paypal_lv'] == 'Oui') 
              {
                $email_paypal = $_POST['email_paypal'];
                $paypal_offre_1 = $_POST['paypal_offre_1'];
                $nbp_offre_1 = $_POST['nbp_offre_1'];

                $paypal_offre_2 = $_POST['paypal_offre_2'];
                $nbp_offre_2 = $_POST['nbp_offre_2'];

                $paypal_offre_3 = $_POST['paypal_offre_3'];
                $nbp_offre_3 = $_POST['nbp_offre_3'];

                $datapaypal = '
                <?php

                  $paypal = true; // si paypal = false : non actif
                  $email_paypal = "'.$email_paypal.'"; // Votre adresse PAYPAL

                      /**************************/
                      /***** PRIX EN EUROS/******/
                      /**************************/    
                      $prix_offre_1 = "'.$paypal_offre_1.'"; 
                      $prix_offre_2 = "'.$paypal_offre_2.'"; 
                      $prix_offre_3 = "'.$paypal_offre_3.'"; 

                      /**************************/
                      /***** PRIX EN EUROS/******/
                      /**************************/  
                      $points_offre_1 = "'.$nbp_offre_1.'"; 
                      $points_offre_2 = "'.$nbp_offre_2.'"; 
                      $points_offre_3 = "'.$nbp_offre_3.'"; 


                      $points_offre_1 = "'.$nbp_offre_1.' points boutique €'.$paypal_offre_1.' EUR"; 
                      $points_offre_1_CREDIT = "'.$nbp_offre_1.'";

                      $points_offre_2 = "'.$nbp_offre_2.' points boutique €'.$paypal_offre_2.' EUR"; 
                      $points_offre_2_CREDIT = "'.$nbp_offre_2.'";

                      $points_offre_3 = "'.$nbp_offre_3.' points boutique €'.$paypal_offre_3.' EUR";
                      $points_offre_3_CREDIT = "'.$nbp_offre_3.'";

                ?>
                ';

                $fppaypal = fopen("../configuration/paypal.php","w+");
                fwrite($fppaypal, $datapaypal);
                fclose($fppaypal);

                echo '<div class="alert alert-success">Configuration du Paypal avec succès</div>';
              }

              $idp_offre_1 = $_POST['idp_offre_1'];
              $idd_offre_1 = $_POST['idd_offre_1'];
              $nbt_offre_1 = $_POST['nbt_offre_1'];

              $idp_offre_2 = $_POST['idp_offre_2'];
              $idd_offre_2 = $_POST['idd_offre_2'];
              $nbt_offre_2 = $_POST['nbt_offre_2'];

              $idp_offre_3 = $_POST['idp_offre_3'];
              $idd_offre_3 = $_POST['idd_offre_3'];
              $nbt_offre_3 = $_POST['nbt_offre_3'];

              $data = '
              <?php

              $name_points = "points"; // Le nom de vos points

              /************************************/
              /************* STARPASS *************/
              /************************************/  

                $idd_1 = "'.$idd_offre_1.'";
                $idp_1 = "'.$idp_offre_1.'";
                $nombre_points_1 = "'.$nbt_offre_1.'";

                $idd_2 = "'.$idd_offre_2.'";
                $idp_2 = "'.$idp_offre_2.'";
                $nombre_points_2 = "'.$nbt_offre_2.'";

                $idd_3 = "'.$idd_offre_3.'";
                $idp_3 = "'.$idp_offre_3.'";
                $nombre_points_3 = "'.$nbt_offre_3.'";
              ?>
              ';

              $fp = fopen("../configuration/starpass.php","w+");
              fwrite($fp, $data);
              fclose($fp);

              echo '<div class="alert alert-success">Configuration du Starpass avec succès</div>';
              echo '<div class="alert alert-success">Etape validée redirection vers la suivante dans 3 secondes</div>';
              header ("Refresh: 3;URL=../install/presentation.php");

              echo '<a href="../install/presentation.php" class="btn btn-secondary btn-thicker space">Etape suivante</a><br><br>';

              
            }
          }
          ?>
            <br><h4>Progression de l'installation</h4>

            <div class="alert alert-info">N'oubliez pas de remplir tout les champs !</div>

            <form action="" method="post">
              <h4><span class="label label-default">PayPal</span></h4>
                <div class="form-group">
                  <label for="">Avez-vous paypal ?</label>

                  <input type="radio" class="form-control" name="paypal_lv" value="Oui">   Oui    
                  <input type="radio" class="form-control" name="paypal_lv" value="Non" selected="selected">   Non           
                </div>
				<br>
                <span class="alert alert-warning">Non obligatoire pour la suite si vous avez choisi non !</span>
				<br><br><br>
                <div class="form-group">
                  <label for="">Entrez votre email PayPal</label>
                  <input type="text" class="form-control" name="email_paypal">              
                </div>
                <hr>
                <div class="form-group">
                  <label for="">Prix Offre 1</label>
                  <input type="text" class="form-control" name="paypal_offre_1">              
                </div>
                <div class="form-group">
                  <label for="">Nombre de points :</label>
                  <input type="text" class="form-control" name="nbp_offre_1">              
                </div>
                <hr>
                <div class="form-group">
                  <label for="">Prix Offre 2</label>
                  <input type="text" class="form-control" name="paypal_offre_2">              
                </div>
                <div class="form-group">
                  <label for="">Nombre de points :</label>
                  <input type="text" class="form-control" name="nbp_offre_2">              
                </div>
                <hr>
                <div class="form-group">
                  <label for="">Prix Offre 3</label>
                  <input type="text" class="form-control" name="paypal_offre_3">              
                </div>
                <div class="form-group">
                  <label for="">Nombre de points :</label>
                  <input type="text" class="form-control" name="nbp_offre_3">              
                </div>

              <br><br>

              <h4><span class="label label-default">Starpass</span></h4>

                <div class="form-group">
                  <label for="">IDP (offre 1)</label>
                  <input type="text" class="form-control" name="idp_offre_1">              
                </div>
                <div class="form-group">
                  <label for="">IDD (offre 1)</label>
                  <input type="text" class="form-control" name="idd_offre_1">              
                </div>
                <div class="form-group">
                  <label for="">Nombre de points (offre 1)</label>
                  <input type="text" class="form-control" name="nbt_offre_1">              
                </div>

                <hr>
              
                <div class="form-group">
                  <label for="">IDP (offre 2)</label>
                  <input type="text" class="form-control" name="idp_offre_2">              
                </div>
                <div class="form-group">
                  <label for="">IDD (offre 2)</label>
                  <input type="text" class="form-control" name="idd_offre_2">              
                </div>
                <div class="form-group">
                  <label for="">Nombre de points (offre 2)</label>
                  <input type="text" class="form-control" name="nbt_offre_2">              
                </div>

                <hr>
              
                <div class="form-group">
                  <label for="">IDP (offre 3)</label>
                  <input type="text" class="form-control" name="idp_offre_3">              
                </div>
                <div class="form-group">
                  <label for="">IDD (offre 3)</label>
                  <input type="text" class="form-control" name="idd_offre_3">              
                </div>
                <div class="form-group">
                  <label for="">Nombre de points (offre 3)</label>
                  <input type="text" class="form-control" name="nbt_offre_3">              
                </div>
                <input type="submit" name="etape5" class="btn btn-secondary btn-thicker space" value="Valider">
            </form>

			<br><br>
			  <div class="news-article box-shadow well">
			  <center><h2><i class="fa fa-refresh fa-spin"></i> Progression de l'installation <strong>65%</strong></h2></center>
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                <span class="skill"><i class="val">65%</i></span>
				</div>
              </div>
			  </div>
			
        </div>

  </div>  <?php require_once("../install/footer.php");?>  

  </div>

  </body>
</html>