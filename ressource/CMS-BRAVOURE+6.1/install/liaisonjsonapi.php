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
            <center><h1 class="bold">Etape 1 : <strong>Connexion au serveur via JSONAPI</strong></h1>
<?php
          if(isset($_POST['etape2']))
          {
            if(empty($_POST['ip_js']) || empty($_POST['login_js']) || empty($_POST['mdp_js']) || empty($_POST['port_js']))
            {
              echo '<div class="alert alert-danger">Vous devez rentrer vos informations JSONAPI.</div>';
            }
            else
            {
                $data = '
                <?php
                        // Ajout du fichier JSONAPI
                        require_once ("JSONAPI.php");
                          
                        ####### CONFIGURATION
                        $var_salt_1 = "'.$_POST['salt_js'].'"; // cryptage
                        $var_ip_1 = "'.$_POST['ip_js'].'";
                        $var_user_1 = "'.$_POST['login_js'].'";
                        $var_mdp_1 = "'.$_POST['mdp_js'].'";
                        $var_port_1 = "'.$_POST['port_js'].'";
                       
                        ####### A NE PAS SUPPRIMER 
                          
                        $connexion_1 = new JSONAPI($var_ip_1, $var_port_1, $var_user_1, $var_mdp_1, $var_salt_1);
                          
                        $server1 = $connexion_1->call("getPlayerCount"); 
                        $server1_limit = $connexion_1->call("getPlayerLimit"); 
                ?>
                ';

                $fp = fopen("../configuration/jsonapi_configuration.php","w+");
                fwrite($fp, $data);
                fclose($fp);

                echo '<div class="alert alert-success">Étape 2 réussie, redirection vers la suivante !</div>';
                header ("Refresh: 3;URL=../install/compteadmin.php");

                echo '<a href="../install/compteadmin.php" class="btn btn-secondary btn-thicker space">Etape suivante</a> <br /><br />';

            }
          } ?>
		  
<form action="" method="post">
                <div class="form-group">
                  <label for="">Hôte (IP) JSONAPI</label>
                  <input type="text" class="form-control" name="ip_js">
                </div>

                <div class="form-group">
                  <label for="">Login JSONAPI</label>
                  <input type="text" class="form-control" name="login_js">              
                </div>

                <div class="form-group">
                  <label for="">Mot de passe JSONAPI</label>
                  <input type="password" class="form-control" name="mdp_js">              
                </div>

                <div class="form-group">
                  <label for="">Salt JSONAPI</label>
                  <input type="text" class="form-control" name="salt_js">              
                </div>

                <div class="form-group">
                  <label for="">PORT JSONAPI</label>
                  <input type="text" class="form-control" name="port_js">              
                </div>

                <input type="submit" name="etape2" class="btn btn-secondary btn-thicker space" value="Valider"></center>
            </form>
			
			<br><br>
			  <div class="news-article box-shadow well">
			  <center><h2><i class="fa fa-refresh fa-spin"></i> Progression de l'installation <strong>25%</strong></h2></center>
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
                <span class="skill"><i class="val">25%</i></span>
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