<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Boutique - Promotions';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin']))  { ?>
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

					<div class="jarviswidget col-sm-5">

						<header role="heading">
							<h2>Ajouter une promotion à un item déjà existant</h2>
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
								if(isset($_POST['promo'])) {
									if(isset($_POST['prix']) && !empty($_POST['prix'])) {
										$prix = $_POST['prix'];
										$id = intval($_POST['id']);

										if(is_numeric($prix)) {
											$update = $bdd->prepare('UPDATE boutique SET prix_promotion = :prix  WHERE id = :id');
											$update -> bindParam(':prix', $prix);
											$update -> bindParam(':id', $id);
											$update -> execute();

											if($update->rowCount() == 1){
												$show->showSuccess("Votre promotion a été appliquée !");
											}
										} else {
											$show->showError("Merci de saisir un prix valide");
										}

									} else {
										$show->showError("Merci de préciser le prix");
									}
								}
								?>
								<form action="" class="smart-form" method="post">
									<header>
										Remplissez le formulaire ci-dessous
									</header>

									<fieldset>

										<section>
											<label class="label">Choisissez l'item</label>

											<label class="select">
								                 <select name="id">
													<?php
														$req = $bdd->prepare("SELECT * FROM boutique  WHERE prix_promotion = 0");
														$req->execute();
			                                            
			                                            while($res = $req->fetch(PDO::FETCH_OBJ)){
			                                            	echo '<option value="'.$res->id.'">'.$res->nom.' : '.$res->prix.' pts boutique</option>';
			                                            }
													?>
								                 </select>
							                 <i></i> </label>
										</section>

										<section>
											<label class="label">Saisissez le prix (en promotion) <i>Le pourcentage sera calculé automatiquement !</i></label>
											<label class="input">
												<input type="text" name="prix" id="basicround">
											</label>
										</section>

									</fieldset>


									</fieldset>

									<footer>
										<button type="submit" class="btn btn-success" name="promo">Ajouter la promotion</div>
									</footer>

								</form>
							</div>

							<!-- end widget content -->

						</div>
						<!-- end widget div -->

						<div class="jarviswidget col-sm-5" style="margin-left:25px">
							<header role="heading">
								<h2>Supprimer la promotion d'un item</h2>
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
									if(isset($_POST['delete'])) {
											$id = intval($_POST['id1']);

											if(is_numeric($id)) {
												$update = $bdd->prepare('UPDATE boutique SET prix_promotion = 0  WHERE id = :id');
												$update -> bindParam(':id', $id);
												$update -> execute();

												if($update->rowCount() == 1){
													$show->showSuccess("Votre promotion a été supprimée !");
												}
											} else {
												$show->showError("Merci de choisir un item.");
											}
									}
									?>
									<form action="" class="smart-form" method="post">
										<header>
											Remplissez le formulaire ci-dessous
										</header>

										<fieldset>

											<section>
												<label class="label">Choisissez l'item</label>

												<label class="select">
									                 <select name="id1">
														<?php
															$req = $bdd->prepare("SELECT * FROM boutique WHERE prix_promotion > 0");
															$req->execute();
				                                            
				                                            if($req->rowCount() == 0) {
				                                            	echo '<option disabled>Aucun item en promo</option>';
				                                            } else {
					                                            while($res = $req->fetch(PDO::FETCH_OBJ)){
					                                            	$calcul = (($res->prix_promotion-$res->prix)/$res->prix)*100;
					                                            	$calcul = number_format($calcul, 0);

					                                            	$deduction = $res->prix-$res->prix_promotion;

					                                            	echo '<option value="'.$res->id.'">'.$res->nom.' ('.$res->prix_promotion.' pts boutique), '.$calcul.' % soit une réduction de '.$deduction.' pts boutique</option>';
					                                            }
				                                            }
														?>
									                 </select>
								                 <i></i> </label>
											</section>

										</fieldset>


										</fieldset>

										<footer>
											<button type="submit" class="btn btn-danger" name="delete" <?php if($req->rowCount() == 0) echo "disabled"; ?>>Supprimer la promotion</div>
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
<?php } ?>