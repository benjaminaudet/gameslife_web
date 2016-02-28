<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Débiter des points boutique';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
	if(isset($_GET['serveur']))
	{
		$serveur = 	$_GET['serveur'];
		$_SESSION['serveur'] = $serveur;
	}
	else
	{
		$serveur = 'connexion_1';
		$_SESSION['serveur'] = $serveur;
	}
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
				<br><article style="padding:25px;">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget col-sm-4" style="margin-right:25px;">

								<header role="heading">
									<h2><?php echo $titre; ?> à un joueur</h2>
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
			                            <?php
										if(isset($_POST['user_points']) && isset($_POST['user_pseudo'])) 
										{
											            // etape 1		
										$requete = $bdd->prepare('SELECT COUNT(user_id) FROM joueurs WHERE user_pseudo = :user_pseudo');
										$requete->bindParam(':user_pseudo', $_POST['user_pseudo'], PDO::PARAM_STR);
										$requete->execute();
										$nombreDeLignes = $requete->fetch(); 
								
										if ($nombreDeLignes[0] == 0)
										{
										?>
			                                    <div class="alert alert-danger alert-block">
			                                        <a class="close" data-dismiss="alert" href="#">×</a>
			                                        <h4 class="alert-heading">Erreur :</h4>
			                                       Le joueur n'existe pas.</b>
			                                    </div>
										<?php
										}
										else
										{

											$req = $bdd->prepare("SELECT user_points FROM joueurs WHERE user_pseudo = :user_pseudo");
											$req -> execute(array( 'user_pseudo' => $_POST['user_pseudo'] ));
											$user = $req->fetch(PDO::FETCH_OBJ);

											$solde = $user->user_points	+ intval(-$_POST['user_points']);

											$update = $bdd->prepare('UPDATE joueurs SET user_points = :user_points WHERE user_pseudo = :user_pseudo');
											$update -> bindParam(':user_points', $solde);
											$update -> bindParam(':user_pseudo', $_POST['user_pseudo']);
											$update -> execute();
										?>
			                                    <div class="alert alert-success alert-block">
			                                        <a class="close" data-dismiss="alert" href="#">×</a>
			                                        <h4 class="alert-heading">Succès :</h4>
			                                       Les points ont bien été retirés.</b>
			                                    </div>
										<?php
											}
										}
										?>

										<form action="" method="post" class="smart-form">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>
												<div class="row">

													<section>
														<label class="input">
															<input type="text" placeholder="Pseudonyme du joueur" name="user_pseudo">
														</label>
													</section>													

													<section>
														<label class="input">
															<input type="text" placeholder="Nombre de points" name="user_points">
														</label>
													</section>

											</fieldset>


											<footer>
												<input type="submit" class="btn btn-danger" value="Débiter le joueur" name="submit">

												<button type="button" class="btn btn-default" onclick="window.history.back();">
													Retour
												</button>
											</footer>
										</form>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->



							</div>
							
							
							<div class="jarviswidget col-sm-6">

								<header role="heading">
									<h2>Débiter des points à tous les joueurs</h2>
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
				                            <?php
											if(isset($_POST['all'])) 
											{
										
												$solde = intval($_POST['user_points']);
												$solde = (-$solde);
												$update = $bdd->prepare(" UPDATE joueurs SET user_points = user_points + $solde ");
												$update -> execute();
											?>
				                                    <div class="alert alert-success alert-block">
				                                        <a class="close" data-dismiss="alert" href="#">×</a>
				                                        <h4 class="alert-heading">Succès :</h4>
				                                       Les points ont été retirés.</b>
				                                    </div>
											<?php
												
												
											}
											?>
				                            

										<form action="" method="post" class="smart-form">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>
												<div class="row">									

													<section>
														<label class="input">
															<input type="text" placeholder="Nombre de points" name="user_points">
														</label>
													</section>

											</fieldset>


											<footer>
												<input type="submit" class="btn btn-danger" value="Débiter tous joueurs" name="all">

												<button type="button" class="btn btn-default" onclick="window.history.back();">
													Retour
												</button>
											</footer>
										</form>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->



							</div>
							
							
						</article>
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