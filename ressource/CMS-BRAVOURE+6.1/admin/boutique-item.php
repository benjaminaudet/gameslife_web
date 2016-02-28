<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  require_once '../configuration/configuration.php';
  set_session($bdd);
  $titre = 'Boutique';
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
				<br><article>

					<?php include 'doc/situation.php'; ?>


						<div class="alert alert-success">
							Commande : <br>
							Pour une commande : give pseudo_var 1 1; <br>
							Pour deux commandes : give pseudo_var 1 1;give pseudo_var 1 1; <br>
							ATTENTION VEUILLEZ METTRE A LA FIN DE CHAQUE COMMANDE ; 
						</div>

						<div class="jarviswidget" style="padding:25px;">

								<header role="heading">
									<h2>Ajouter un item</h2>
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


										<div id="status"></div>
										<?php

											if(isset($_POST['submit']))
											{
												$necessaire = '';
												$type = $_POST['type'];
												
												if($type=='item'){
													$type='';	
												}

												$req = $bdd->prepare('INSERT INTO boutique(nom, ordre_id, description, categorie, commande, serveur, prix, image, grade_necessaire) VALUES(:nom, :ordre_id, :description, :categorie, :commande, :serveur, :prix, :image, :grade_necessaire)');
												$req -> bindParam(':nom', $_POST['nom']);
												$req -> bindParam(':ordre_id', $type);
												$req -> bindParam(':description', $_POST['description']);
												$req -> bindParam(':categorie', $_POST['categorie']);
												$req -> bindParam(':commande', $_POST['commande']);
												$req -> bindParam(':serveur', $_POST['serveur']);
												$req -> bindParam(':prix', $_POST['prix']);
												$req -> bindParam(':image', $_POST['image']);
												$req -> bindParam(':grade_necessaire', $necessaire);
												$req -> execute();
												
												echo '<div class="alert alert-success">Succès : Vous avez ajouté l\'item.</div>';
											}

										?>
										<form action="" class="smart-form" method="post" onSubmit="editor.post()">
											<header>
												Remplissez le formulaire ci-dessous
											</header>
											<fieldset>

												<section class="col col-3">
													<label class="label">Nom</label>
													<label class="input">
														<input type="text" class="span12" value="" id="nom" name="nom">
													</label>
												</section>
													
												<section class="col col-3">
													<label class="label">Image</label>
													<label class="input">
														<input type="text" class="span12" value="" id="image" name="image">
													</label>
												</section>
																										
												<section class="col col-2">

													<label class="label">Type</label>

													<label class="select">
								                        <select name="type">
															
															<option value="item">Item</option>
                                                            <option value="skin">Skin</option>
                                                            <option value="cape">Cape</option>

								                        </select>
							                        <i></i> </label>
												</section>		
                                                																								
												<section class="col col-2">

													<label class="label">Serveur (connexion)</label>

													<label class="select">
								                        <select name="serveur">
															
															<?php
															  for($i = 1; $i <= 10; $i++) 
															  {
															     echo '<option value="connexion_'.$i.'">'.$i.'</option>';
															  }
															?>

								                        </select>
							                        <i></i> </label>
												</section>

												<section class="col col-3">
													<label class="label">Prix</label>
													<label class="input">
														<input type="text" class="span12" value=""  id="prix" name="prix">
													</label>
												</section>

												<section class="col col-4">
													<label class="label">Catégorie</label>
													<label class="input">
														<input type="text" class="span12" value=""  id="categorie" name="categorie">
													</label>
												</section>

												<section class="col col-sm-8">
													<label class="label">Commande</label>
													<label class="input">
														<input type="text" class="span12" value=""  id="commande" name="commande">
													</label>
												</section>

												<section class="col col-sm-12">
													<label class="label">Description</label>
													<label class="input">
														<textarea id="tinyeditor" style="width: 1200px; height: 200px" name="description"></textarea>
													</label>
												</section>

											</fieldset>


											</fieldset>

											<footer>
												<input type="submit" class="btn btn-primary" name="submit" value="Ajouter">

												<button type="button" class="btn btn-default" onClick="window.history.back();">
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