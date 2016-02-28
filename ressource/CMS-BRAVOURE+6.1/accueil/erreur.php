<?php
@session_start();
('Content-type: text/html; charset=utf-8');
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');

	$titre = 'Erreur';
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>


    <section class="page-title dark-bg page-bg">
      
        <div class="overlay">
        
          <div class="container">
          
            <div class="error-info clearfix">		
              
              <div class="pull-left">
                <h1>404!</h1>
              </div>
              
              <div class="pull-right">
                <h4>La page recherché n'existe pas.</h4>
                <p>Si il s'agit d'un bug , n'hésitez pas à nous le signaler !</p>
                <a href="../accueil/" class="btn btn-primary pull-left"><i class="fa fa-home"></i>Accueil</a>
              </div>

            </div>

          </div>
          
        </div>
        
    </section>

	<div> 
	<?php require_once ('../jointures/footer.php'); ?> 
	</div>