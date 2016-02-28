<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Ajouter une nouvelle';
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
				<article class="col-sm-12">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Ajouter une nouvelle </h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget content -->
									<div class="widget-body padding">
						                <?php
										if(isset($_POST['submit']))
										{
											if(isset($_POST['texte']) && isset($_POST['titre']))
											{
																		
												$date = time();
													$req = $bdd->prepare('INSERT INTO news(titre, date, texte, auteur) VALUES(:titre, :date, :texte, :auteur)');
													$req -> bindParam(':titre', $_POST['titre']);
													$req -> bindParam(':date', $date);
													$req -> bindParam(':texte', $_POST['texte']);
													$req -> bindParam(':auteur', $_SESSION['admin']['pseudo']);
													$req -> execute();

													$show->showSuccess("Succès, votre article a été ajouté.");
	
												}
											
											else
											{
												$show->showError("Vous devez remplir tous les champs.");
											}
										}
										?>

										<form action="" method="post" class="smart-form" onsubmit="editor.post()">
											<header>
												Remplissez le formulaire ci-dessous pour ajouter une nouvelle
											</header>

											<fieldset>
												<div class="row">

													<section>
														<label class="input">
															<input type="text" placeholder="Titre" name="titre">
														</label>
													</section>													

													<section>
														<label class="input">
															<input type="text" placeholder="<?php echo date('d/m/Y à H:i', time());?>" disabled>
														</label>
													</section>

													<section>
														<label class="input">
															<input type="text" placeholder="Nom de l'auteur" name="auteur">
														</label>
													</section>

													<section>
														<label class="input">
															<textarea id="tinyeditor" style="width: 1200px; height: 200px" name="texte"></textarea>
														</label>
													</section>
											</fieldset>


											<footer>
												<input type="submit" class="btn btn-primary" value="Ajouter la nouvelle" name="submit">

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