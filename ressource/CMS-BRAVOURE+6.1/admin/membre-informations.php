<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Membres inscrit';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
?>
	<body>

		<!-- HEADER -->
		<header id="header">

			<div id="logo-group">

				<span id="logo"> 
					<img src="img/logo.png"> 
				</span>

				<!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
				<?php include 'doc/notifications.php'; ?>
				<!-- END AJAX-DROPDOWN -->
			</div>

			<!-- pulled right: nav area -->
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> 
						<a href="deconnexion.php" title="Se déconnecter">
							<i class="fa fa-sign-out"></i>
						</a> 
					</span>
				</div>
				<!-- end logout button -->

				<!-- input: search field -->
					<?php include 'doc/recherche.php'; ?>
				<!-- end input: search field -->

				<?php include 'inc/translate.php'; ?>

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->

		<!-- Left panel : Navigation area -->
		<aside id="left-panel">
			<?php include 'inc/aside.php'; ?>
		</aside>
		<!-- END NAVIGATION -->

		<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<br>
				<article class="col-sm-12 col-md-12 col-lg-12">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Membre inscrit</h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->
 
									<!-- widget content -->
									<div class="widget-body">
										<?php if(isset($_GET['id'])) : ?>
											<?php $id = intval($_GET['id']); ?>
											<h1>Résultats de la recherche</h1>
												<?php
												$query = $bdd->prepare ("SELECT * FROM joueurs WHERE user_id = :user_id");
												$query->bindParam(':user_id', $id, PDO::PARAM_INT);
												$query->execute();

												if($query->rowCount() == 1) :
													$res = $query->fetch(PDO::FETCH_OBJ);
												?>

												<?php
												if(isset($_GET['bannir'])) :
													
													if($_GET['bannir'] == 'true') :
														$req = $bdd->prepare('UPDATE joueurs SET user_banni = 1 WHERE user_id = :user_id');
				                                        $req -> bindParam(':user_id', $id);
				                                        $req -> execute();

				                                        if($req->rowCount() == 1) :
				                                        	echo '<div class="alert alert-success">Vous avez bannis le membre avec succès</div>';
				                                        endif;
													else :
														$req = $bdd->prepare('UPDATE joueurs SET user_banni = 0 WHERE user_id = :user_id');
				                                        $req -> bindParam(':user_id', $id);
				                                        $req -> execute();

				                                        if($req->rowCount() == 1) :
				                                        	echo '<div class="alert alert-success">Vous avez débannis le membre avec succès</div>';
				                                        endif;
													endif;

												endif;
												?>

												<table class="table table-striped">
													<tr>
														<td>Pseudo</td>
														<td><?php echo $res->user_pseudo; ?></td>
													</tr>
													<tr>
														<td>Mot de passe</td>
														<td>***********</td>
													</tr>
													<tr>
														<td>Email</td>
														<td><?php echo $res->user_mail; ?></td>
													</tr>
													<tr>
														<td>Réponse secrète</td>
														<td><?php echo $res->reponse; ?></td>
													</tr>
													<tr>
														<td>Date d'inscription</td>
														<td><?php echo date("d-m-Y à H:i", $res->user_inscription); ?></td>
													</tr>
													<tr>
														<td>Nombre de points</td>
														<td><?php echo $res->user_points; ?> <img src="../images/gold.png"></td>
													</tr>

													<tr>
														<td>État du joueur</td>
														<td>
															<?php
															if($res->user_banni == 0) :
																echo '<span class="badge alert-success">Non banni</span>';
															else :
																echo '<span class="badge alert-danger">Banni</span>';
															endif;

															?>
														</td>
													</tr>
													<tr>
														<td>Vote(s)</td>
														<td><?php echo $res->vote.' votes'; ?></td>
													</tr>
													<tr>
														<td>Date du vote</td>
														<td>
															<?php
															if($res->date_vote ==! '') :
															  	echo ' '.date("d-m-Y à H:i", $res->date_vote );	
															  else :
															  	echo 'Aucun vote';
															  endif;
															?>
														</td>
													</tr>
												</table>

												<hr>

												<h3>Actions :</h3>

												<a href="rechercher.php?search=<?php echo $res->user_pseudo; ?>" class="btn btn-info">Afficher son historique</a>
													
												<?php if($res->user_banni == 1) : ?>
												<a href="?id=<?php echo $id; ?>&bannir=false" class="btn btn-success">Débannir</a>
												<?php else : ?>
												<a href="?id=<?php echo $id; ?>&bannir=true" class="btn btn-danger">Bannir</a>
												<?php endif; ?>

												<hr>


												<?php
												if(isset($_POST['submit0'])){
													if(isset($_POST['password'])) {
														$user_mdp = md5($_POST['password']);
														
														$req = $bdd->prepare('UPDATE joueurs SET user_mdp = :user_mdp WHERE user_id = :user_id');
						                                $req -> bindParam(':user_mdp', $user_mdp);
						                                $req -> bindParam(':user_id', $id);
						                                $req -> execute();
						                                if($req->rowCount() == 1) {
						                                	$show->showSuccess("Bravo ! Le mot de passe est désormais changé.");
						                                } else {
						                                	$show->showError("Veuillez remplir le formulaire !");
						                                }
													} else {
														$show->showError("Veuillez remplir le formulaire !");
													}
				                                }

												if(isset($_POST['submit1'])){
													if(isset($_POST['email'])) {
														$user_mail = ($_POST['email']);
														
														$req = $bdd->prepare('UPDATE joueurs SET user_mail = :user_mail WHERE user_id = :user_id');
						                                $req -> bindParam(':user_mail', $user_mail);
						                                $req -> bindParam(':user_id', $id);
						                                $req -> execute();
						                                if($req->rowCount() == 1) {
						                                	$show->showSuccess("Bravo ! L'email désormais changé.");
						                                } else {
						                                	$show->showError("Veuillez remplir le formulaire !");
						                                }
													} else {
														$show->showError("Veuillez remplir le formulaire !");
													}
				                                }
												?>
												<div class="col-sm-6">
													
													<h3>Changer le mot de passe</h3>
													<form action="" class="smart-form" method="post">
														<header>
															Remplissez le formulaire ci-dessous
														</header>

														<fieldset>

															<section>
																<label class="label">Nouveau mot de passe</label>
																<label class="input">
																	<input type="password" name="password" id="password">
																</label>
															</section>

														</fieldset>


														

														<footer>
															<button type="submit" class="btn btn-success" name="submit0">Modifier le mot de passe</button></footer>
													</form>
												</div>

												<div class="col-sm-6">
													<h3>Changer l'adresse e-mail</h3>
													<form action="" class="smart-form" method="post">
														<header>
															Remplissez le formulaire ci-dessous
														</header>

														<fieldset>

															<section>
																<label class="label">Nouvelle adresse email</label>
																<label class="input">
																	<input type="email" name="email" id="email">
																</label>
															</section>

														</fieldset>


														

														<footer>
															<button type="submit" class="btn btn-success" name="submit1">Modifier l'adresse</button></footer>
													</form>
												</div>
											<hr>

											<h3>Historique des connexions</h3>
							                  <table class="table table-striped">
							                  <?php
							                    $req = $bdd->prepare ("SELECT * FROM logs WHERE user_id = :user_id ORDER BY log_timestamp DESC LIMIT 25");
						                        $req -> bindParam(':user_id', $id);
							                    $req->execute();
							                    $i = 1;

							                    while($resultats = $req->fetch(PDO::FETCH_OBJ))
							                    {
							                      $pourcentage = ($resultats->p/$sum->TOTAL) * 100;
							                      ?>
							                      <tr>
							                        <td><?php echo $i; ?></td>
							                        <td><?php echo $resultats->log_ip; ?></td>
							                        <td><?php echo date("d/m/Y à H:i",$resultats->log_timestamp); ?></td>
							                      </tr>
							                      <?php
							                      $i++;
							                    }
							                    ?>
							                </table>
											<?php endif; ?>
										<?php endif; ?>
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
						</article>

						<div style="clear:both"></div>
			<!-- END MAIN CONTENT -->

			<?php include 'inc/admin.php'; ?>

		</div>
		<!-- END MAIN PANEL -->

		<!--================================================== -->

		<?php include 'inc/footer.php'; ?>

	</body>

</html>
<?php
}
?>