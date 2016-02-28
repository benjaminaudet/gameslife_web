<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Membres inscrits';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
?>

	<style type="text/css">
	.pagination {
	font:12px Arial, Helvetica, sans-serif;
	margin:40px 0 0 90px;
	}

	.pagination a {
	background:#fff;
	border:1px solid #06c;
	color:#06c;
	margin:2px;
	padding:.2em .4em;
	text-decoration:none
	}

	.pagination a:hover {
	background:#fff;
	border:1px solid #bd88fe;
	color:#bd88fe
	}

	.pagination span.inactive {
	background:#fff;
	border:1px solid #f0f0ff;
	color:#f0f0ff;
	margin:2px;
	padding:.2em .4em
	}

	.pagination span.active {
	background:#f4ebff;
	border:1px solid #bd88fe;
	color:#bd88fe;
	font-weight:700;
	margin:2px;
	padding:.2em .4em
	}

	#results{
	margin-left:90px;
	list-style-type:circle
	}
	</style>
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
									<h2>Membre inscrits</h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->


									<?php
									  $query = $bdd->prepare('SELECT * FROM joueurs');
									  $query->execute();

									  $total = $query->rowCount();

									  $epp = 20;
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
									<!-- widget content -->
									<div class="widget-body no-padding">

										<div class="alert alert-info">
											Cliquez sur le pseudo de la personne pour accéder à sa page personnelle.
										</div>

										<table class="table table-striped table-hover">
											<thead>
		                                              <tr>
		                                                    <th>ID</th>
		                                                    <th>Pseudo</th>
		                                                    <th>E-mail</th>
		                                                    <th>Points</th>
		                                                    <th>Date d'inscription</th>
		                                                    <th>Nombre de vote</th>
		                                                    <th>Date et heure du vote</th>
		                                              </tr>
												</thead>
											<tbody>
													<?php
														$requete = $bdd->prepare('SELECT * FROM joueurs ORDER BY user_id ASC LIMIT '.$start.', '.$epp.'');
														$requete->execute();
		                                            
		                                                while($resultats = $requete->fetch(PDO::FETCH_OBJ))
		                                                {
		                                                    echo '<tr>';
															 
															  echo '<td>'.$resultats->user_id.'</td>';
															  															 
															  echo '<td><a href="membre-informations.php?id='.$resultats->user_id.'">'.$resultats->user_pseudo.'</a></td>';
		                                                     
		                                                      echo '<td>'.$resultats->user_mail.'</td>';
															 
															  echo ' <td style="text-align:right;">'.$resultats->user_points.' <img src="../images/gold.png" style="display:inline; position:relative; top:0px;"/></td>'; 
															 
															  echo ' <td>le '.date("d-m-Y à H:i", $resultats->user_inscription ).'</td>';
															 
															  echo ' <td>'.$resultats->vote.' votes</td>';

															  if($resultats->date_vote ==! '') :
															  	echo ' <td>'.date("d-m-Y à H:i", $resultats->date_vote ).'</td>';	
															  else :
															  	echo '<td>Aucun vote</td>';
															  endif;
															 
															  echo '</td>';
		                                                    echo '</tr>';
		                                                }
		                                             ?>
													</tbody>
										</table>
										<?php echo paginate('../admin/membre-inscrit.php', '?p=', $nbPages, $current);?>
										<br><br>
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
						</article>

						<div style="clear:both"></div>
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