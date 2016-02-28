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

				<br><?php include 'doc/situation.php'; ?>
				<article class="col-sm-6">
					
						<div class="jarviswidget">

								<header role="heading">
									<h2>Gérer les catégories</h2>
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
											if(isset($_GET['id_del']))
											{
												$id_del = intval($_GET['id_del']);
												// SPR
												$delete = $bdd->prepare('DELETE FROM categories WHERE id = :id_del');
												$delete -> bindParam(':id_del', $id_del);
												$delete -> execute();
												$show->showSuccess("Catégorie supprimé avec succès.");
											}			
											
											if(isset($_GET['editer']))
											{
												$maxID = $bdd->prepare("SELECT overid FROM categories ORDER BY overid DESC limit 1");
												$maxID->execute();
												$BoucleMax = $maxID->fetch();

												$overid = $BoucleMax['overid'] +1;


												$id = intval($_GET['editer']);

												// UPDATE
													$update = $bdd->prepare('UPDATE categories SET overid = :overid WHERE id = :id');
													$update -> bindParam(':overid', $overid);
													$update -> bindParam(':id', $id);
													$update -> execute();
															
													$show->showSuccess('Il est désormais en tête de liste');
											}			
															
										?>
										<table class="table table-striped">
											<thead>
		                                              <tr>
		                                                    <th>Position</th>
		                                                    <th>Titre</th>
		                                                    <th>Action</th>
		                                              </tr>
												</thead>
											<tbody>
													<?php
													$i=1;
														$requete = $bdd->prepare("SELECT * FROM categories ORDER BY overid DESC");
														$requete->execute();
		                                            
		                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
		                                                {
		                                                            echo '<tr>';

																	  echo '<td>n° '.$i.'</td>';

																	  echo '<td>'.$resultats->titre.'</td>';
																	  
																	  echo '<td>';
																		echo '<div class="btn-group"><center>';
																		echo '<a href="?id_del='.$resultats->id.'" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Supprimer</a> ';
																		echo '<a href="?editer='.$resultats->id.'" class="btn btn-labeled btn-success"><span class="btn-label"><i class="fa fa-bolt"></i></span>Monter en tête</a>';

																		echo '</center></div>';
																	  echo '</td>';

		                                                        echo '</tr>';
		                                                        $i++;
		                                                }
		                                             ?>
													</tbody>
												</table>
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
						</article>

				<article class="col-sm-6">	
					
						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Ajouter une catégorie</h2>
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
										if(isset($_POST['submit']))
										{
											if(isset($_POST['titre']))
											{
												$maxID = $bdd->prepare("SELECT overid FROM categories ORDER BY overid DESC limit 1");
												$maxID->execute();
												$BoucleMax = $maxID->fetch();

												$overid = $BoucleMax['overid'] +1;

												$titre = htmlspecialchars($_POST['titre']);

													$req = $bdd->prepare('INSERT INTO categories(overid, titre) VALUES(:overid, :titre)');
													$req -> bindParam(':overid', $overid);
													$req -> bindParam(':titre', $titre);
													$req -> execute();

													$show->showSuccess("Succès, votre catégorie a été ajouté.");

													$maxID->closeCursor();
													$req->closeCursor();

	
												}
											
											else
											{
												$show->showError("Vous devez remplir tous les champs.");
											}
										}
										?>
										<form action="" class="smart-form" method="post">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>

												<section>
													<label class="label">Titre</label>
													<label class="input"> <i class="icon-prepend fa fa-laptop"></i>
														<input type="text" name="titre">

														<b class="tooltip tooltip-top-left">
															<i class="fa fa-warning txt-color-teal"></i> 
															Compris entre 3 et 50 caractères</b> 
													</label>
												</section>

											</fieldset>

											<footer>
												<input type="submit" class="btn btn-primary" value="Ajouter" name="submit">

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

				<article class="col-sm-6">	
					
						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Ajouter une sous catégorie</h2>
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
											//var_dump($_POST);
											if(isset($_POST['title']) && isset($_POST['categorie']) && isset($_POST['image']) && isset($_POST['texte']))
											{
												$maxID = $bdd->prepare("SELECT overid FROM sous_categories ORDER BY overid DESC limit 1");
												$maxID->execute();
												$BoucleMax = $maxID->fetch();

												$overid = $BoucleMax['overid'] +1;

												$titre = htmlspecialchars($_POST['title']);
												$categorie = intval($_POST['categorie']);
												$image = htmlspecialchars($_POST['image']);
												$texte = htmlspecialchars($_POST['texte']);

												$req = $bdd->prepare('INSERT INTO sous_categories(overid, id_categorie, nom, description, background) VALUES(:overid, :id_categorie, :nom, :description, :background)');
												$req -> bindParam(':overid', $overid);
												$req -> bindParam(':id_categorie', $categorie);
												$req -> bindParam(':nom', $titre);
												$req -> bindParam(':description', $texte);
												$req -> bindParam(':background', $image);
												$req -> execute();

												if($req->rowCount() ==1)
												{
													$show->showSuccess("Succès, votre catégorie a été ajouté.");
												}
													
												$maxID->closeCursor();
												$req->closeCursor();

	
												}
											
											else
											{
												$show->showError("Vous devez remplir tous les champs.");
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
														<input type="text" name="title" placeholder="Titre">
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
		                                                	echo '<option value="'.$resultats->id.'">'.$resultats->titre.'</option>';
		                                                }
		                                             ?>
								                      </select>
							                       <i></i> </label>
												</section>

												<div style="clear:both"></div><br>
													
												<section>
													<label class="input">
														<input type="text" placeholder="Image" name="image">
													</label>
												</section>

												<section>
													<label class="input">
														<input type="text" placeholder="Présentation de la sous catégorie" name="texte">
													</label>
												</section>
											</fieldset>

											<footer>
												<input type="submit" class="btn btn-primary" value="Ajouter" name="submit1">

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

				<article class="col-sm-6">
					
						<div class="jarviswidget">

								<header role="heading">
									<h2>Gérer les sous-catégories</h2>
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
											if(isset($_GET['id_del1']))
											{
												$id_del = intval($_GET['id_del1']);
												// SPR
												$delete = $bdd->prepare('DELETE FROM sous_categories WHERE id = :id_del');
												$delete -> bindParam(':id_del', $id_del);
												$delete -> execute();
												$show->showSuccess("Sous catégorie supprimé avec succès.");
											}			
											
											if(isset($_GET['editer1']))
											{
												$maxID1 = $bdd->prepare("SELECT overid FROM sous_categories ORDER BY overid DESC limit 1");
												$maxID1->execute();
												$BoucleMax1 = $maxID1->fetch();

												$overid1 = $BoucleMax1['overid'] +1;


												$id = intval($_GET['editer1']);

												// UPDATE
													$update = $bdd->prepare('UPDATE sous_categories SET overid = :overid WHERE id = :id');
													$update -> bindParam(':overid', $overid1);
													$update -> bindParam(':id', $id);
													$update -> execute();
															
													$show->showSuccess('La sous catégorie est désormais en tête de liste');
											}			
															
										?>
										<table class="table table-striped">
											<thead>
		                                              <tr>
		                                                    <th>Position</th>
		                                                    <th>Nom de la catégorie</th>
		                                                    <th>Nom de la sous catégorie</th>
		                                                    <th>Action</th>
		                                              </tr>
												</thead>
											<tbody>
													<?php
													$i=1;
														$requete = $bdd->prepare("
															SELECT 
																sous_categories.*,
																categories.titre 
															FROM 
																sous_categories 
																JOIN categories ON sous_categories.id_categorie = categories.id 

															

															ORDER BY sous_categories.overid DESC


														");
														$requete->execute();
		                                            
		                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
		                                                {
		                                                            echo '<tr>';

																	  echo '<td>n° '.$i.'</td>';

																	  echo '<td>'.$resultats->titre.'</td>';

																	  echo '<td>'.$resultats->nom.'</td>';
																	  
																	  echo '<td>';
																		echo '<div class="btn-group"><center>';
																		echo '<a href="?id_del1='.$resultats->id.'" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash-o"></i></span>Supprimer</a> ';
																		echo '<a href="?editer1='.$resultats->id.'" class="btn btn-labeled btn-success"><span class="btn-label"><i class="fa fa-bolt"></i></span>Monter en tête</a> ';
																		echo '<a href="forum-modifier.php?id='.$resultats->id.'" class="btn btn-labeled btn-info"><span class="btn-label"><i class="fa fa-edit"></i></span>Modifier</a>';
																		echo '</center></div>';
																	  echo '</td>';

		                                                        echo '</tr>';
		                                                        $i++;
		                                                }
		                                             ?>
													</tbody>
												</table>
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