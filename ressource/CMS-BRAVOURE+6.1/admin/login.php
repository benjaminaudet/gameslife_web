<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  $titre = 'Accueil';
  //----------------------------------//

  require 'inc/head.php';
  echo '<link rel="stylesheet" type="text/css" media="screen" href="css/lockscreen.css">';
  ?>
	<body>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->

					<form class="lockscreen animated flipInY" action="" method="post">
					<?php
				    if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['captcha']))
				    {
				         if($_POST['captcha'] == $_SESSION['captcha'])
				                            {
					        // Login paramètres
					        $login = htmlspecialchars($_POST['login']);
					        // Password paramètres
					        $password = htmlspecialchars($_POST['password']);
				        
				            // etape 1		
				            $requete = $bdd->prepare('SELECT COUNT(id) FROM admin WHERE pseudo = :login');
				            $requete->bindParam(':login', $login, PDO::PARAM_STR);
				            $requete->execute();
				            $nombreDeLignes = $requete->fetch(); 
				    
				        if ($nombreDeLignes[0] == 0)
				        {
				            $login_p = false;
				        }
				        else
				        {
				            $login_p = true;
				            
				            $requete = $bdd->prepare('SELECT * FROM admin WHERE pseudo = :login');
				            $requete->bindParam(':login', $login, PDO::PARAM_STR);
				            $requete->execute();
				            $reponse = $requete->fetch();
				                
				            if (md5($password) == $reponse['mdp'])
				            {
				                $password_p = true;
				                $_SESSION['admin'] = $reponse;
				            }
				            else
				            {
				                $password_p = false;
				            }
				        }
				            if ($login_p == true  && $password_p == true) 
				            { 
				                echo '<div class="alert alert-success"><strong>Succès!</strong> Connexion en cours...</div> <meta http-equiv="refresh" content="2; URL=index.php">'; 
				            }
				            if ($login_p == false OR $password_p == false) echo '<div class="alert alert-danger "><strong>Erreur!</strong> Connexion refusée.</div>';
				            
				        }
				        else
				        {
				            echo '<div class="alert alert-danger"><strong>Erreur!</strong> Captcha invalide.</div>';
				        }
				    }
				        else
				        {
				            $_SESSION['captcha'] = ChiffreAleatoire(5);
				        }
				    ?>
						<div class="logo">
							<h1 class="semi-bold">Panel admin</h1>
						</div>
						<div>
							<img src="img/avatars/whois.png" alt="" width="120" height="120" />
							<div>
								<h1>
									Connectez-vous
								</h1>


								<div class="input-group">
									<input class="form-control" type="text" placeholder="Nom du compte" name="login">
									<br><br>
									<input class="form-control" type="password" placeholder="Password" name="password">
									<br><br>
									<div id="resultatAppel" style="display:inline;"><img src="captcha/captcha.png.php?PHPSESSID=<?php echo session_id(); ?>"/>  
		        			        <input type="text" name="captcha" id="captcha" maxlength="6" style="width:185px;" class="form-control" placeholder="Recopiez le captcha">
								</div>
								<br><br>
								<div class="input-group">
									<button type="submit" class="btn btn-labeled btn-success">
										<span class="btn-label"><i class="fa fa-check-square-o"></i></span> Se connecter
									</button>
								</div>

							</div>

						</div>
						<br>
					</form>

		</div>

		<?php include 'inc/footer.php'; ?>

	</body>

</html>