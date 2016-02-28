<?php
@session_start();
@header('Content-type: text/html; charset=utf-8');
	
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
  
  $titre = 'Voir le produit';
  require_once ("../jointures/head.php");
  require_once("../jointures/header.php");
	
	echo '<body>';

	if(isset($_SESSION['utilisateur'])) { 
		
		$_SESSION['buy'] = true;
		 

		if(isset($_GET['id']) && !empty($_GET['serveur']))
		{
			$id = intval($_GET['id']); 
			$serveur_get = htmlspecialchars($_GET['serveur']);

			$explode_serveur = explode("_", $serveur_get);
			$serveur_get = $explode_serveur[1];

				$i = array(1,2,3,4,5,6,7,8,9,10);
				if (in_array($serveur_get, $i)) 
				{
					for ($i = 1; $i <= 10; $i++) 
					{
						if($serveur_get == $i)
						{
							$serveur = 'connexion_'.$i.'';
						}
					}
				}
				else
				{
					$serveur = 'connexion_1';	
				}
				if(JSONAPI == 1) {
					if($serveur == 'connexion_1')
					{
						$connexion_serveur = $connexion_1;
					}
					elseif ($serveur == 'connexion_2') {
						$connexion_serveur = $connexion_2;
					}
					elseif ($serveur == 'connexion_3') {
						$connexion_serveur = $connexion_3;
					}
					elseif ($serveur == 'connexion_4') {
						$connexion_serveur = $connexion_4;
					}
					elseif ($serveur == 'connexion_5') {
						$connexion_serveur = $connexion_5;
					}
					elseif ($serveur == 'connexion_6') {
						$connexion_serveur = $connexion_6;
					}
					elseif ($serveur == 'connexion_7') {
						$connexion_serveur = $connexion_7;
					}
					elseif ($serveur == 'connexion_8') {
						$connexion_serveur = $connexion_8;
					}
					elseif ($serveur == 'connexion_9') {
						$connexion_serveur = $connexion_9;
					}
					elseif ($serveur == 'connexion_10') {
						$connexion_serveur = $connexion_10;
					}
					
					$pseudo = $_SESSION['utilisateur']['user_pseudo'];
					$groupe = $connexion_serveur->call("permissions.getGroups", array("$pseudo"));
					$groupe = $groupe["success"]["0"];
				} 

				$req = $bdd->prepare('SELECT COUNT(id) FROM boutique WHERE id = :id');
				$req->bindParam(':id', $id, PDO::PARAM_INT, 11);
				$req->execute();
				
				$verifie = $req->fetch(); 
				
				if($verifie[0] > 0) 
				{
					$query = $bdd->prepare ("SELECT * FROM boutique WHERE id = :id");
					$query->bindParam(':id', $id, PDO::PARAM_STR);
					$query->execute();
				
					$res = $query->fetch(PDO::FETCH_OBJ); 
			
						if ($res->id == $id)
						{
							
							$deduction = false;
							$payer = $res->prix;


							?>
							  <section class="page-info-block">
							  
								  <div class="container">
								  
									<div class="section-title">		
									  <h2>DÉTAILS DE LA COMMANDE</h2>
									  <div class="line"></div>
									  <p>Détails sur votre commande.</p>
									</div>

								  </div>
									
							  </section>
								  

							<section class="content-block default-bg">
								  
								<div class="container">
									
									  <div id="product-details" class="row">
									  
										<div class="col-sm-6 col-md-6 space-b-xs">

										  <div class="clearfix">
											
											<div class="main-image">
											  <center><a href="#"><img src="<?php echo ($res->image); ?>" alt="" style="width: inherit;height: inherit;max-height: 155px;"/></a></center>
											</div>
											
										  </div>

										</div>
										
										<div class="col-sm-6 col-md-6">
										
										  <div class="product-info">
										  
											<h5 class="title widget-title">Article : <?php echo stripcslashes($res->nom); ?></h5>
											
											<div class="price-box clearfix">
											  <h5 class="price">
											  	<?php
						                        if($res->prix_promotion == 0){
						                          $prix1 = $res->prix;
						                          $prix = $res->prix;
						                        } else {
						                          $prix1 = '<div style="display:inline;text-decoration: line-through;;">'.$res->prix.'</div>';
						                          $prix1 .= '<div style="display:inline;"> '.$res->prix_promotion.'</div>';

						                          $prix = $res->prix_promotion;
						                        }

						                        $payer = $prix;
						                        echo $prix1;
												?> points boutique</h5>
											  <span>Vous avez <?php echo $_SESSION['utilisateur']['user_points']; ?> point(s) boutique</span>
											</div>

											<div class="attributes-box">
												<?php 
												if(isset($_SESSION['utilisateur'])) {
													if($_SESSION['utilisateur']['user_points'] - $payer) {
														echo '<div class="alert alert-danger">Il vous manque : '.$_SESSION['utilisateur']['user_points'] - $payer.'</strong><span>points boutique</div><br/> ';
													} else {
														echo '<strong>Solde après achat : '.$_SESSION['utilisateur']['user_points'] - $payer.'</strong><span></span><br/>';
													}
												}
												?>
											</div>
											
											<h5 class="widget-title">Valider votre commande</h5>	

											<div class="buy-box">
											<?php
												if ($_SESSION['utilisateur']['user_points'] - $payer >= 0)
												{

													if(($res->grade_necessaire ==! '' AND $res->grade_necessaire == $groupe) OR $res->grade_necessaire=='')
													{
														echo '<input style="display:none" type="text" value="'.$res->id.'" name="id" id="id">';
														echo '<input style="display:none" type="text" value="'.$serveur.'" name="serveur" id="serveur">';
														echo '<a href="#" class="btn btn-primary" onClick="javascript:achat_ajax();"><i class="fa fa-download"></i> Acheter</a>';
													}
													else
													{
														$show->showError("Vous devez disposer le grade ".$res->grade_necessaire." pour pouvoir effectuer cet achat.");
													}
												
												}
												else
												{
													$show->showError('Impossible d\'effectuer cet achat, il vous manque '.($payer - $_SESSION['utilisateur']['user_points']).' points.');
												}
										
												echo '<br /><br /><div id="message_id"></div>'; ?>
										
											</div>

										  </div>
										  
										</div>	

									  </div>

									<div class="row">
									  
										<div class="col-sm-8 col-md-8 space-b-xs">
										
										  <ul class="nav nav-tabs  product-nav-tabs">
											<li>
											<a data-toggle="tab" href="#desc">Description</a>
											</li>
										  </ul>
										  
										  <div class="tab-content">
										  
											<div class="tab-pane" id="desc">
											  <p><?php echo ($res->description); ?></p>
											</div>
											
										  </div>
										  
										</div>
										
									</div>
										

								</div>
								<br><br><br><br><br>

							</section>

						 <?php		
						 echo '</div>';		
						 echo '</div>';	
						 echo '</div>';	
						}
					}	
				}
						
			
		} else { 
			echo '<div class="container">';
				echo '<div class="row"><br><br>';
					$show->showError("Vous devez vous connecter pour accèder à cette page."); 
				echo "</div>";
			echo "</div>";
		} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../jointures/footer.php'; ?>