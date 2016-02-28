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
            <center><h1 class="bold">Installation du CMS</h1>
            <p class="lead">L'équipe de SamantCMS vous remercie pour l'achat du CMS.
Nous vous rappelons que si vous avez achetez le CMS, c'est que vous acceptez différentes conditions d'utilisations qui sont présentes dans le fichier "Lisez-moi.pdf" diponible a la racine de l'archive qui vous a été fourni.<br>
Si vous avez obtenu le CMS d'une autre méthode que l'achat, nous vous prions de respecter le travail de notre équipe de développement et nous vous demandons de bien vouloir passez a l'achat de celui-ci avant son installation.</p>
            <a class="btn btn-secondary btn-thicker space" type="button" href="../install/basededonnee.php"><i class="fa fa-external-link"></i>Démarrer l'installtion</a></center>
          </div>
          <!-- /Jumbotron -->
</div>

  </div>  <?php require_once("../install/footer.php");?>  

  </div>

  </body>
</html>