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

				<article class="col-sm-9">
					<?php include 'doc/situation.php'; ?>

						<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

								<header role="heading">
									<h2>Modifier un sujet</h2>
								</header>

								<!-- widget div-->
								<div role="content">

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									<div class="widget-body padding">
						                <?php
						                $id_topic = intval($_GET['id']);

										if(isset($_POST['submit']))
										{
											if(isset($_POST['texte']) && isset($_POST['titre']))
											{
												$date = time();
													
													$update = $bdd->prepare('UPDATE topics SET titre = :titre, texte = :texte WHERE id = :id');
													$update -> bindParam(':titre', $_POST['titre']);
													$update -> bindParam(':texte', $_POST['texte']);
													$update -> bindParam(':id', $id_topic);
													$update -> execute();


													$show->showSuccess("Nouvelle modifiée avec succès.");

												}
											
											else
											{
												$show->showError("Vous devez remplir tous les champs.");
											}
										}
													
											$req = $bdd->prepare("
												SELECT 
													DISTINCT(ts.id),
													ts.*,
													us.user_pseudo

												FROM 
													topics ts 
													LEFT JOIN joueurs us ON us.user_id = ts.user_id 
												WHERE id = :id
											");
											$req -> execute(array( 'id' => $id_topic));
											$topic = $req->fetch(PDO::FETCH_OBJ);

										?>
						                           
						                            
						                            
													<form action="#" method="post" class="smart-form" onsubmit="editor.post()" >
															<legend>Détaillez la nouvelle que vous voulez modifier </legend>	
															<br>					                                    
															

																<section>
																	<label class="input">
																		<input type="text" name="auteur" value="<?php echo stripcslashes($topic->user_pseudo);  ?>" disabled>
																	</label>
																</section>

																<section>
																	<label class="input">
																		<input type="text" name="titre" value="<?php echo stripcslashes($topic->titre); ?>">
																	</label>
																</section>

						                                    		
						                                    
						                                <div class="box-content box-nomargin">
						                                	<textarea id="tinyeditor" style="width: 400px; height: 200px" name="texte"><?php echo stripcslashes($topic->texte); ?></textarea>
						                                </div>

									                                    
														<footer>
															<input type="submit" class="btn btn-primary" value="Modifier la nouvelle" name="submit">

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