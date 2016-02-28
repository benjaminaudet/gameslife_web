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

											$delete = $bdd->prepare('DELETE FROM topics WHERE id = :id_del');
											$delete -> bindParam(':id_del', $id_del);
											$delete -> execute();

											if($delete->rowCount() == 1)
											{
												$show->showSuccess("Le sujet a bien été supprimé");
											}
											else
											{
												$show->showError('Problème technique.');
											}
										}		
											
										if(isset($_GET['fermer']))
										{
											$fermer = intval($_GET['fermer']);
											$lock = 1;
											// SPR
											$cloture = $bdd->prepare('UPDATE topics SET locked = :lock WHERE id = :fermer');
											$cloture -> bindParam(':lock', $lock);
											$cloture -> bindParam(':fermer', $fermer);
											$cloture -> execute();

											if($cloture->rowCount() == 1)
											{
												$show->showSuccess("Topic fermé avec succès.");
											}
											else
											{
												$show->showError('Problème technique.');
											}
										}	

													
				                        $query = $bdd->prepare('SELECT COUNT(*) FROM topics');
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
												topics ts 
												LEFT JOIN joueurs us ON us.user_id = ts.user_id 

											ORDER BY 
												ts.id  DESC 

											LIMIT ".$start.", ".$epp."
										");
										$requete->execute();
										?>

										<h1 class="font-md"> 
											Nombre de sujets total :
											<small class="text-danger"> &nbsp;&nbsp;(<?php echo $total; ?> résultats)</small>
										</h1>

										<br>

										<table id="resultTable" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Sous catégorie</th>
													<th>Titre</th>
													<th>Date</th>
													<th>Auteur</th>
													<th>Statut</th>
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
													
													<td><?php echo $resultats->sous_categorie;?></td>
													
													<td><?php echo $resultats->titre;?></td>

													<td><?php echo date('d/m/Y à H:i', $resultats->date);?></td>
													
													<td><a href="" class="btn btn-info"><?php echo $resultats->user_pseudo;?></a></td>
													
													<td><?php if($resultats->locked == 0) echo '<span class="badge">Ouvert</span>'; else  echo '<span class="badge">Fermé</span>';?></td>

													<td>
														<a href="forum-sujets-editer.php?id=<?php echo $resultats->id;?>" class="btn btn-success">Éditer</a>
														<a href="forum-sujets-voir.php?id=<?php echo $resultats->id;?>" class="btn btn-default">Gérer les commentaires</a>
														<a href="?fermer=<?php echo $resultats->id;?>" class="btn btn-info">Fermer</a>
														<a href="?id_delete=<?php echo $resultats->id;?>" class="btn btn-danger">Supprimer</a>
													</td>
												</tr>

											<?php
											}
											?>

											</tbody>
										</table>

										<div class="text-center">
											<hr>
											<?php echo paginate('forum-sujets-gerer.php?&', 'p=', $nbPages, $current);?>
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