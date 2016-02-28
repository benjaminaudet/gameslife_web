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
?>
    <?php require_once("../jointures/header.php"); ?>
    <section class="content-block default-bg">

        <div class="container">

          <div class="section-title">		
            <h2>Créditer mon compte</h2>
            <div class="line"></div>
            <p>Validez 1 code pour recevoir vos Points .</p>
          </div><br><br>
		  
              <?php
				if (isset($_SESSION['utilisateur']))
				{
					if(isset($_GET['offre'])  && !empty($_GET['offre']))
					{
					$id = intval($_GET['offre']);
							if($id == $idd_1)
							{
								$nombre_points_insert = $nombre_points_1;
								$offre_nom = '<h2>Offre 1 -<strong> '.$nombre_points_1.' points</strong></h2>';
								$error = false;
							}
							elseif($id == $idd_2 )
							{
								$nombre_points_insert = $nombre_points_2;
								$offre_nom = '<h2>Offre 2 -<strong> '.$nombre_points_2.' points</strong></h2>';
								$error = false;
							}
							elseif($id == $idd_3)
							{
								$nombre_points_insert = $nombre_points_3;
								$offre_nom = '<h2>Offre 3 -<strong> '.$nombre_points_3.' points</strong></h2>';
								$error = false;
					
							}
							else
							{
								$error = true;
								$offre_nom = '';
							}
					

				?>
					
               				<div class="box-shadow well">
                                  <h4><?php echo $offre_nom;?></h4>
									<?php
									if($error == false) 
									{
                                    if ($id == $idd_1) 
                                    {
                                        $_SESSION['type_achat'] = $idd_1;
                                    ?>
                                        <div id="starpass_<?php echo $idd_1;?>"></div>
                                                <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd_1;?>&amp;verif_en_php=1&amp;datas=<?php echo $idd_1;?>"></script>
                                                
                                                <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                                                <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                                                </noscript>
                                            
                                    <?php
                                    }
                                    if ($id == $idd_2) 
                                    {
                                    $_SESSION['type_achat'] = $idd_2;
                                    ?>
                                        <div id="starpass_<?php echo $idd_2;?>"></div>
                                                <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd_2;?>&amp;verif_en_php=1&amp;datas=<?php echo $idd_2;?>"></script>
                                                
                                                <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                                                <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                                                </noscript>
                                            
                                    <?php
                                    }
                                    if ($id == $idd_3) 
                                    {
                                        $_SESSION['type_achat'] = $idd_3;
                                    ?>
                                        <div id="starpass_<?php echo $idd_3;?>"></div>
                                                <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd_3;?>&amp;verif_en_php=1&amp;datas=<?php echo $idd_3;?>"></script>
                                                
                                                <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
                                                <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
                                                </noscript>
                                            
                                    <?php
									}
									
									}
										else
										{
											echo '<div class="alert alert-danger">Offre inconnue</div>';
										}

										}
										else
										{
											echo '<div class="alert alert-danger">Offre inconnue</div>';
										}
										
                                    ?>
             
               
					
			                </div>	
			<?php
			}
			 else
			 {
				$show->showError('<h4 class="alert-heading">Erreur : Problème avec la connexion.</h4><Font color="black"> Vous devez être connecté pour pouvoir accéder à cette page. Merci de vous connecter. </font><br><a href="../inscription/" class="btn btn-danger">Inscription</a> &nbsp;&nbsp;<a href="../connexion/" class="btn">Se connecter</a> ');
			 }
		
			?>
        </div>

    </section>
	
	<div class="footer-copyright">
		<?php require_once ("../jointures/footer.php"); ?>
    </div>		
