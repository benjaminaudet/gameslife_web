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

	$str=$bdd->prepare("SELECT * FROM boutique WHERE id = :id"); // on prépare notre requête
	$str->execute(array( 'id' => $_GET['id'] ));
	$resultats=$str->fetch(PDO::FETCH_OBJ);
?>

<script language="javascript">
	function request(url,cadre) {
		var XHR = null;

		if(window.XMLHttpRequest) // Firefox
			XHR = new XMLHttpRequest();
		else if(window.ActiveXObject) // Internet Explorer
			XHR = new ActiveXObject("Microsoft.XMLHTTP");
		else { 
			alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
			return;
		}
		XHR.open("GET",url, true);

		XHR.onreadystatechange = function attente() {

		if(XHR.readyState == 4)     {

		document.getElementById(cadre).innerHTML = XHR.responseText;
	   }
		}
		XHR.send(null);		
		return;
	}

	function ajax_boutique(){
	    // Create our XMLHttpRequest object
	    var hr = new XMLHttpRequest();
	    // Create some variables we need to send to our PHP file
	    var url = "AJAX_donnees_traitement.php";
		var nom = document.getElementById("nom").value;
	    var description = document.getElementById("description").value;
	    var prix = document.getElementById("prix").value;
	    var categorie = document.getElementById("categorie").value;
	    var commande = document.getElementById("commande").value;
	    var image = document.getElementById("image").value;
	    var ordre_id = document.getElementById("ordre_id").value;
	    var id = document.getElementById("id").value;
		
	    var vars = "nom="+nom+"&description="+description+"&prix="+prix+"&categorie="+categorie+"&commande="+commande+"&image="+image+"&ordre_id="+ordre_id+"&id="+id+"&action=edit";
	    hr.open("POST", url, true);
	    // Set content type header information for sending url encoded variables in the request
	    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    // Access the onreadystatechange event for the XMLHttpRequest object
	    hr.onreadystatechange = function() {
		    if(hr.readyState == 4 && hr.status == 200) {
			    var return_data = hr.responseText;
				document.getElementById("status").innerHTML = return_data;
		    }
	    }
	    // Send the data to PHP now... and wait for response to update the status div
	    hr.send(vars); // Actually execute the request
	    document.getElementById("status").innerHTML = "processing...";
	}

	</script>

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
				<br><article class="col-sm-6">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget jarviswidget-sortable">

								<header role="heading">
									<h2>Modifier boutique - <?php echo $resultats->id; ?></h2>
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
										<div id="status"></div>

										<form action="" class="smart-form" method="">
											<header>
												Remplissez le formulaire ci-dessous
											</header>

											<fieldset>

												<input name="id" id="id" value="<?php echo $resultats->id; ?>" style="display:none">

												<section>
													<label class="label">Nom</label>
													<label class="input">
														<input type="text" class="span12" value="<?php echo htmlspecialchars_decode($resultats->nom); ?>"  id="nom" name="nom">
													</label>
												</section>

												<section>
													<label class="label">Description</label>
													<label class="input">
														<textarea class="span12" name="description" id="description" style="width:650px; height:150px; padding:5px"><?php echo htmlspecialchars_decode($resultats->description); ?></textarea>
													</label>
												</section>

												<section>
													<label class="label">Prix</label>
													<label class="input">
														<input type="text" class="span12" value="<?php echo $resultats->prix; ?>" name="prix" id="prix" placeholder="">
													</label>
												</section>

												<section>
													<label class="label">Catégorie</label>
													<label class="input">
														<input type="text" class="span12" value="<?php echo $resultats->categorie; ?>" name="categorie" id="categorie" placeholder="">
													</label>
												</section>

												<section>
													<label class="label">Commande</label>
													<label class="input">
														<input type="text" class="span12" value="<?php echo $resultats->commande; ?>" name="commande" id="commande"  placeholder="">
													</label>
												</section>

												<section>
													<label class="label">Image</label>
													<label class="input">
														<input name="image" value="<?php echo $resultats->image; ?>" class="span12" type="text" id="image" placeholder="">
													</label>
												</section>

												<section>
													<label class="label">Image</label>
													<label class="input">
														<input name="ordre_id" value="<?php echo $resultats->ordre_id; ?>" class="span12" type="text" id="ordre_id">
													</label>
												</section>

											</fieldset>


											</fieldset>

											<footer>
												<div href="" class="btn btn-primary" name="submit" onClick="javascript:ajax_boutique();">Sauvegarder</div>

												<button type="button" class="btn btn-default" onclick="window.history.back();">
													Retour
												</button>
											</footer>

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