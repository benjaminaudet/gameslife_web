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
            <center><h1 class="bold">Etape 3 : <strong>Création du compte admin</strong></h1>
<?php
          if(isset($_POST['etape3']))
          {
            if(empty($_POST['pseudo_admin']) || empty($_POST['mail_admin']) || empty($_POST['mdp_admin']) || empty($_POST['mdp1_admin']))
            {
              echo '<div class="alert alert-danger">Vous devez rentrer les informations.</div>';
            }
            else
            {

              $admin_pseudo=$_POST['pseudo_admin'];
              $admin_mail=$_POST['mail_admin'];
              $admin_mdp=md5($_POST['mdp_admin']);
              $admin_mdp1=md5($_POST['mdp1_admin']);

              if($admin_mdp == $admin_mdp1){
                $admin = $bdd->exec('
                INSERT INTO `admin` VALUES ("1", "'.$admin_pseudo.'", "'.$admin_mail.'", "'.$admin_mdp.'", "0", null, "18:12:27", "'.$_SERVER["REMOTE_ADDR"].'");
                ');
                if(count($admin) == 1){
                  echo '<div class="alert alert-success">Création du compte réussi, passage a la prochaine Etape</div>';
                  header ("Refresh: 3;URL=../install/configuration.php");
                  echo '<a href="../install/configuration.php" class="btn btn-secondary btn-thicker space">Etape suivante</a><br /><br />';
                }
              } else {
                echo '<div class="alert alert-danger">Les mots de passes ne correspondent pas.</div>';
              }
            }
          }              
          ?>
			
            <form action="" method="post">
                <div class="form-group">
                  <label for="">Nom de compte</label>
                  <input type="text" class="form-control" name="pseudo_admin">
                </div>

                <div class="form-group">
                  <label for="">Adresse Email</label>
                  <input type="text" class="form-control" name="mail_admin">              
                </div>

                <div class="form-group">
                  <label for="">Mot de passe</label>
                  <input type="password" class="form-control" name="mdp_admin">              
                </div>

                <div class="form-group">
                  <label for="">Confirmation mot de passe</label>
                  <input type="password" class="form-control" name="mdp1_admin">              
                </div>

                <input type="submit" name="etape3" class="btn btn-secondary btn-thicker space" value="Valider"></center>
            </form>
			
			<br><br>
			  <div class="news-article box-shadow well">
			  <center><h2><i class="fa fa-refresh fa-spin"></i> Progression de l'installation <strong>40%</strong></h2></center>
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                <span class="skill"><i class="val">40%</i></span>
				</div>
              </div>
			  </div>
			
          </div>
          <!-- /Jumbotron -->
</div>

  </div>  <?php require_once("../install/footer.php");?>  

  </div>

  </body>
</html>