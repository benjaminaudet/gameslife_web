<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Ajouter récompenses';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {

	$serveur = 'f';
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



						<div class="jarviswidget jarviswidget-sortable col-sm-4">

								<header role="heading">
									<h2>Ajouter une récompense</h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->
		                            <?php
									if(isset($_POST['item']) && isset($_POST['q']) && isset($_POST['commande']) && isset($_POST['p'])) 
									{
										$req = $bdd->prepare('INSERT INTO probabilites(quantite, nom, p, commande, serveur) VALUES(:quantite, :nom, :p, :commande, :serveur)');
										$req -> bindParam(':quantite', $_POST['q']);
										$req -> bindParam(':nom', $_POST['item']);
										$req -> bindParam(':p', $_POST['p']);
										$req -> bindParam(':commande', $_POST['commande']);
										$req -> bindParam(':serveur', $serveur);
										$req -> execute();
									?>
		                                    <div class="alert alert-success alert-block">
		                                        <a class="close" data-dismiss="alert" href="#">×</a>
		                                        <h4 class="alert-heading">Succès :</h4>
		                                         L'item <b><?php echo $_POST['item']; ?></b> a été créé avec succès.
		                                    </div>
									<?php
									}
									?>
									<!-- widget content -->
									<div class="widget-body">
										<div class="alert alert-info">
											<b>Les commandes:</b><br>
											Pour faire gagner des points : POINTS X, X étant un chiffre ex : POINTS 15 <br>
											<center>ou</center><br>
											Pour faire gagner un item : give pseudo_var 1 1
										</div>

										<form action="" class="smart-form" method="post">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>

												<section>
													<label class="label">Nom de l'item</label>
													<label class="input">
														<input type="text" name="item" id="basicround">
													</label>
												</section>

												<section>
													<label class="label">Quantité</label>
													<label class="input">
														<input type="text" name="q" id="basicround">
													</label>
												</section>

												<section>
													<label class="label">Probabilité</label>
													<label class="input">
														<input type="text" name="p" id="basicround">
													</label>
												</section>

												<section>
													<label class="label">Commande</label>
													<label class="input">
														<input type="text" name="commande" id="basicround">
													</label>
												</section>


											</fieldset>


											</fieldset>

											<footer>
												<button type="submit" class="btn btn-primary" name="submit">Ajouter</div>
											</footer>

										</form>
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

				<?php
				if(isset($_GET['suppr']))
				{
					$suppr = $_GET['suppr'];
					// SPR
					$delete = $bdd->prepare('DELETE FROM probabilites WHERE id = :suppr');
					$delete -> bindParam(':suppr', $suppr);
					$delete -> execute();
					echo '<div class="alert alert-success alert-block"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Succès :</h4> L\'item est supprimé.</b></div>';
				}			
								
				?>
						<div class="jarviswidget jarviswidget-sortable col-sm-6" style="margin-left:25px;">

								<header role="heading">
									<h2>Gestion des récompenses</h2>
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
										
										<table class='table table-striped dataTable table-bordered'>
											<thead>
                                                <tr>
                                                      <th>Nom</th>
                                                      <th>Quantité</th>
                                                      <th>Probabilité</th>
                                                      <th>Commande</th>
                                                      <th>Actions</th>
                                                </tr>
											</thead>
											<tbody>
											<?php
												$requete = $bdd->prepare("SELECT * FROM probabilites WHERE serveur = '".$serveur."' ORDER BY id ASC");
												$requete->execute();
                                            
                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                                                {
                                                            echo '<tr>';
															  echo '<td>'.$resultats->nom.'</td>';
															  echo '<td>'.$resultats->quantite.'</td>';
															  echo '<td>'.$resultats->p.'</td>';
															  echo '<td>'.$resultats->commande.'</td>';
															  
															  echo '<td>';
															  	echo '<div class="btn-group">';
																echo '<a href="modifier-recompense.php?id='.$resultats->id.'" class="btn btn-labeled btn-warning"><span class="btn-label"><i class="fa fa-edit"></i></span>Modifier</a> ';

																echo ' <a href="?suppr='.$resultats->id.'" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-ban"></i></span>Supprimer</a>';
																echo '</div>';

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