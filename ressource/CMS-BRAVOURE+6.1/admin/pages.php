<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Pages';
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
				<br><article class="col-sm-12">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Gérer les pages</h2>
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
										if(isset($_GET['id_del']))
										{
											$id_del = intval($_GET['id_del']);
											// SPR
											$delete = $bdd->prepare('DELETE FROM pages WHERE id = :id_del');
											$delete -> bindParam(':id_del', $id_del);
											$delete -> execute();
											$show->showSuccess('Supprimé avec succès');
										} ?>
										<table class="table table-striped">
											<thead>
		                                              <tr>
		                                                    <th>ID</th>
		                                                    <th>Titre</th>
		                                                    <th>Actions</th>
		                                              </tr>
												</thead>
											<tbody>
												<?php
												$requete = $bdd->prepare("SELECT * FROM pages ORDER BY id ASC");
												$requete->execute();
                                            
                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                                                {
                                                            echo '<tr>';
															  echo '<td>'.$resultats->id.'</td>';
															  echo '<td>'.ucfirst($resultats->titre).'</td>';

															  echo '<td>';
																echo '<div class="btn-group"><center>';
																
																	echo '<a href="pages-editer.php?id='.$resultats->id.'" class="btn btn-labeled btn-warning">';
																		echo '<span class="btn-label"><i class="fa fa-edit"></i></span>';
																		echo ' Éditer';
																	echo '</a> ';

																	echo '<a href="" class="btn btn-labeled btn-success">';
																		echo '<span class="btn-label"><i class="fa fa-desktop"></i></span>';
																		echo ' Voir la page ';
																	echo '</a> ';

																	echo '<a href="?id_del='.$resultats->id.'" class="btn btn-labeled btn-danger">';
																		echo '<span class="btn-label"><i class="fa fa-eraser"></i></span>';
																		echo ' Supprimer ';
																	echo '</a>';

																echo '</center></div>';
															  echo '</td>';

                                                        echo '</tr>';
                                                }
		                                        ?>

													</tbody>
												</table>
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							
							<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Ajouter une page</h2>
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
										if(isset($_POST['add']) && !empty($_POST['titre'])) 
										{
											$date = time();
											$page = 'Page à éditer dès maintenant sur votre panel admin !';
											
											$req = $bdd->prepare('INSERT INTO pages(titre, page, date) VALUES(:titre, :page, :date)');
											$req -> bindParam(':titre', $_POST['titre']);
											$req -> bindParam(':page', $page);
											$req -> bindParam(':date', $date);
											$req -> execute();

											if($req->rowCount() == 1)
											{
												$show->showSuccess('Page ajoutée avec succès.');
											}
										}
										?>
										<form action="#" class="smart-form" method="post">
												<legend>Remplissez le formulaire ci-dessous.</legend>

												<div class="control-group">
													<label for="basicround" class="control-label">Nom de la page</label>
													<div class="controls">
														<input type="text" name="titre">
													</div>
												</div>


			                                    <div class="form-actions">
													<button class="btn btn-primary" type="submit" name="add">Ajouter</button>
													<input type="reset" class='btn btn-danger' value="Annuler">
												</div>
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