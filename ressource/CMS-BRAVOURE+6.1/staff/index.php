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

  $titre = 'Staff';
  require_once ("../jointures/head.php");
  require_once ("../jointures/header.php");
?>
    <section class="content-block default-bg">
      
        <div class="container">

          <div class="section-title">		
            <h2>Staff</h2>
            <div class="line"></div>
            <p>l'&eacute;quipe de mod&eacute;ration de <?php echo SITE; ?> .</p>
          </div>
		
        <div class="row">
            <div style="text-align:center;">
              <?php
              $requete = $bdd->prepare ("SELECT * FROM staff ORDER BY id ASC");
              $requete->execute();				
              while($resultats = $requete->fetch(PDO::FETCH_OBJ))
              {
              ?>		  
                <div class="col-xs-6 col-sm-6 col-md-4">
                  <div class="person">
                    <div class="image">
                      <img alt="image" src="https://minotar.net/avatar/<?php echo $resultats->pseudo;?>/460.png">
                    </div>
                    <div class="text">
                      <h4 class="name"><?php echo $resultats->pseudo;?></h4>
                      <span><?php echo $resultats->role;?></span>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
	    </div>
        
        </div>

    </section>
    
    <?php include '../jointures/footer.php'; ?>