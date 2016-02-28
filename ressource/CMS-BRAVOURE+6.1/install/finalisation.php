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
            <center><h1 class="bold">Félicitation ! <strong>Vous venez de terminer l'installation</strong></h1>
<?php
        // La fonction en question.
        function suppression($dossier_traite , $extension_choisie)
        {
        // On ouvre le dossier.
        $repertoire = opendir($dossier_traite);
         
        // On lance notre boucle qui lira les fichiers un par un.
                while(false !== ($fichier = readdir($repertoire)))
                {
                // On met le chemin du fichier dans une variable simple.
                $chemin = $dossier_traite."/".$fichier;
                        
        // On n'oublie pas LA condition sous peine d'avoir quelques surprises. :P
                        if($fichier!="." AND $fichier!=".." AND !is_dir($fichier))
                        {
                        unlink($chemin);
                        }
                }
        closedir($repertoire); // On ferme !
        rmdir($dossier_traite);
        }        

        // Notre fonction paramétrée.
        if(isset($_POST['fin']))
        {
          header ("Refresh: 1;URL=../index.php");
          echo '<div class="alert alert-success alert-block">Fin de l\'installation, retour a la page d\'accueil.</div>';
          suppression("../install" , "php");
        }
        
         

        ?>
            <div class="alert alert-info">Assurez vous de remettre le CHMOD du fichier configuration/baseDonnees.php a l'origine</div>

            <div class="row-fluid">
            <p class="lead">L'équipe de SamantCMS vous remercie d'avoir acheter et installer SamantCMS.<br/>
            Vous pouvez mainenant commencé a utiliser le CMS dans sa totalité. <br>
            Si vous rencontrez des problèmes, merci de relire le fichier "Lisez-moi.pdf" ou de poster un message sur le forum de SamantCMS
            si cela n'a pas suffit.<br>
            Attention lors du clique sur "Finaliser", le dossier 'install' devrait être supprimer cependant veuillez le supprimer si cela 
            ne sait pas fait automatiquement <br>
            <br></p>
            <form action="" method="post">
            <input type="submit" class="btn btn-secondary btn-thicker space" name="fin" value="Finaliser">
            </form>
            </div>

			<br><br>
			  <div class="news-article box-shadow well">
			  <center><h2><i class="fa fa-refresh fa-spin"></i> Terminé ! <strong>100%</strong></h2></center>
              <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="skill"><i class="val">100%</i></span>
				</div>
              </div>
			  </div>
			
        </div>

    </div><?php require_once("../install/footer.php");?>  

  </div>

  </body>
</html>