<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<?php
@session_start();
 ('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');

	$titre = 'Support';
	$_SESSION['captcha'] = ChiffreAleatoire(5);

	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section class="content-block default-bg">

	    <div class="container">

          <div class="section-title">		
            <h2>Support</h2>
            <div class="line"></div>
            <p>Un problème ? Contactez le support ! .</p>
          </div>                   
 				
				<?php
				if(isset($_POST['envoyer']))
				{
				// POSTS
				  $name = htmlspecialchars($_POST['pseudo']);
				  $objet = htmlspecialchars($_POST['objet']);
				  $message = htmlspecialchars($_POST['message']);
				  $email = htmlspecialchars($_POST['mail']);
				  $captcha = htmlspecialchars($_POST['captcha']);
				  
				// VARIABLES
				      $nbr_error = 0;
					  $msg_error = '';
					// FONCTIONS
					function nbr_error($i)
					{
						if($i <= 1)
						{
							return 'erreur';
						}
						else
						{
							return 'erreurs';	
						}
					}		
							
					// etape 1 - vérification du nom et prénom
					if((strlen($name) >= 4) && (strlen($name) < 50))
					{
						$error = true;
					}
					else
					{
						$error = false;	
						$nbr_error++;
						$msg_error .= 'Pseudonyme invalide (entre 4 et 50 caractères).<br>';
					}
					
					// etape 1-2 - vérification du nom et prénom
					if((strlen($objet) >= 4) && (strlen($objet) < 50))
					{
						$error = true;
					}
					else
					{
						$error = false;	
						$nbr_error++;
						$msg_error .= 'Objet invalide (entre 4 et 50 caractères).<br>';
					}

					// etape 2 - vérification du message
					if((strlen($message) >= 4) && (strlen($message) < 1000))
					{
						$error = true;
					}
					else
					{
						$error = false;	
						$nbr_error++;
						$msg_error .= 'Message invalide (entre 4 et 1000 caractères).<br>';
					}
					
					// etape 3- vérification de l'adresse email
					if((strlen($email) >= 4) && (strlen($email) < 100))
					{
						if(preg_match('#^[a-z0-9._-]+@hotmail|live|gmail|msn|laposte|yahoo|orange|wanadoo|free|sfr\.[a-z]{2,4}$#is', $email))
						{
							$error = true;
						}
						else
						{
							$error = false;	
							$nbr_error++;
							$msg_error .= 'Adresse email invalide.<br />';
						}
					}
					else
					{
						$error = false;	
						$nbr_error++;
						$msg_error .= 'Adresse email invalide.<br />';
					}
					
					if($_POST['captcha'] == $_SESSION['captcha'] && isset($_POST['captcha']) && isset($_SESSION['captcha']))
					{
						$error = true;
					}

					else
					{
						$msg_error .= 'Vous n\'avez pas recopié correctement le contenu de l\'image.<br />';
						$error = false;	
						$nbr_error++;
					}

					if($error == true)
					{
					  if($_SESSION['envoyer'] == false)
					  {
					   $_SESSION['envoyer'] = true;
						
						$show->showSuccess('Le message a été envoyé avec succès.');
						$time = time();
						email ($name, $objet, $message, $email);
					  }
					  else
					  {
						$show->showError('Le message a déjà été envoyé.');
					  }

					}
					else
					{
						echo '<div class="alert alert-danger">'; 
						echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
						echo 'Il y a <b>'.$nbr_error.' '.nbr_error($nbr_error).'</b> : <br>'.$msg_error.'</div>';	
					}
				}
				?>
							
            <form  method="post" action="">		
              <div class="contact-form">
                <div class="clearfix">
                  <div class="pull-left col">
                    <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Peudo">
                    <input type="text" name="objet" id="objet" class="form-control" placeholder="Objet du message">
                  </div>
                  
                  <div class="pull-right col">
                    <input type="text" name="mail" id="mail" class="form-control" placeholder="E-mail">
                    <input type="text" name="captcha" id="captcha" maxlength="6" class="form-control" placeholder="Captcha , Génération du captcha en bas du bouton Envoyer">
                  </div>
                  
                </div>
                  
                <textarea name="message" id="message_1" class="form-control" placeholder="Votre message ..."></textarea>
                <button type="submit" name="envoyer" class="btn btn-primary">Envoyer<i class="fa fa-chevron-circle-right"></i></button>
              </div>
			  <br><br>
			  <center>
                <div class="side-info">
				<p>Captcha</p>
				<div id="resultatAppel">
						<img src="../captcha/captcha.png.php?PHPSESSID=<?php echo session_id(); ?>"/>  
				</div>
				<p><small>Vous devez , pour envoyer un message , remplir le captcha en rentrant ce texte dans la case Captcha .</small></p>
				</div>
			  </center>
			</form>

	    </div>			
    </section>
	
    <div class="footer-copyright"> 
	    <?php include '../jointures/footer.php'; ?>
	</div>