<?php
@session_start();
 header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');

	$titre = 'Se connecter';
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section class="content-block default-bg">
      
        <div class="container">
        
          <div class="form-block clearfix">
                
            <div class="pull-left col"> 
              <h4><i class="fa fa-lock"></i></i>Nouveau ?</h4>
              <p>Vous n'êtes pas encore inscrit ? Inscrivez vous dès maintenant !</p>
              <a href="../inscription/" class="btn btn-default">S'inscrire</a>
            </div>
			<?php 
			if (isset($_POST['login']) && isset($_POST['password']))
			{
				$login = htmlspecialchars($_POST['login']);
				$password = htmlspecialchars($_POST['password']);
				$banni = false;
				
					$requete = $bdd->prepare('SELECT COUNT(*) FROM joueurs WHERE user_pseudo = :user_pseudo');
					$requete->bindParam(':user_pseudo', $login, PDO::PARAM_STR);
					$requete->execute();
					$nombreDeLignes = $requete->fetch(); 

					if ($nombreDeLignes[0] == 0)
					{
						$login_p = false;
					}
					else
					{
							
						$login_p = true;
						
						$requete = $bdd->prepare('SELECT * FROM joueurs WHERE user_pseudo = :user_pseudo');
						$requete->bindParam(':user_pseudo', $login, PDO::PARAM_STR);
						$requete->execute();
						$reponse = $requete->fetch();
							
						if (md5($password) == $reponse['user_mdp'])
						{
							if($reponse['user_banni'] == 1) 
							{
								$banni = true;
							}
							else
							{
								$password_p = true;
								$banni = false;

								if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
						        {  
						         $HTTP_CLIENT_IP = $_SERVER['HTTP_X_FORWARDED_FOR'];  
						        }  
						        elseif(isset($_SERVER['HTTP_CLIENT_IP'])) 
						        {  
						         $HTTP_CLIENT_IP = $_SERVER['HTTP_CLIENT_IP'];  
						        }  
						        else 
						        {  
						         $HTTP_CLIENT_IP = $_SERVER['REMOTE_ADDR'];  
						        }  

						        if($HTTP_CLIENT_IP == "::1") $HTTP_CLIENT_IP = "127.0.0.1";

						        if ($_SERVER['QUERY_STRING'] == "") 
						        {  
						         $PHP_SELF = $_SERVER['PHP_SELF'];  
						        }  
						        else 
						        {  
						         $PHP_SELF = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];  
						        }  
						        
						        $PAYS_SELF = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
						        $PAYS_SELF = $PAYS_SELF{0}.$PAYS_SELF{1};

						        $HTTP_TIME = time();

								$_SESSION['utilisateur'] = $reponse;
						        $statistiques = $bdd->prepare('INSERT INTO logs(user_id, log_ip, log_timestamp, log_country) VALUE (:user_id, :log_ip, :log_timestamp, :log_country)');
						        $statistiques -> bindParam(':user_id', $_SESSION['utilisateur']['user_id']);
						        $statistiques -> bindParam(':log_ip', $HTTP_CLIENT_IP);
						        $statistiques -> bindParam(':log_timestamp', $HTTP_TIME);
						        $statistiques -> bindParam(':log_country', $PAYS_SELF);
						        $statistiques -> execute(); 

							}
						}
						else
						{
							$password_p = false;
						}
								
					$requete->closeCursor();	
					}

				if($banni == false)
				{
					if ($login_p == true  && $password_p == true)  $show->showSuccess('<a href="../accueil/">Continuer</a> <meta http-equiv="refresh" content="0;URL=../accueil/">');
					if ($login_p == false OR $password_p == false) $show->showError('Connexion refusée');
				}
				else
				{
					$show->showError("Vous êtes bannis.");
				}
			}
			?>	

		    <form id="signup" class="form-horizontal" method="post" action="#">
            <div class="pull-right col"> 
                <h4><i class="fa fa-user"></i></i>Connexion</h4>
                <input type="text" id="email" name="login"  placeholder="Pseudo" class="form-control">
                <input type="password" name="password" id="passwd" placeholder="Mot de passe" class="form-control">
                <div class="checkbox space-b">
                  <label>
                    <input type="checkbox"> Rester connecté
                  </label>
                </div>
			    <button type="submit" class="btn btn-primary"><i class="icon-signin"></i> Se connecter</button>
            </div>
			</form>
			
		  </div>
      
        </div>

    </section>
	
    <?php include '../jointures/footer.php'; ?>