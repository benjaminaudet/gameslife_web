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

                if (isset($_POST['pseudo']))
                {

                        $_SESSION['erreurs'] = 0;
                         
                        //user_pseudo
                        if(isset($_POST['pseudo']))
                        {
                            $pseudo = trim($_POST['pseudo']);
                            $pseudo = htmlentities($pseudo, ENT_NOQUOTES, 'utf-8');
                            $pseudo = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $pseudo);
                            $pseudo = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $pseudo); // pour les ligatures e.g. '&oelig;'
                            $pseudo = preg_replace('#&[^;]+;#', '', $pseudo); // supprime les autres caractères
                            $pseudo = str_replace(';', '', $pseudo); // supprime les autres caractères
                            $pseudo = str_replace(' ', '', $pseudo); // supprime les autres caractères
                            $pseudo = str_replace('php', '', $pseudo); // supprime les autres caractères
                            $user_pseudo_result = checkuser_pseudo($pseudo, $bdd);
                            if($user_pseudo_result == 'tooshort')
                            {
                                $_SESSION['pseudo_info'] = '- Le pseudo '.htmlspecialchars($pseudo, ENT_QUOTES).' est trop court.<br/>';
                                $_SESSION['form_pseudo'] = '';
                                $_SESSION['erreurs']++;
                            }
                             
                            else if($user_pseudo_result == 'toolong')
                            {
                                $_SESSION['user_pseudo_info'] = '- Le pseudo '.htmlspecialchars($pseudo, ENT_QUOTES).' est trop long.<br/>';
                                $_SESSION['form_user_pseudo'] = '';
                                $_SESSION['erreurs']++;
                            }
                             
                            else if($user_pseudo_result == 'exists')
                            {
                                $_SESSION['user_pseudo_info'] = '- Le pseudo '.htmlspecialchars($pseudo, ENT_QUOTES).' est d&eacute;jà pris.<br/>';
                                $_SESSION['form_user_pseudo'] = '';
                                $_SESSION['erreurs']++;
                            }

                            else if($user_pseudo_result == 'ok')
                            {
                                $_SESSION['user_pseudo_info'] = '';
                                $_SESSION['form_user_pseudo'] = $pseudo;
                            }
                             
                            else if($user_pseudo_result == 'empty')
                            {
                                $_SESSION['user_pseudo_info'] = '- Vous devez entrer un pseudo.<br/>';
                                $_SESSION['form_user_pseudo'] = '';
                                $_SESSION['erreurs']++; 
                            }
                        }
                         
                        else
                        {
                            header('Location: ../index.php');
                            exit();
                        }
                         
                        //Mot de user_mdpe
                        if(isset($_POST['mdp']))
                        {
                            $mdp = trim($_POST['mdp']);
                            $mdp_result = checkmdp($mdp, '');
                            if($mdp_result == 'tooshort')
                            {
                                $_SESSION['mdp_info'] = '- Le mot de passe entr&eacute; est trop court.<br/>';
                                $_SESSION['form_mdp'] = '';
                                $_SESSION['erreurs']++;
                            }
                             
                            else if($mdp_result == 'toolong')
                            {
                                $_SESSION['mdp_info'] = '- Le mot de passe entr&eacute; est trop long.<br/>';
                                $_SESSION['form_mdp'] = '';
                                $_SESSION['erreurs']++;
                            }
                                 
                            else if($mdp_result == 'ok')
                            {
                                $_SESSION['mdp_info'] = '';
                                $_SESSION['form_mdp'] = $mdp;
                            }
                             
                            else if($mdp_result == 'empty')
                            {
                                $_SESSION['mdp_info'] = '- Vous devez entrer un mot de passe.<br/>';
                                $_SESSION['form_mdp'] = '';
                                $_SESSION['erreurs']++;
                         
                            }
                        }
                         
                        else
                        {
                            header('Location: ../index.php');
                            exit();
                        }
                         
                        //Mot de user_mdpe suite
                        if(isset($_POST['mdp_verif']))
                        {
                            $mdp_verif = trim($_POST['mdp_verif']);
                            $mdp_verif_result = checkmdpS($mdp_verif, $mdp);
                            if($mdp_verif_result == 'different')
                            {
                                $_SESSION['mdp_verif_info'] = '- Le mot de mot de passe de v&eacute;rification est diff&egrave;re.<br/>';
                                $_SESSION['form_mdp_verif'] = '';
                                $_SESSION['erreurs']++;
                                if(isset($_SESSION['form_mdp'])) unset($_SESSION['form_mdp']);
                            }
                             
                            else
                            {
                                if($mdp_verif_result == 'ok')
                                {
                                    $_SESSION['form_mdp_verif'] = $mdp_verif;
                                    $_SESSION['mdp_verif_info'] = '';
                                }
                                 
                                else
                                {
                                    $_SESSION['mdp_verif_info'] = str_replace('mot de passe', ' mot de passe de v&eacute;rification', $_SESSION['mdp_info']);
                                    $_SESSION['form_mdp_verif'] = '';
                                    $_SESSION['erreurs']++;
                                }
                            }
                        }
                         
                        else
                        {
                            header('Location: ../index.php');
                            exit();
                        }
                         
                        //mail
                        if(isset($_POST['mail']))
                        {
                            $mail = trim($_POST['mail']);
                            $mail_result = checkmail($mail, $bdd);
                            if($mail_result == 'isnt')
                            {
                                $_SESSION['mail_info'] = '- Le mail n\'est pas valide.<br/>';
                                $_SESSION['form_mail'] = '';
                                $_SESSION['erreurs']++;
                            }
                             
                            else if($mail_result == 'exists')
                            {
                                $_SESSION['mail_info'] = '- Le mail est d&eacute;jà utilis&eacute;<br/>';
                                $_SESSION['form_mail'] = '';
                                $_SESSION['erreurs']++;
                            }
                                 
                            else if($mail_result == 'ok')
                            {
                                $_SESSION['mail_info'] = '';
                                $_SESSION['form_mail'] = $mail;
                            }
                             
                            else if($mail_result == 'empty')
                            {
                                $_SESSION['mail_info'] = '- Vous devez entrer un mail.<br/>';
                                $_SESSION['form_mail'] = '';
                                $_SESSION['erreurs']++; 
                            }
                        }
                         
                        else
                        {
                            header('Location: ../index.php');
                            exit();
                        }
                         
                        //mail suite
                        if(isset($_POST['mail_verif']))
                        {
                            $mail_verif = trim($_POST['mail_verif']);
                            $mail_verif_result = checkmailS($mail_verif, $mail);
                            if($mail_verif_result == 'different')
                            {
                                $_SESSION['mail_verif_info'] = 'Le mail de v&eacute;rification diff&egrave;re du mail.<br />';
                                $_SESSION['form_mail_verif'] = '';
                                $_SESSION['erreurs']++;
                            }
                             
                            else
                            {
                                if($mail_result == 'ok')
                                {
                                    $_SESSION['mail_verif_info'] = '';
                                    $_SESSION['form_mail_verif'] = $mail_verif;
                                }
                                 
                                else
                                {
                                    $_SESSION['mail_verif_info'] = '- Vous devez entrer le mail de vérification.<br/>';
                                    $_SESSION['form_mail_verif'] = '';
                                    $_SESSION['erreurs']++;
                                }
                            }
                        }
                         
                        else
                        {
                            header('Location: ../index.php');
                            exit();
                        }
						
                        // Réponse
                        if(isset($_POST['reponse']) && !empty($_POST['reponse']))
                        {
                            $reponse = htmlspecialchars($_POST['reponse']);
                        }
                        else
                        {
                            $_SESSION['reponse_nfo'] = '- Vous devez saisir une réponse secrète au cas où si vous oubliez votre mot de passe <br>';
                            $_SESSION['erreurs']++;
                        }                         



					if($_SESSION['erreurs'] == 0)
					{
						$md5 = md5($mdp);
						$time = time();   

						$req = $bdd->prepare('INSERT INTO joueurs(user_pseudo, user_mdp, user_mail, user_inscription, reponse) 
                                              VALUES(:user_pseudo, :user_mdp, :user_mail, :user_inscription, :reponse)');
						$req -> bindParam(':user_pseudo', $pseudo, PDO::PARAM_STR);
						$req -> bindParam(':user_mdp', $md5, PDO::PARAM_STR);
						$req -> bindParam(':user_mail', $mail, PDO::PARAM_STR);
						$req -> bindParam(':user_inscription', $time, PDO::PARAM_STR);
                        $req -> bindParam(':reponse', $reponse, PDO::PARAM_STR);
						$req -> execute();
							
                        echo '<div class="bs-callout bs-callout-info"><h4>Inscription validée</h4><p>Vous pouvez désormais vous connecter avec vos identifiants.</p></div>';
					}
					else
					{
						if($_SESSION['erreurs'] == 1) $_SESSION['nb_erreurs'] = '<b>Il y a eu 1 erreur :</b>';
						else $_SESSION['nb_erreurs'] = '<b>Il y a eu '.$_SESSION['erreurs'].' erreurs.</b><br />';
					    
                            $msg_erreur = $_SESSION['nb_erreurs']. '';
                            $msg_erreur .= $_SESSION['user_pseudo_info'];
                            $msg_erreur .= $_SESSION['mdp_info'];
                            $msg_erreur .= $_SESSION['mdp_verif_info'];
                            $msg_erreur .= $_SESSION['mail_info'];
                            $msg_erreur .= $_SESSION['mail_verif_info'];
                            $msg_erreur .= $_SESSION['reponse_nfo'];

                            $show->showError($msg_erreur);
			     			
		           }

}
?>