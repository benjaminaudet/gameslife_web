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

	$titre = 'Règlement';
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section class="content-block default-bg">

	    <div class="container">
				
          <div class="section-title">		
            <h2>Reglement</h2>
            <div class="line"></div>
            <p>Le règlement de notre serveur .</p>
          </div>
				
		    <div class="row-fluid">

				<?php
				echo '<div>';

					$requete = $bdd->prepare ("SELECT * FROM pages WHERE titre = 'Reglement'");
					$requete->execute();
													
					$resultats = $requete->fetch(PDO::FETCH_OBJ);
						                        
															
					echo stripcslashes(nl2br(smiley($resultats->page)));					
					$requete->closeCursor();

				echo '</div>';
				?>
	        </div>      
        </div>

    </section>

    <div class="footer-copyright"> 
	    <?php include '../jointures/footer.php'; ?> 
	</div>