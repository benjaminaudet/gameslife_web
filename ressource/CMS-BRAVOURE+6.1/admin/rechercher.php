<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Historique du membre';
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

						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Rechercher l'historique d'un joueur</h2>
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
										<?php if(isset($_GET['search'])) : ?>

											<?php $pseudo = htmlspecialchars($_GET['search']); ?>
											<h1>Résultats pour la recherche <?php echo $pseudo; ?></h1>

											

											<?php
											$query = $bdd->prepare ("SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo");
											$query->bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
											$query->execute();

											if($query->rowCount() == 1) :
												$res = $query->fetch(PDO::FETCH_OBJ);

											?>
											<a href="membre-informations.php?id=<?php echo $res->user_id; ?>" class="btn btn-info">Afficher ses informations</a>
											<?php

												$query2 = $bdd->prepare("SELECT * FROM historique WHERE joueur = :user_pseudo");
												$query2->bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
												$query2->execute();

												$query3 = $bdd->prepare("SELECT * FROM historique_credit WHERE joueur = :user_pseudo");
												$query3->bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
												$query3->execute();

												$query4 = $bdd->prepare("SELECT * FROM historique_echange WHERE joueur = :user_pseudo");
												$query4->bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
												$query4->execute();

												$query5 = $bdd->prepare("SELECT * FROM historique_echange WHERE versjoueur = :user_pseudo");
												$query5->bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
												$query5->execute();

												echo '<h2>Informations des historiques</h2>';
												echo '<table class="table table-striped table-hover">';
													echo '<tr>';
														echo '<td>Pseudo</td>';
														echo '<td>'.$res->user_pseudo.'</td>';
													echo '</tr>';

													echo '<tr>';
														echo '<td>Points boutique</td>';
														echo '<td>'.$res->user_points.'</td>';
													echo '</tr>';

												echo '</table>';

												echo '<br><hr>';


												function historique_object($id, $bdd)
												{
													$requete = $bdd->prepare("SELECT * FROM boutique WHERE id = :id");
													$requete->bindParam(':id',  $id, PDO::PARAM_INT);
													$requete->execute();
													$reponse=$requete->fetch();
													
													return $reponse['nom'];

													$requete->closeCursor();
												}

												?>

											<div class="widget-body">

												<div>
													<ul class="nav nav-tabs tabs-left" id="demo-pill-nav">
														<li class="active">
															<a href="#tab-r1" data-toggle="tab"><span class="badge bg-color-blue txt-color-white"><?php echo $query2->rowCount(); ?></span> Historique des achats </a>
														</li>
														<li>
															<a href="#tab-r2" data-toggle="tab"><span class="badge bg-color-blueDark txt-color-white"><?php echo $query3->rowCount(); ?></span> Historique des crédits</a>
														</li>
														<li>
															<a href="#tab-r3" data-toggle="tab"><span class="badge bg-color-greenLight txt-color-white"><?php echo $query4->rowCount(); ?></span> Historique des échanges</a>
														</li
													</ul>
													<div class="tab-content">
														<br><br>
														<div class="tab-pane active" id="tab-r1">
															<?php
																echo '<h2>Historique des achats</h2>';

																if($query2->rowCount() > 0) :
																	$i=1;
																	echo '<table class="table table-striped table-hover" style=" width: 650px; ">';
																	while($res2 = $query2->fetch(PDO::FETCH_OBJ)):
																	echo '<tr>';
																		echo '<td>n° '.$i.'</td>';
																		echo '<td>le '.date('d/m/Y', $res2->date_achat).'</td>';
																		echo '<td>Nom : '.historique_object($res2->nom_offre, $bdd).'</td>';
																	echo '</tr>';
																	$i++;
																	endwhile;
																	echo '</table>';

																else :
																	echo '<div class="alert alert-danger">Aucun achat trouvé</div>';
																endif;

															?>
														</div>
														<div class="tab-pane" id="tab-r2">
															<?php
																echo '<h2>Historique des crédits</h2>';

																if($query3->rowCount() > 0) :
																	$i=1;
																	echo '<table class="table table-striped table-hover" style=" width: 650px; ">';
																	while($res3 = $query3->fetch(PDO::FETCH_OBJ)):
																	echo '<tr>';
																		echo '<td>n° '.$i.'</td>';
																		echo '<td>le '.date('d/m/Y', $res3->date_achat).'</td>';
																		echo '<td>Nombre de points : '.$res3->nom_offre.'</td>';
																		echo '<td>IP : '.$res3->adresse_ip.'</td>';
																	echo '</tr>';
																	$i++;
																	endwhile;
																	echo '</table>';

																else :
																	echo '<div class="alert alert-danger">Aucun crédit trouvé</div>';
																endif;

															?>
														</div>
														<div class="tab-pane" id="tab-r3">
															<?php
																echo '<h2>Historique des échanges (envoyés)</h2>';

																if($query4->rowCount() > 0) :
																	$i=1;
																	$r = 0;
																	echo '<table class="table table-striped table-hover" style=" width: 650px; ">';
																	while($res4 = $query4->fetch(PDO::FETCH_OBJ)):
																	echo '<tr>';
																		echo '<td>n° '.$i.'</td>';
																		echo '<td>Vers '.$res4->versjoueur.'</td>';
																		echo '<td>Nombre de points : '.$res4->nombre_point.'</td>';
																		echo '<td>Date échange : '.date('d/m/Y', $res4->date_echange).'</td>';
																		echo '<td>IP : '.$res4->adresse_ip.'</td>';
																	echo '</tr>';
																	$i++;
																	$r+=$res4->nombre_point;
																	endwhile;
																	echo '</table>';

																	echo 'Nombre de points envoyés : <b>'.$r.'</b>';

																else :
																	echo '<div class="alert alert-danger">Aucun échange trouvé</div>';
																endif;

															?>

															<?php

																echo '<h2>Historique des échanges (reçus)</h2>';

																if($query5->rowCount() > 0) :
																	$i=1;
																	$r = 0;
																	echo '<table class="table table-striped table-hover" style=" width: 650px; ">';
																	while($res5 = $query5->fetch(PDO::FETCH_OBJ)):
																	echo '<tr>';
																		echo '<td>n° '.$i.'</td>';
																		echo '<td>De '.$res5->joueur.'</td>';
																		echo '<td>Nombre de points : '.$res5->nombre_point.'</td>';
																		echo '<td>Date échange : '.date('d/m/Y', $res5->date_echange).'</td>';
																		echo '<td>IP : '.$res5->adresse_ip.'</td>';
																	echo '</tr>';
																	$i++;
																	$r+=$res5->nombre_point;
																	endwhile;
																	echo '</table>';

																	echo 'Nombre de points reçus : <b>'.$r.'</b>';

																else :
																	echo '<div class="alert alert-danger">Aucun échange trouvé</div>';
																endif;

															?>
														</div>
													</div>
												</div>

											</div>

											<?php
											else :
												echo '<div class="alert alert-danger">Aucun personnage trouvé</div>';
											endif;
											?>
										<?php endif; ?>
									</div>
									<!-- end widget content -->
									<div style="clear:both;"></div>
								</div>
							</div>
							
							<div style="clear:both;"></div>

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