<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Modifier les images';
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

/************************************************************
	 * Definition des constantes / tableaux et variables
	 *************************************************************/
	if(isset($_GET))
	{
		$nom_image = $_GET['nom'];
		if($_GET['dossier'] == 1) $dossier = '../images/';
		if($_GET['dossier'] == 2) $dossier = '../images/';
	}	 

	// Constantes
	define('TARGET', $dossier);    // Repertoire cible
	define('MAX_SIZE', 10000000);    // Taille max en octets du fichier
	define('WIDTH_MAX', 2500);    // Largeur max de l'image en pixels
	define('HEIGHT_MAX', 1500);    // Hauteur max de l'image en pixels
	 
	// Tableaux de donnees
	$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
	$infosImg = array();
	 
	// Variables
	$extension = '';
	$message = '';
	$nomImage = '';



	 
	/************************************************************
	 * Creation du repertoire cible si inexistant
	 *************************************************************/
	if( !is_dir(TARGET) ) {
	  if( !mkdir(TARGET, 0755) ) {
		exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
	  }
	}
	 
	/************************************************************
	 * Script d'upload
	 *************************************************************/
	if(!empty($_POST))
	{
	  // On verifie si le champ est rempli
	  if( !empty($_FILES['fichier']['name']) )
	  {
		// Recuperation de l'extension du fichier
		$extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
	 
		// On verifie l'extension du fichier
		if(in_array(strtolower($extension),$tabExt))
		{
		  // On recupere les dimensions du fichier
		  $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
	 
		  // On verifie le type de l'image
		  if($infosImg[2] >= 1 && $infosImg[2] <= 14)
		  {
			// On verifie les dimensions et taille de l'image
			if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
			{
			  // Parcours du tableau d'erreurs
			  if(isset($_FILES['fichier']['error']) 
				&& UPLOAD_ERR_OK === $_FILES['fichier']['error'])
			  {
				// On renomme le fichier
				$nomImage = $nom_image;
	 
				// Si c'est OK, on teste l'upload
				if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
				{
						
						
				  $message = '<div class="alert alert-success">Téléchargement réussi.</div>';

				}
				else
				{
				  // Sinon on affiche une erreur systeme
				  $message = '<div class="alert alert-danger">Problème lors de l\'upload !</div>';
				}
			  }
			  else
			  {
				$message = '<div class="alert alert-danger">Une erreur interne a empêché l\'uplaod de l\'image. </div>';
			  }
			}
			else
			{
			  // Sinon erreur sur les dimensions et taille de l'image
			  $message = '<div class="alert alert-danger">Erreur dans les dimensions de l\'image !</div>';
			}
		  }
		  else
		  {
			// Sinon erreur sur le type de l'image
			$message = '<div class="alert alert-danger">Le fichier à uploader n\'est pas une image !</div>';
		  }
		}
		else
		{
		  // Sinon on affiche une erreur pour l'extension
		  $message = '<div class="alert alert-danger">L\'extension du fichier est incorrecte !</div>';
		}
	  }
	  else
	  {
		// Sinon on affiche une erreur pour le champ vide
		$message = '<div class="alert alert-danger">Veuillez remplir le formulaire. </div>';
	  }
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
					                    <?php
					                  if( !empty($message) ) 
					                  {
					                    echo '<p>',"\n";
					                    echo "\t\t<strong>", $message ,"</strong>\n";
					                    echo "\t</p>\n\n";
					                  }
					                ?>
					                    <form enctype="multipart/form-data" action="?nom=<?php echo $nom_image;?>&dossier=<?php echo $_GET['dossier']; ?>" method="post" class="smart-form">
										    
					                        <div class="form-row">
					                          <label class="field-name" for="standard">Image <?php echo $dossier.$nom_image; ?>:</label>
					                          <div class="field">
					                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
					                            <input name="fichier" type="file" id="fichier_a_uploader" />
					                            <input type="submit" name="submit" value="Télécharger" class="button small-button button-blue" />
					                            
					                          </div>
					                        </div>


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