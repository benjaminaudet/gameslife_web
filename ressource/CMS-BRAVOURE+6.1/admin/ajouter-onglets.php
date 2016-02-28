<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Ajouter onglets';
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
				<br><article style="padding:25px;">
					<?php include 'doc/situation.php'; ?>



						<div class="jarviswidget jarviswidget-sortable col-sm-4">

								<header role="heading">
									<h2>Ajouter un onglet</h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
										<!-- end widget edit box -->
			                            <?php
										if(isset($_POST['categorie']) && isset($_POST['serveur'])) 
										{
											$req = $bdd->prepare('INSERT INTO boutique_onglets(onglet, serveur) VALUES(:onglet, :serveur)');
											$req -> bindParam(':onglet', $_POST['categorie']);
											$req -> bindParam(':serveur', $_POST['serveur']);
											$req -> execute();
										?>
			                                    <div class="alert alert-success alert-block">
			                                        <a class="close" data-dismiss="alert" href="#">×</a>
			                                        <h4 class="alert-heading">Succès :</h4>
			                                         L'onglet (catégorie) <b><?php echo $_POST['categorie']; ?></b> a été créé avec succès.
			                                    </div>
										<?php
										}
										?>
									<!-- widget content -->
									<div class="widget-body">

										<form action="" class="smart-form" method="post">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>

												<section>
													<label class="label">Nom de l'onglet</label>
													<label class="input">
														<input type="text" name="categorie" id="categorie">
													</label>
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


						<div class="jarviswidget jarviswidget-sortable col-sm-4" style="margin-left:25px;">

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
											<?php
											if(isset($_GET['onglet']))
											{
												$onglet = $_GET['onglet'];
												// SPR
												$delete = $bdd->prepare('DELETE FROM boutique_onglets WHERE id = :onglet');
												$delete -> bindParam(':onglet', $onglet);
												$delete -> execute();
												echo '<div class="alert alert-success alert-block"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Succès :</h4> L\'onglet est supprimé.</b></div>';
											}			
															
											?>										
										<table class='table table-striped dataTable table-bordered'>
											<thead>
                                                <tr>
                                                      <th>ID</th>
                                                      <th>Nom</th>
                                                       <th>Serveur</th>
                                                      <th>Actions</th>
                                                </tr>
											</thead>
											<tbody>
											<?php
												$requete = $bdd->prepare("SELECT * FROM boutique_onglets ORDER BY id ASC");
												$requete->execute();
                                            
                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                                                {
                                                            echo '<tr>';
															  echo '<td>'.$resultats->id.'</td>';
															  echo '<td>'.$resultats->onglet.'</td>';
															  echo '<td>'.$resultats->serveur.'</td>';
															  echo '<td>';
																echo '<div class="btn-group"><center>';
																echo '<a href="?onglet='.$resultats->id.'" class="btn btn-red" >Supprimer</a>';
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

							</div>							</div>



							
							
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