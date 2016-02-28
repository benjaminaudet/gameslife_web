<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Gérer les images';
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
			<article style="margin:10px;">
				<div class="superbox">
					<?php include 'doc/situation.php'; ?>
					<?php
				   //nom du répertoire contenant les images à afficher
				   $nom_repertoire = '../images/uploads/';
				 
				   //on ouvre le repertoire
				   $pointeur = opendir($nom_repertoire);
				   $i = 0;
				 
				   //on les stocke les noms des fichiers des images trouvées, dans un tableau
				   while ($fichier = readdir($pointeur))
				   {      
				      if (substr($fichier, -3) == "gif" || substr($fichier, -3) == "jpg" || substr($fichier, -3) == "png" 
				  || substr($fichier, -4) == "jpeg" || substr($fichier, -3) == "PNG" || substr($fichier, -3) == "GIF" 
				|| substr($fichier, -3) == "JPG")
				      {
				         $tab_image[$i] = $fichier;
				         $i++;      
				      }      
				   }
				 
				   //on ferme le répertoire
				   closedir($pointeur);
				 
				   //on trie le tableau par ordre alphabétique
				   array_multisort($tab_image, SORT_ASC);
				 
				        //affichage des images (en 60 * 60 ici)
				   for ($j=0;$j<=$i-1;$j++)
				   {
				      $image = '<a href="http://'.$dom.'/images/uploads/'.$tab_image[$j].'" target="_blank"><img src="'.$nom_repertoire.'/'.$tab_image[$j].'" class="superbox-img" width="250" height="150"></a>';
				 
				      echo '<div class="superbox-list">';
				            echo $image;
				            echo $tab_image[$j];
				            
				      echo '</div>';
				   } 
				?>
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