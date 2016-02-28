<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Achats';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
	if(isset($_GET['serveur']))
	{
		$serveur = 	$_GET['serveur'];
		$_SESSION['serveur'] = $serveur;
	}
	else
	{
		$serveur = 'connexion_1';
		$_SESSION['serveur'] = $serveur;
	}
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
									<div class="widget-body">
										<table class='table table-striped dataTable table-bordered'>
											<thead>
                                                <tr>
                                                  <th></th>
                                                  <th>id</th>
                                                  <th>Joueur</th>
                                                  <th>Date</th>
                                                  <th>Offre</th>
                                                  <th>Adresse IP</th>
                                                </tr>
											</thead>
											<tbody>
											<?php
									        $query = $bdd->prepare('SELECT COUNT(*) FROM historique ');
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

                                            $requete = $bdd->prepare('
                                            	SELECT * 
                                            	FROM historique 
                                            	ORDER BY id DESC LIMIT '.$start.', '.$epp.'

                                            ');
                                            $requete->execute();
											$i = 1;
                                            
                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                                                {
													$raq = $bdd->prepare("SELECT nom, prix, serveur FROM boutique WHERE id = '".$resultats->nom_offre."'");
													$raq->execute();
													$boutique=$raq->fetch();	

                                                            echo '<tr>';
                                                              echo '<td>#'.$i.'</td>';
                                                              echo '<td>'.$resultats->id.'</td>';
                                                              echo '<td>'.$resultats->joueur.'</td>';
                                                              echo '<td>le '.date("d-m-Y à H:i", $resultats->date_achat).'</td>';
                                                              echo ' <td>'.$boutique['nom'].' - Prix: '.$boutique['prix'].' - <i>Serveur: '.$boutique['serveur'].'</i></td>';
                                                              echo ' <td>'.$resultats->adresse_ip.'</td>';
                                                        echo '</tr>';
														$i++;
                                                }
                                             ?>
											</tbody>
										</table>

										<?php echo paginate('achats.php', '?p=', $nbPages, $current);?>

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