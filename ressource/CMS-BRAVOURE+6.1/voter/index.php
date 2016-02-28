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

	$titre = 'Voter';
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
  <body>
      
      <!-- Page Info
      ================================================== -->
      <section class="page-info-block">
      
          <!-- Container -->
          <div class="container">
          
            <!-- Title -->
            <div class="section-title">		
              <h2>Voter</h2>
              <div class="line"></div>
              <p>Votez et tentez de gagner pleins de cadeaux !</p>
            </div>
            <!-- Title /END -->

          </div>
          <!-- /Container -->
        
      </section>
      <!-- /Page Info Block
      ================================================== -->
      
      <!-- Content Block
      ================================================== -->
      <section class="content-block page-bg">
      
        <!-- Overlay -->
        <div class="overlay tint">
        
          <!-- Container -->
          <div class="container">

            <!-- Row -->
            <div class="row">
            
            <center><br><br><br><br><br>
							<form action="../voter/traitement-vote.php" method="post">                  

		                            <div class="col-sm-8" style=" margin-left: 0px; ">               
										<?php
											if (isset($_SESSION['utilisateur']))
											{
												echo '<input class="form-control" type="text" placeholder="Votre pseudo" id="inputString" name="inputString" value="'.$_SESSION['utilisateur']['user_pseudo'].'" autocomplete="on"/>';
											}
											else
											{
												echo '<input class="form-control" type="text" placeholder="Votre pseudo" id="inputString" name="inputString" autocomplete="on"/>';
											}
										?>
		                            </div>

		                            <div class="col-sm-4"><button class="btn btn-primary btn-thicker space" type="submit"/>Continuer</button></div>
							</form>
			</center>
                
            </div>
            <!-- /Row-->

          </div>
          <!-- /Container -->
        </div>
        <!-- /Overlay -->
        
      </section>
      <!-- /Content Block
      ================================================== -->
      
      <!-- Content Block
      ================================================== -->
      <section class="content-block default-bg">
      
        <!-- Container -->
        <div class="container">
            
          <!-- Diamond Divider -->				
          <div class="hr-diamond width-50pc">
            <span class="line"></span>
            <span class="diamond"></span>
          </div>
          <!-- /Diamond Divider -->	
					
          <!-- Title -->
          <div class="section-title">		
            <h2>Classement</h2>
            <div class="line color-1-bg"></div>
            <p>Les meilleur voteurs sont récompensés à la fin du mois.</p>
          </div>
          <!-- Title /END -->
              <!-- Table -->
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Pseudo</th>
                  <th>Votes</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $requete = $bdd->prepare ("SELECT * FROM joueurs ORDER BY vote DESC limit 50");
                    $requete->execute();
                      $i = 1;
                           
                      while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                    {
                ?>
                <tr>
                  <td><div id="<?php echo $i; ?>"> <?php echo $i; ?></div></td>
                  <td>
					<img src="http://cravatar.eu/avatar/<?php echo $resultats->user_pseudo; ?>/24.png" style="margin-right:25px; border-radius:5px;  box-shadow: 4px 4px 8px #555; max-width:24px ">
                    <a href="../membres/membres.php?membre=<?php echo $resultats->user_pseudo; ?>" class="bouton"><?php echo $resultats->user_pseudo; ?></a>
				  </td>
                  <td><?php echo $resultats->vote; ?></td>
                </tr>
				<?php
                    $i++;
                    }
                ?>
                </tbody>
              </table>
			  
          <!-- Diamond Divider -->				
          <div class="hr-diamond width-50pc">
            <span class="line"></span>
            <span class="diamond"></span>
          </div>
          <!-- /Diamond Divider -->	
		  
          <!-- Title -->
          <div class="section-title">		
            <h2>Récompenses</h2>
            <div class="line color-1-bg"></div>
            <p>Les récompenses aléatoires</p>
          </div>
          <!-- Title /END -->

            <p><table width="100%" class="table table-hover">
			<?php

			$calcul = $bdd->prepare ("SELECT SUM(p) AS TOTAL FROM probabilites");
			$calcul->execute();
			$sum = $calcul->fetch(PDO::FETCH_OBJ);

				$req = $bdd->prepare ("SELECT * FROM probabilites");
				$req->execute();
				$i = 1;

				while($resultats = $req->fetch(PDO::FETCH_OBJ))
				{
					$pourcentage = ($resultats->p/$sum->TOTAL) * 100;
					?>
				    <tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $resultats->quantite; ?> <?php echo $resultats->nom; ?></td>
						<td><?php echo round($pourcentage, 0); ?>%</td>
					</tr>
            <?php
                $i++;
		        }
		    ?>
		    </table></p>			  
        
        </div>
        <!-- /Container -->

      </section>
      <!-- /Content Block
      ================================================== -->

  <!--Bottom Section-->
  <?php include '../jointures/footer.php'; ?>