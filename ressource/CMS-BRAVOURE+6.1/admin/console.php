<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  require_once '../configuration/configuration.php';
  set_session($bdd);
  $titre = 'Console';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
  	$TRUE = 1;
  	
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
										<?php
										if(isset($_POST['commande']))
										{
											$connexion_1->call("runConsoleCommand", array($_POST['commande']));

											echo '<div class="alert alert-success">Votre commande a bien été exécutée.</div>';
										}
										?>
										<div style="background:black; max-height: 500px;display: block;overflow:hidden;overflow-x: hidden;overflow-y: auto;overflow : -moz-scrollbars-vertical; padding:10px;">


										<?php
										if($TRUE == 1)
										{
											function translateMCColors($text) {
											    $dictionary = array(
											        '[30;22m' => '</span><span style="color: #000000;">', // §0 - Black
											        '[34;22m' => '</span><span style="color: #0000AA;">', // §1 - Dark_Blue
											        '[32;22m' => '</span><span style="color: #00AA00;">', // §2 - Dark_Green
											        '[36;22m' => '</span><span style="color: #00AAAA;">', // §3 - Dark_Aqua
											        '[31;22m' => '</span><span style="color: #AA0000;">', // §4 - Dark_Red
											        '[35;22m' => '</span><span style="color: #AA00AA;">', // §5 - Purple
											        '[33;22m' => '</span><span style="color: #FFAA00;">', // §6 - Gold
											        '[37;22m' => '</span><span style="color: #AAAAAA;">', // §7 - Gray
											        '[30;1m' => '</span><span style="color: #555555;">', // §8 - Dakr_Gray
											        '[34;1m' => '</span><span style="color: #5555FF;">', // §9 - Blue
											        '[32;1m' => '</span><span style="color: #55FF55;">', // §a - Green
											        '[36;1m' => '</span><span style="color: #55FFFF;">', // §b - Aqua
											        '[31;1m' => '</span><span style="color: #FF5555;">', // §c - Red
											        '[35;1m' => '</span><span style="color: #FF55FF;">', // §d - Light_Purple
											        '[33;1m' => '</span><span style="color: #FFFF55;">', // §e - Yellow
											        '[37;1m' => '</span><span style="color: #FFFFFF;">', // §f - White
											       
											        '[0;30;22m' => '</span><span style="color: #000000;">', // §0 - Black
											        '[0;34;22m' => '</span><span style="color: #0000AA;">', // §1 - Dark_Blue
											        '[0;32;22m' => '</span><span style="color: #00AA00;">', // §2 - Dark_Green
											        '[0;36;22m' => '</span><span style="color: #00AAAA;">', // §3 - Dark_Aqua
											        '[0;31;22m' => '</span><span style="color: #AA0000;">', // §4 - Dark_Red
											        '[0;35;22m' => '</span><span style="color: #AA00AA;">', // §5 - Purple
											        '[0;33;22m' => '</span><span style="color: #FFAA00;">', // §6 - Gold
											        '[0;37;22m' => '</span><span style="color: #AAAAAA;">', // §7 - Gray
											        '[0;30;1m' => '</span><span style="color: #555555;">', // §8 - Dakr_Gray
											        '[0;34;1m' => '</span><span style="color: #5555FF;">', // §9 - Blue
											        '[0;32;1m' => '</span><span style="color: #55FF55;">', // §a - Green
											        '[0;36;1m' => '</span><span style="color: #55FFFF;">', // §b - Aqua
											        '[0;31;1m' => '</span><span style="color: #FF5555;">', // §c - Red
											        '[0;35;1m' => '</span><span style="color: #FF55FF;">', // §d - Light_Purple
											        '[0;33;1m' => '</span><span style="color: #FFFF55;">', // §e - Yellow
											        '[0;37;1m' => '</span><span style="color: #FFFFFF;">', // §f - White
											       
											        '[5m' => '', // Obfuscated
											        '[21m' => '<b>', // Bold
											        '[9m' => '<s>', // Strikethrough
											        '[4m' => '<u>', // Underline
											        '[3m' => '<i>', // Italic
											       
											        '[0;39m' => '</b></s></u></i></span>', // Reset
											        '[0m' => '</b></s></u></i></span>', // Reset
											        '[m' => '</b></s></u></i></span>', // End
											    );
											 
											    $text = str_replace(array_keys($dictionary), $dictionary, $text);
											   
											    return '<span style="color: #BDBDBD;">'.$text;
											}
											 
											$msg = 250;
											$console = $connexion_1->call("getLatestConsoleLogsWithLimit", array(''.$msg.''));
											   
											$console = $console["success"];
											 
											$console = array_reverse($console);
											 
											$date = date("Y-m-d");
											 
												foreach ($console as $value) 
												{
												 
													$console = $value["line"];
													 
													$console = str_replace($date, '', $console);
													 
													$msg_prefix = array("[INFO]", "[WARNING]", "[SEVERE]");
													$color_prefix = array('<span style="color: #2E64FE;">[INFO]</span>', '<span style="color: #FF8000;">[WARNING]</span>', '<span style="color: #FF0040;">[SEVERE]</span>');
													$console = str_replace($msg_prefix, $color_prefix, $console);
													 

														echo '<div>';
														echo translateMCColors($console);
														echo '<br/></div>';
													
												 

												}
											}
											else
											{
												$show->showError("JSONAPI doit être activé.");
											}
										?>

									</div>

										<br>
										<form method="post" action="">
											<input class="form-control" placeholder="Saisissez votre commande" name="commande">
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