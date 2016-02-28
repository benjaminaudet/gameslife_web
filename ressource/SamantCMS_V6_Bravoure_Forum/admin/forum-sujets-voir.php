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

  	$id_topic = intval($_GET['id']);

  	require_once "../forum/settings.php";
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
									<h2><?php echo $titre; ?></h2>
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
										if(isset($_GET['id_delete']))
										{
											$id_del = intval($_GET['id_delete']);

											$delete = $bdd->prepare('DELETE FROM topics_comments WHERE id = :id_del');
											$delete -> bindParam(':id_del', $id_del);
											$delete -> execute();

											if($delete->rowCount() == 1)
											{
												$show->showSuccess("Le commentaire a bien été supprimé");
											}
											else
											{
												$show->showError('Problème technique.');
											}
										}		


													
				                        $query = $bdd->prepare('SELECT COUNT(*) FROM topics_comments WHERE topic_id = "'.$id_topic.'"');
				                        $query->execute();
				                        $resultats = $query->fetch();
				                        $total = $resultats[0];

				                        $epp = 25;
				                        $nbPages = ceil($total/$epp);
				                        $current = 1;
				                        if (isset($_GET['p']) && is_numeric($_GET['p'])) {
				                          $page = intval($_GET['p']);
				                          if ($page >= 1 && $page <= $nbPages) {
				                            $current=$page;
				                          } else if ($page < 1) {
				                            $current=1;
				                          } else {
				                            $current = $nbPages;
				                          }
				                        }
				                        $start = ($current * $epp - $epp);

										$requete = $bdd->prepare("
											SELECT 
												DISTINCT(ts.id),
												ts.*,
												us.user_pseudo

											FROM 
												topics_comments ts 
												LEFT JOIN joueurs us ON us.user_id = ts.user_id 

											WHERE topic_id = ".$id_topic."

											ORDER BY 
												ts.id  ASC 


											LIMIT ".$start.", ".$epp."
										");
										$requete->execute();
										?>

										<h1 class="font-md"> 
											Nombre de commentaires total :
											<small class="text-danger"> &nbsp;&nbsp;(<?php echo $total; ?> résultats)</small>
										</h1>

										<br>

										<table id="resultTable" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Auteur</th>
													<th>Date</th>
													<th>Texte</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											while($resultats = $requete->fetch(PDO::FETCH_OBJ))
											{
											?>

												<tr>
													<td><?php echo $resultats->id;?></td>

													<td><a href="" class="btn btn-info"><?php echo $resultats->user_pseudo;?></a></td>

													<td><?php echo date('d/m/Y à H:i', $resultats->date);?></td>
													
													<td><?php echo bbcode($resultats->texte);?></td>

													<td>
														<a href="?id=<?php echo $id_topic; ?>&id_delete=<?php echo $resultats->id;?>" class="btn btn-danger">Supprimer</a>
													</td>
												</tr>

											<?php
											}
											?>

											</tbody>
										</table>

										<div class="text-center">
											<hr>
											<?php echo paginate('forum-sujets-voir.php?&', 'p=', $nbPages, $current);?>
										</div>
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
						</article>

						<div style="clear:both;"></div>

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