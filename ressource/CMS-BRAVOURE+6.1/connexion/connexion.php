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

if (isset($_POST['login']) && isset($_POST['password']))
{
	$login = htmlspecialchars($_POST['login']);
	$password = htmlspecialchars($_POST['password']);
	
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
				$password_p = true;
				$_SESSION['utilisateur'] = $reponse;
			}
			else
			{
				$password_p = false;
			}
					
		$requete->closeCursor();	
		}

	if ($login_p == true  && $password_p == true)  $show->showSuccess('<a href="../accueil/">Continuer</a> <meta http-equiv="refresh" content="0;URL=../accueil/">');
	if ($login_p == false OR $password_p == false) $show->showError('Connexion refusée');
}
?>