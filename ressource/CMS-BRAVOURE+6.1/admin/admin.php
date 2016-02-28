<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Admins';
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
					
						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Gérer les administrateurs</h2>
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
												$delete = $bdd->prepare('DELETE FROM admin WHERE id = :id_del');
												$delete -> bindParam(':id_del', $id_del);
												$delete -> execute();
												$show->showSuccess("Admin supprimé avec succès.");
											}			
															
										?>
										<table class="table table-striped">
											<thead>
		                                              <tr>
		                                                    <th>ID</th>
		                                                    <th>Login</th>
		                                                    <th>Email</th>
		                                                    <th>Action</th>
		                                              </tr>
												</thead>
											<tbody>
													<?php
														$requete = $bdd->prepare("SELECT * FROM admin ORDER BY id DESC");
														$requete->execute();
		                                            
		                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
		                                                {
		                                                	echo '<tr>';
																 echo '<td>'.$resultats->id.'</td>';

																 echo '<td>'.$resultats->pseudo.'</td>';

																 echo ' <td>'.$resultats->email.'</td>';
																 
																 echo '<td>';
																	echo '<div class="btn-group"><center>';
																	echo '<a href="?id_del='.$resultats->id.'" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-ban"></i></span>Supprimer</a>';
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
						</article>

				<article class="col-sm-6">	
					<?php
					if(isset($_POST['submit']))
					{
						if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email']))
						{
							if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email']))
							{
								$password = md5($_POST['password']);
								
								$req = $bdd->prepare('INSERT INTO admin(pseudo, mdp, email) VALUES(:pseudo, :password, :email)');
								$req -> bindParam(':pseudo', $_POST['login']);
								$req -> bindParam(':password', $password);
								$req -> bindParam(':email', $_POST['email']);
								$req -> execute();

								$show->showSuccess("Succès, votre article a été ajouté.");
							}
							else
							{
								$show->showError("Tous les champs doivent être remplis.");
							}
						}
						else
						{
							$show->showError("Tous les champs doivent être remplis.");
						}

					}
					?>
					
						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Ajouter un administrateur</h2>
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

										<form action="" class="smart-form" method="post">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>

												<section>
													<label class="label">Login</label>
													<label class="input"> <i class="icon-prepend fa fa-user"></i>
														<input type="text" name="login">

														<b class="tooltip tooltip-top-left">
															<i class="fa fa-warning txt-color-teal"></i> 
															Compris entre 3 et 50 caractères</b> 
													</label>
												</section>

												<section>
													<label class="label">Mot de passe</label>
													<label class="input"> <i class="icon-prepend fa fa-unlock"></i>
														<input type="password" name="password">
														<b class="tooltip tooltip-bottom-left">
															<i class="fa fa-warning txt-color-teal"></i> 
															Compris entre 3 et 50 caractères</b> 
													</label>
												</section>

												<section>
													<label class="label">Email</label>
													<label class="input"> <i class="icon-prepend">@</i>
														<input type="text" name="email">
														<b class="tooltip tooltip-bottom-left">
															<i class="fa fa-warning txt-color-teal"></i> 
															L'adresse e-mail doit être valide</b> 
													</label>
												</section>

											</fieldset>


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