<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Boutique';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
	$n = $bdd->prepare("SELECT id FROM boutique ORDER BY id DESC LIMIT 1");
	$n->execute();
	$w=$n->fetch();
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

						<div class="jarviswidget">

								<header role="heading">
									<h2>Ajouter un item en boutique</h2>
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
												$delete = $bdd->prepare('DELETE FROM boutique WHERE id = :id_del');
												$delete -> bindParam(':id_del', $id_del);
												$delete -> execute();
												echo '<div class="alert alert-success alert-block"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading">Succès :</h4> L\'objet sélectionné a été supprimé.</b></div>';
											}	

									
									        $query = $bdd->prepare('SELECT COUNT(*) FROM boutique');
					                        $query->execute();
					                        $resultats = $query->fetch();
					                        $total = $resultats[0];

					                        $epp = 6;
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

											
										

										?>
			                            <?php $show->showSuccess("Commande boutique : give pseudo_var 1 1; <br> Pour plusieurs commandes : give pseudo_var 1 1;give pseudo_var 1 1;"); ?>
			                            <div class="alert alert-info">
			                            	Il est important de mettre ; à la fin de chaque commande, sinon la commande ne marchera pas.
			                            </div>
			                            <div class="">
			                            <a href="boutique-item.php" class="btn btn-primary"> Ajouter un item</a>   
			                            <a href="boutique-grade.php" class="btn btn-success">Ajouter un grade progressif</a>

			                            <br>  <br>
 										

 										<div id="status"></div>
 										<div id="xmlhttp"></div>

										<table class='table table-striped dataTable table-bordered' >
											<thead>
                                                <tr>
                                                      <th>id</th>
                                                      <th>(1)</th>
                                                      <th>Grade nécessaire</th>
                                                      <th >Nom de l'objet</th>
                                                      <th>Description</th>
                                                      <th >Prix</th>
                                                      <th>Catégorie</th>
                                                      <th>Commande</th>
                                                      <th>Serveur</th>
                                                      <th>#</th>
                                                </tr>
											</thead>
											<tbody  id="matable">
                                             
											<?php
											
										
												$requete = $bdd->prepare('SELECT * FROM boutique ORDER BY serveur DESC LIMIT '.$start.', '.$epp.'');
												$requete->execute();
                                            
                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                                                {
                                                           
														echo '<tr>';
															  echo '<td>'.$resultats->id.'</td>';
															  echo '<td>'.$resultats->ordre_id.'</td>';
															  echo '<td>'.$resultats->grade_necessaire.'</td>';
															  echo '<td>'.stripcslashes($resultats->nom).'</td>';
															  if ($resultats->description == '') echo '<td>Aucune description</td>';
															  else echo '<td>'.stripcslashes($resultats->description).'</td>';
															  echo '<td class="hidden-phone">'.$resultats->prix.' points</td>';
															  echo ' <td>'.$resultats->categorie.'</td>';
															  echo ' <td>'.$resultats->commande.'</td>';
															  echo ' <td>'.$resultats->serveur.'</td>';
															
															  
															echo '<td>';
															 ?>

                                                             <a href="boutique-modifier.php?id=<?php echo $resultats->id; ?>"class="btn btn-info">Editer</a>

                                                             <a href="?id_del=<?php echo $resultats->id; ?>" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-ban"></i></span>Supprimer</a>
															 <?php
															echo '</td>';
												
                                                        echo '</tr>';
														
                                                }
                                             ?>
											</tbody>
										</table>

										<?php echo paginate('boutique.php', '?p=', $nbPages, $current);?>

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