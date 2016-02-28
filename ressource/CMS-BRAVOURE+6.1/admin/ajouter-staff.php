<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Staff';
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
									<h2>Ajouter un membre du staff</h2>
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
										if(isset($_POST['add'])) 
										{
											$req = $bdd->prepare('INSERT INTO staff(rang, pseudo, age, role) VALUES(:rang, :pseudo, :age, :role)');
											$req -> bindParam(':rang', $_POST['rang']);
											$req -> bindParam(':pseudo', $_POST['pseudo']);
											$req -> bindParam(':age', $_POST['age']);
											$req -> bindParam(':role', $_POST['role']);
											$req -> execute();
										?>
			                                    <div class="alert alert-success alert-block">
			                                        <a class="close" data-dismiss="alert" href="#">×</a>
			                                        <h4 class="alert-heading">Succès :</h4>
			                                         Le membre <b><?php echo $_POST['pseudo']; ?></b> a intégré votre staff.
			                                    </div>
										<?php
										}
										?>
			                            
										<form action="#" class="smart-form col-sm-4" method="post">
												<legend>Remplissez le formulaire ci-dessous.</legend>


												<section>
													<label class="label">Nom du membre</label>
													<label class="input">
														<input type="text" name="pseudo" id="basicround">
													</label>
												</section>

												<section>
													<label class="label">Rang</label>
													<label class="input">
														<input type="text" name="rang" id="basicround">
													</label>
												</section>

												<section>
													<label class="label">Age</label>
													<label class="input">
														<input type="text" name="age" id="basicround">
													</label>
												</section>

												<section>
													<label class="label">Role</label>
													<label class="input">
														<input type="text" name="role" id="basicround">
													</label>
												</section>

			                                    <footer>
													<button class="btn btn-primary" type="submit" name="add">Ajouter au staff</button>
												</footer>
										</form>

										<div style="clear:both"></div>

			                            <div class="alert alert-success">Informations<br>
										Pour le rang, veuillez mettre 1 ou 2 ou 3.
										</div>
									</div>
											<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
				            
				            <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Gestion</h2>
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
										if(isset($_GET['suppr']))
										{
											$suppr = $_GET['suppr'];
											// SPR
											$delete = $bdd->prepare('DELETE FROM staff WHERE id = :suppr');
											$delete -> bindParam(':suppr', $suppr);
											$delete -> execute();
											echo '<div class="alert alert-success alert-block"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Succès :</h4> L\'item est supprimé.</b></div>';
										}			
																		
										?>

										<div class="tab-content">
												<div class="tab-pane active" id="basic">
													<table class='table table-striped dataTable table-bordered'>
														<thead>
			                                                <tr>
			                                                      <th>ID</th>
			                                                      <th>Pseudo</th>
			                                                      <th>Actions</th>
			                                                </tr>
														</thead>
														<tbody>
														<?php
															$requete = $bdd->prepare("SELECT * FROM staff ORDER BY id ASC");
															$requete->execute();
			                                            
			                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
			                                                {
			                                                            echo '<tr>';
																		  echo '<td>'.$resultats->id.'</td>';
																		  echo '<td>'.$resultats->pseudo.'</td>';
																		  
																		  echo '<td>';
																			echo '<div class="btn-group"><center>';
																			echo '<a href="?suppr='.$resultats->id.'" class="btn btn-danger">Supprimer</a>';
																			echo '</center></div>';
																		  echo '</td>';
			                                                        echo '</tr>';
			                                                }
			                                             ?>
														</tbody>
													</table>
												</div>
										</div>
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