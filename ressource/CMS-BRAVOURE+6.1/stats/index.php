<?php
@session_start();
 header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');

	$titre = 'Statistiques';
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section class="page-info-block">
      
        <div class="container">
          
            <div class="section-title">		
              <h2>Stats</h2>
              <div class="line"></div>
              <p>Statistique de <?php echo SITE; ?> .</p>
            </div>

        </div>
        
    </section>
      
    <section class="content-block page-bg">
      
        <div class="overlay tint">
        
        <div class="container">

            <div class="row">
            
              <div class="progress skill-bar">
                <div <?php if($server1_limit == 0) { ?>class="progress-bar progress-bar-darger"<?php } else { ?>class="progress-bar progress-bar-success"<?php } ?> role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                  <span class="skill"><i class="fa fa-globe"></i><?php echo $server1["success"]; ?> Connectés <i class="val">Serveur <?php if($server1_limit == 0) { ?>OFF<?php } else { ?>ON<?php } ?></i></span>
                </div>
              </div>
			  
			  <center><a class="btn btn-primary btn-thicker space" href="../nous-rejoindre/">Nous rejoindre</a></center>
                
            </div>

        </div>

       </div>
        
    </section>

    <section class="content-block default-bg">
      
        <div class="container">
            			
          <div class="hr-diamond width-50pc">
            <span class="line"></span>
            <span class="diamond"></span>
          </div>
        
          <div class="row">
		  
            <div class="section-title">		
              <h2>Joueurs en ligne</h2>
              <div class="line"></div>
            </div>
          
                  <?php if ($server1["success"] > 0 ) : ?>
	                  <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Skins</th>
                          <th>Pseudo</th>
                          <th>Grade IG</th>
                          <th>Monnaie IG</th>
                        </tr>
                      </thead>
                  	<?php 
                    foreach ($server1_membre["success"]  as $value) :
                      $groupe = $connexion_1->call("permissions.getGroups", array("$value"));
                      $groupe = $groupe["success"]["0"];
                      $nbr_money_server = $connexion_1->call("econ.getBalance", array("$value"));
                      $money = number_format($nbr_money_server["success"], 0, '.', ' '); 
                    ?>
                    <tbody>
                      <tr>
                        <td><center> <a href="../membre/<?php echo $value ; ?>"><img src="https://cravatar.eu/helmhead/<?php echo $value ; ?>/45.png" title="<?php echo $value; ?>" rel="tooltip" data-toggle="tooltip" data-placement="top"></A></center></td>
                        <td><a href="../membre/<?php echo $value ; ?>"><?php echo $value ;?></a></td>
                        <td><?php echo $groupe ;?></td>
                        <td><?php echo $money ;?></td>
                      </tr>
                    </tbody>		
                    <?php endforeach; ?>
                  </table>
                  <?php else : ?>
	                    <div class="alert alert-danger"> Il n'y a aucun connecté</div>
                  <?php endif; ?>
            
          </div>
        
        </div>

    </section>

    <?php include '../jointures/footer.php'; ?>