<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Forum';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {

  	if(isset($_GET['id']) && !empty($_GET['id']))
  	{
  		$id = intval($_GET['id']);

		$req = $bdd->prepare("
			SELECT 
				*
			FROM 
				sous_categories
			WHERE id = :id
		");
		$req -> execute(array( 'id' => $id));
		$sous_categorie = $req->fetch(PDO::FETCH_OBJ);
  	}
  	else
  	{
  		exit();
  	}
?>
	<body>

		<!-- HEADER -->
		<header id="header">

			<div id="logo-group">

				<!-- input: logo file -->
				<?php include 'inc/logo.php'; ?>
				<!-- end input: logo file --> 

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

				<br><?php include 'doc/situation.php'; ?>


				<article class="col-sm-6">	
					
						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Modifier une sous-catégorie</h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									<div class="widget-body no-padding">
										<?php
											if(isset($_POST['submit1']))
											{
												$id_categorie = htmlspecialchars($_POST['categorie']);
												$nom = htmlspecialchars($_POST['title']);
												$background = htmlspecialchars($_POST['image']);
												$description = htmlspecialchars($_POST['texte']);

												// UPDATE
												$update = $bdd->prepare('UPDATE sous_categories SET id_categorie = :id_categorie, nom = :nom, description = :description, background = :background WHERE id = :id');
												$update -> bindParam(':id_categorie', $id_categorie);
												$update -> bindParam(':nom', $nom);
												$update -> bindParam(':description', $description);
												$update -> bindParam(':background', $background);
												$update -> bindParam(':id', $id);
												$update -> execute();
												if($update->rowCount() == 1)
												{
													$show->showSuccess('La sous catégorie est modifiée. Rafraichissez votre page !');
												}			
											}	
										?>
										<form action="" class="smart-form" method="post"  onsubmit="editor.post()">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>

												<section>
													<label class="input">
														<input type="text" name="title" value="<?php echo $sous_categorie->nom; ?>">
													</label>
												</section>

												<section>
													<label class="select">
								                      <select name="categorie">
													<?php
														$requete = $bdd->prepare("SELECT * FROM categories ORDER BY overid DESC");
														$requete->execute();
		                                            
		                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
		                                                {
		                                                	if($sous_categorie->id_categorie == $resultats->id)
		                                                	{
		                                                		echo '<option value="'.$resultats->id.'" selected>'.$resultats->titre.'</option>';
		                                                	}
		                                                	else
		                                                	{
		                                                		echo '<option value="'.$resultats->id.'">'.$resultats->titre.'</option>';
		                                                	}
		                                                }
		                                             ?>
								                      </select>
							                       <i></i> </label>
												</section>

												<div style="clear:both"></div><br>
													
												<section>
													<label class="input">
														<input type="text" value="<?php echo $sous_categorie->background; ?>" name="image">
													</label>
												</section>

												<section>
													<label class="input">
														<input type="text"  value="<?php echo $sous_categorie->description; ?>" name="texte">
													</label>
												</section>
											</fieldset>

											<footer>
												<input type="submit" class="btn btn-primary" value="Modifier" name="submit1">

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

						<div style="clear:both"></div><br>

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