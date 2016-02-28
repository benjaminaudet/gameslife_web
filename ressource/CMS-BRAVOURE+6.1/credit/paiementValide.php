<?php
session_start();
 header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 	
 	$titre = 'Créditer mon compte';
	require_once ("../jointures/head.php");
  	require_once("../jointures/header.php");
?>
    <section class="content-block default-bg">

        <div class="container">

          <div class="section-title">		
            <h2>Paiement par Paypal</h2>
            <div class="line"></div>
            <p>Informations sur votre paiement par Paypal .</p>
          </div><br><br>
		  
			    <?php if (isset($_SESSION['utilisateur'])){?>
				<div class="jumbotron">
					<h4 class="alert-heading">Félécitation ! .</h4>
					<p>Votre paiement vient d'être validé !</p>	
				</div>
				<?php
			    }
			    else
			    {
		        echo '<div class="bs-callout bs-callout-danger"><h4>Vous devez être connecté .</h4><p>Pour pouvoir accéder à cette page vous devez être connecté .</p><center><a type="button" class="btn btn-success" href="../connexion/"><i class="fa fa-unlock"></i>Connexion</a></center></div>';
		     	}
		    	?>
			    

	    </div>
    </section>

    <div class="footer-copyright"> 
	    <?php require_once("../jointures/footer.php");?>
	</div>