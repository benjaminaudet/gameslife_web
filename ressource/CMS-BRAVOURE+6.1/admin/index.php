<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Accueil';
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
		<div id="main" role="main" style="padding:25px;">
			<div class="alert alert-danger">
				<b>ATTENTION</b> : Il est IMPORTANT de supprimer le compte par défaut !<br>
			</div>

			<?php $code = file_get_contents("http://samantcms.fr/maj/maj.html", true); ?>
				
				<div class="alert alert-success">
					<?php echo majCMS($code); ?>
				</div>




			<div class="jarviswidget jarviswidget-sortable col-sm-6">

			<header role="heading">
			<h2>Quelques statistiques</h2>
			</header>


			<div role="content">

				<div class="jarviswidget-editbox"></div>


				
				<div class="widget-body">
					<div id="chart_div" style="width: 600px; height: 400px;float:left;"></div> 
				</div>


			</div></div>





			<div class="jarviswidget jarviswidget-sortable col-sm-5" style="margin-left:25px;">

			<header role="heading">
			<h2>Derniers achats - Cette semaine : <?php achat_items_week($bdd); ?> achats</h2>
			</header>


			<div role="content">

				<div class="jarviswidget-editbox"></div>


				
				<div class="widget-body">
					
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>Joueur</th>
								<th>Offre</th>
								<th>Prix</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
	                    <?php 
	                        
			  			$h_minuit = date("H");
						$min_minuit = date("i");
						$N = date("N");
						$p1 = time() - ($h_minuit * 3600 + $min_minuit * 60 ) - ($N *3600*24);
						$p2 = time();
						$i = 1;
								
	                
	                    $requete = $bdd->prepare('SELECT * FROM historique WHERE date_achat BETWEEN "'.$p1.'" AND "'.$p2.'" ORDER BY id DESC limit 0,10');
	                    $requete->execute();
	                
	                            while($resultats = $requete->fetch(PDO::FETCH_OBJ))
	                            {		
	                                    $raq = $bdd->prepare("SELECT nom, prix, serveur FROM boutique WHERE id = '".$resultats->nom_offre."'");
	                                    $raq->execute();
	                                    $boutique=$raq->fetch();	
	                                    
										echo '<tr>';
											echo '<td>';
												echo '#'.$i;
											echo '</td>';
											echo '<td>';
												echo strtoupper($resultats->joueur);
											echo '</td>';
											echo '<td>';
												echo '<b>'.$boutique['nom'].'</b>';
											echo '</td>';
											echo '<td>';
												echo $boutique['prix']. ' points';
											echo '</td>';
											echo '<td>';
												echo 'le '.date('d/m/Y', $resultats->date_achat).' à '.date('H:i', $resultats->date_achat).'';
											echo '</td>';
										echo '</tr>';
										$i++;

	                            }

					?>


						</tbody>
					</table>
				</div>


			</div></div>



			<?php include 'inc/admin.php'; ?>

		</div>
		<!-- END MAIN PANEL -->

		<!--================================================== -->
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	      google.load("visualization", "1", {packages:["corechart"]});
	      google.setOnLoadCallback(drawChart);
	      function drawChart() {
	        var data = google.visualization.arrayToDataTable([
	          ['Task', 'Hours per Day'],
	          <?php 
	          statistiques_achats($bdd); 
	          ?>
	          ['',    0]
	        ]);

	        var options = {
	          title: 'Items les plus achetés'
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	        chart.draw(data, options);
	      }

	    </script>
		<?php include 'inc/footer.php'; ?>

	</body>

</html>
<?php
}
else
{
	
	echo '<meta http-equiv="refresh" content="0; URL=login.php">';
	exit;
}
?>
