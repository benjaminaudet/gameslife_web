<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Gérer les nouvelles';
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
				<article class="col-sm-12 col-md-12 col-lg-12">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Gérer les nouvelles</h2>
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
												$delete = $bdd->prepare('DELETE FROM news WHERE id = :id_del');
												$delete -> bindParam(':id_del', $id_del);
												$delete -> execute();
												echo '<div class="alert alert-success alert-block"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Succès :</h4> La nouvelle est supprimée.</b></div>';
											}			
															
										?>
										<table class="table table-striped table-hover">
											<thead>
		                                              <tr>
		                                                    <th style="width:5%">ID</th>
		                                                    <th style="width:15%">Titre</th>
		                                                    <th style="width:20%">Date</th>
		                                                    <th style="width:15%">Auteur</th>
		                                                    <th style="width:15%">Actions</th>
		                                              </tr>
												</thead>
											<tbody>
													<?php
														$requete = $bdd->prepare("SELECT * FROM news ORDER BY id ASC");
														$requete->execute();
		                                            
		                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
		                                                {
		                                                            echo '<tr>';
																	  echo '<td>'.$resultats->id.'</td>';
																	  echo '<td>'.$resultats->titre.'</td>';
		                                                              echo '<td>le '.date("d-m-Y à H:i", $resultats->date).'</td>';
																	  echo ' <td>'.$resultats->auteur.'</td>';
																	  echo '<td>';
																		echo '<div class="btn-group"><center>';
																		echo '<a href="nouvelles-editer.php?id='.$resultats->id.'" class="btn btn-info">Editer</a> ';
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