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
  require_once('../configuration/baseDonnees.php');

 $titre = 'Installation de SamantCMS';
require_once ("../jointures/head.php");
?>

<body>
<div class="container">

        <center><img src="../install/samant.png"></center>

          <!-- Jumbotron -->
          <div class="jumbotron">
            <center><h1 class="bold">Etape 7 : <strong>Configuration de la page de réglément ( non obligatoire )</strong></h1>
 <?php
          if(isset($_POST['etape7']))
          {
            if(isset($_POST['texte']))
            {
                $id = 5;
                $date = time();
                $update = $bdd->prepare('UPDATE pages SET page = :page WHERE id = 2');
                $update -> bindParam(':page', $_POST['texte']);
                $update -> bindParam(':id', $id);
                $update -> execute();

              echo '<div class="alert alert-success alert-block">Page modifiée avec succès</div>';
                header ("Refresh: 3;URL=../install/finalisation.php");

              }
            else
            {
              echo '<div class="alert alert-error alert-block">Veuillez entrer un texte.</div>';
            }
          }
          
          if(isset($_POST['passer']))
          {
            echo '<div class="alert alert-success alert-block">Vous avez décidé de passer cette étape</div>';
            header ("Refresh: 3;URL=../install/finalisation.php");
            echo '<a href="../install/finalisation.php" class="btn btn-secondary btn-thicker space">Etape suivante</a><br><br>';
          }

          $req = $bdd->prepare("SELECT * FROM pages WHERE id = :id");
          $req -> execute(array( 'id' => 5));
          $page = $req->fetch(PDO::FETCH_OBJ);

          ?>  
            <form action="" method="post">
              <div class="form-group">
                <label for="">Détaillez la page <?php  $titre = stripcslashes($page->titre); echo $titre; ?>.</label>
                <textarea class="form-control" name="texte"><?php $texte = stripcslashes($page->page); echo $texte;?></textarea>     
              </div>                      
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="submit" name="etape7" class="btn btn-secondary btn-thicker space" value="Modifier">
                &nbsp;&nbsp;
                  <input type="submit" name="passer" class='btn btn-default btn-thicker space' value="Sauter l'étape">
                </div>
              </div>
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