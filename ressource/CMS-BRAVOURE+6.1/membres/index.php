<?php
session_start();
 header('Content-type: text/html; charset=utf-8');
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');
  require_once('../configuration/configbravoure.php');
  require_once('../configuration/baseDonnees.php');
  require_once('../configuration/fonctions.php');
 	$titre = 'Mon compte';

	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section id="content" class="content-block default-bg">
        <div class="container">
      
		<?php
			if (isset($_SESSION['utilisateur']))
			{
				$pseudo = $_SESSION['utilisateur']['user_pseudo'];

				if(JSONAPI == 1)
				{
					$user = $connexion_1->getPlayer($_SESSION['utilisateur']['user_pseudo']);
					
					$health = $user['success']['health']*5;
					$food = $user['success']['foodLevel']*5;
					$exp_current = $user['success']['experience'];
					$level = $user['success']['level'];
					$exp_totale = 0;
					
						for($l = 0; $l <= $level; $l++){
							if($l >= 30){
								$exp_level = 62 + ($l - 30) * 7;
							}
							elseif($l >= 15){
								$exp_level = 17 + ($l - 15) * 3;
							}else{
								$exp_level = 17;
							}
							$exp_totale = $exp_totale + $exp_level;
						}
						
					$exp_percent = (($exp_level-($exp_totale-$exp_current))/$exp_level)*100;
					$gamemode = array(0 =>  'Survival', 1 => 'Creative', 2 => 'Adventure');
								
					$groupe = $connexion_1->call("permissions.getGroups", array("$pseudo"));
					$groupe = $groupe["success"]["0"];
								
					$nbr_money_server = $connexion_1->call("econ.getBalance", array("$pseudo"));
					$money = number_format($nbr_money_server["success"], 0, '.', ' ');
				}
				else
				{
					$level = 5;
					$health = 5;
					$food = 5;
					$exp_percent = 50;
					$groupe = 'JSONAPI est désactivé!';

				}

			?>
				<?php if($_SESSION['utilisateur']['reponse'] == '') {?>
					<?php
					if(isset($_POST['reponse_add']))
					{
						$reponse = htmlspecialchars($_POST['reponse_add']);

						$update = $bdd->prepare('UPDATE joueurs SET reponse = :reponse WHERE user_id = :user_id');
						$update -> bindParam(':reponse', $reponse);
						$update -> bindParam(':user_id', $_SESSION['utilisateur']['user_id']);	 
						$update -> execute();

						if($update->rowCount()==1)
						{
							$alert->showSuccess("Réponse ajoutée avec succès !");
						}
						
						$update->closeCursor();
					}
					?>
					<div class="alert alert-danger">
						<h4>Ajouter votre question secrète :</h4> <br>
						Vous n'avez pas de réponse secrète, veuillez remplir le formule ci-dessous.
						<form method="post" action="">
							<input type="text" name="reponse_add" class="" placeholder="Votre réponse secrète">
							<input type="submit" name="valider" class="btn btn-white">
						</form>

					</div>
				<?php } ?>


					<br>
					<div class="informations_compte">
		                <div class="health">
		                    <div class="current" style="width: <?php echo $health; ?>%"></div>
		                </div>
		                
		                <div class="level"><?php echo $level; ?></div>
		                
		                <div class="food">
		                    <div class="current" style="width: <?php echo $food; ?>%"></div>
		                </div>
		                
		                <div class="clear"></div>
		                
		                <div class="experience">
		                    <div class="current" style="width: <?php echo $exp_percent; ?>%"></div>
		                </div>
		            </div>
		            <br>

		            <center><img src="../ajax/skin.php?u=<?php echo $_SESSION['utilisateur']['user_pseudo']; ?>&s=400"/></center>
					
					
						 <?php
							if(isset($_POST['email_post']))
							{
								$_POST['email'] = htmlspecialchars($_POST['email']);
									if (checkmail_compte($_POST['email'], $bdd) == 0)
									{
										echo '<br /><div class="alert alert-danger fade in">Vous devez saisir votre nouvelle adresse e-mail.</div>';
									}
									elseif (checkmail_compte($_POST['email'], $bdd) == 1)
									{
										echo '<br /><div class="alert alert-danger fade in">Vous devez saisir une adresse e-mail correcte.</div>';
									}
									elseif (checkmail_compte($_POST['email'], $bdd) == 2)
									{
										echo '<br /><div class="alert alert-danger fade in">Votre adresse e-mail est d&eacute;j&agrave; utilis&eacute;.</div>';
									}
									else 
									{
											
										$update = $bdd->prepare('UPDATE joueurs SET user_mail = :new_mail WHERE user_mail = :mail_wh');
										$update -> bindParam(':new_mail', $_POST['email']);
										$update -> bindParam(':mail_wh', $_SESSION['utilisateur']['user_mail']);	 
										$update -> execute();
												
										echo '<br /><div class="alert alert-success fade in">Votre adresse e-mail a &eacute;t&eacute; modifi&eacute; avec succès.</div>';
									}
								}
										
								if(isset($_POST['pass_post']))
								{
									if (checkmdp(htmlspecialchars($_POST['pass'])) == 'empty')
									{
										echo '<br /><div class="alert alert-danger fade in">Vous devez saisir votre nouveau mot de passe.</div>';
									}
									elseif (checkmdp(htmlspecialchars($_POST['pass'])) == 'tooshort')
									{
										echo '<br /><div class="alert alert-danger fade in">Votre mot de passe doit contenir au moins 4 caractères.</div>';
									}
									elseif (checkmdp(htmlspecialchars($_POST['pass'])) == 'toolong')
									{
										echo '<br /><div class="alert alert-danger fade in">Votre mot de passe doit contenir au maximum 50 caractères.</div>';
									}
									elseif (checkmdp(htmlspecialchars($_POST['pass'])) == 'ok')
									{
										if(checkmdpS($_POST['pass'], $_POST['pass_c']) == 'different')
										{
											echo '<br /><div class="alert alert-danger fade in">Votre mot de passe n\'est pas identique &agrave; sa confirmation.</div>';
										}
										else
										{
										    $pass1 = htmlspecialchars($_POST['pass']);
											$update = $bdd->prepare('UPDATE joueurs SET user_mdp = :user_mdp WHERE user_mail = :mail_wh');
											$update -> bindParam(':user_mdp', md5($_POST['pass']));
											$update -> bindParam(':mail_wh', $_SESSION['utilisateur']['user_mail']);	 
											$update -> execute();
		
										echo '<br /><div class="alert alert-success fade in">Votre mot de passe a &eacute;t&eacute; modifi&eacute; avec succès.</div>';
										}
									}
								}
							?>

			    <ol class="breadcrumb">
		            <h3>Informations sur le jeu</h3><br>
		            <table width="100%" class="table table-hover">
		            
			            <tr>
				            <td>Banni : </td>
				            <td><?php if(JSONAPI == 1) echo ($user['success']['banned']==1)?'Oui':'Non';  ?></td>
			            </tr>
			                           
			                                  
			            <tr>
				            <td>Mode de jeu : </td>
				            <td><?php if(JSONAPI == 1) echo $gamemode[$user['success']['gameMode']]; ?></td>
			            </tr>
			                           
			            <tr>
				            <td>Grade : </td>
				            <td><?php if(JSONAPI == 1) echo $groupe; ?></td>
			            </tr>
		                           
			            <tr>
				            <td>Connecté : </td>
				            <td><?php if(JSONAPI == 1) echo ($user['success']['ip']=='offline')?'Non':'Oui'; ?></td>
			            </tr>
		                           
			            <tr>
				            <td>Monnaie : </td>
			            	<td><?php if(JSONAPI == 1) echo $money; ?></td>
			            </tr>
		                           
		            </table>

		        </ol>

		        <ol class="breadcrumb">                         
					<h3>Informations sur le compte</h3>
					
					<table width="100%" class="table table-hover">
						<tr>
							<td width="35%">Inscrit le :</td>
							<td><?php echo 'le '.date('d/m/Y à H:i', $_SESSION['utilisateur']['user_inscription']); ?></td>
						</tr>
		                           
						<tr>
							<td>Mes points :</td>
							<td> <?php echo $_SESSION['utilisateur']['user_points']; ?> 
							<img src="../img/gold.png"/>
							<div style="float:right; margin-top:0px; "><button class="btn btn-primary" type="submit" onclick='window.location.href="../credit/";'  style="cursor:pointer;"/>Recharger</button></div>
							</td>
						</tr>
		                           
						<tr>
							<td>Votes :</td>
							<td><?php echo $_SESSION['utilisateur']['vote']; ?></td>
						</tr>
		                           
						<tr>
							<td>Classement vote :</td>
							<td><?php echo rang_vote($bdd); ?></td>
						</tr>   
		                                       
						<tr>
							<td>Adresse e-mail :</td>
							<td><?php echo $_SESSION['utilisateur']['user_mail']; ?> <div style="float:right; margin-top:-4px;"><button class="btn btn-primary" data-toggle="modal" data-target="#email" style="cursor:pointer;"/>Modifier</button></div></td>
						</tr>               
		                           
						<tr>
							<td>Mot de passe :</td>
							<td>********** <div style="float:right;  margin-top:-4px;"><button class="btn btn-primary" data-toggle="modal" data-target="#pass" style="cursor:pointer;"/>Modifier</button></div></td>
						</tr>
						
						<tr>
							<td>Réponse secrète :</td>
							<td><?php echo $_SESSION['utilisateur']['reponse']; ?></td>
						</tr>

					</table>
					
			                        <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="email" aria-hidden="true">
 			                         <div class="modal-dialog">
 			                           <div class="modal-content">
  			                            <div class="modal-header">
   			                             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">&times;</span></button>
   			                             <h4 class="modal-title" >Modifier mon adresse E-mail</h4>
   			                           </div>
   			                           <div class="modal-body">
    			                            <center>
				                        	<form action="#" method="post">
				                        	<div class="col-md-6">
				                        		<input class="form-control required" type="text" name="email" size="30" placeholder="Nouvelle adresse e-mail" />
				                        	</div>
				                        	<div class="col-md-6">
				                        		<button class="btn btn-success" type="submit" name="email_post"/>Continuer</button>
				                        	</div>
				                        	</form>
				                        	</center>
				                        	<br><br><br>
    			                          </div>

  			                          </div>
			                          </div>
			                        </div>
			                        <div class="modal fade" id="pass" tabindex="-1" role="dialog" aria-labelledby="pass" aria-hidden="true">
 			                         <div class="modal-dialog">
  			                          <div class="modal-content">
 			                             <div class="modal-header">
 			                               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">&times;</span></button>
  			                              <h4 class="modal-title" >Modifier mon mot de passe</h4>
   			                           </div>
    			                          <div class="modal-body">
   			                             <center>
				                        	<form action="#" method="post">
				                        	<div class="col-md-6">
				                        		<input class="form-control required" type="password" name="pass" size="30" placeholder="Nouveau mot de passe" />
				                        		<br>
				                        		<input class="form-control required" type="password" name="pass_c" size="30" placeholder="Nouveau mot de passe" />
				                        	</div>
				                        	<div class="col-md-6">
				                        		<button class="btn btn-success" type="submit" name="pass_post"/>Continuer</button>
				                        	</div>
				                        	</form>
				                        	</center>
				                        	<br><br><br><br><br><br>
   			                           </div>

   			                         </div>
  			                        </div>
			                        </div>

		        </ol>

		        <ol class="breadcrumb">
				<h3>Historique des achat ( Boutique ) </h3>
								
		            <table width="100%" class="table">
			            <?php
						$requete = $bdd->prepare("SELECT * FROM historique WHERE joueur = '".$_SESSION['utilisateur']['user_pseudo']."' ORDER BY id ASC");
						$requete->execute();
						$i=1;
							$reponse=$requete->fetch();
							if ($reponse[0] > 0 ) 
							{ 
								while($resultats = $requete->fetch(PDO::FETCH_OBJ))
								{
				
								   echo '<tr>';
									echo '<td>'.historique_object($resultats->nom_offre, $bdd).'</td>';
									echo '<td>';
									echo 'à partir de : '.$resultats->adresse_ip.'';
									if ($_SERVER["REMOTE_ADDR"] == $resultats->adresse_ip)
									{
										echo '<br /> <font color="green">(depuis votre ordinateur)</font>';
									}
									else
									{
										echo '<br /> <font color="red">(depuis un autre ordinateur)</font>';
									}
									echo '</td>';
								   echo '</tr>';
							
								$i++;
								}
							}
							else
							{
								echo '<tr><td><div class="alert alert-warning">Aucun achat d\'item a été effectué.</div></tr></td>';
							}
											
						?>  
		        	</table>
	            </ol>

		        <ol class="breadcrumb">
				<h3>Historique des achats ( Points ) </h3>
				
		            <table width="100%" class="table ">
		                <?php
						$raq = $bdd->prepare("SELECT * FROM historique_credit WHERE joueur = '".$_SESSION['utilisateur']['user_pseudo']."' ORDER BY id ASC");
						$raq->execute();
						$i=1;
							$reponse1=$raq->fetch();
							if ($reponse1[0] > 0 ) 
							{ 
								while($resultats1 = $raq->fetch(PDO::FETCH_OBJ))
								{
			
								   echo '<tr>';
								   echo '<td width="5%">'.$i.'</td>';
									echo '<td>'.$resultats1->nom_offre.'</b></td>';
									echo '<td>le '.date("d-m-Y à H:i", $resultats1->date_achat).'</td>';
								
									echo '<td>';
									echo 'à partir de : '.$resultats1->adresse_ip.'';
									if ($_SERVER["REMOTE_ADDR"] == $resultats1->adresse_ip)
									{
										echo '<br /> <font color="green">(depuis votre ordinateur)</font>';
									}
									else
									{
										echo '<br /> <font color="red">(depuis un autre ordinateur)</font>';
									}
									echo '</td>';
								   echo '</tr>';
							
								$i++;
								}
							}
							else
							{
								echo '<tr><td><div class="alert alert-warning">Aucun achat de crédit a été effectué.</div></tr></td>';
							}
							
						?>  
		            </table>
		        </ol>

		        <ol class="breadcrumb">

		            <h3>Envoyer des points à un ami</h3>
		            <div id="points">
                     <div class="col-md-3 ">
                     </div>
                     <div class="col-md-6 ">
		              <form action="#" method="post">
		                <div class="col-md-6">
		                <div class="span4">
		                	<input class="form-control" type="text" name="pseudo_p" size="30" placeholder="Pseudonyme"> 
		            	</div>
                            <br>
		                <div class="span4">
		                	<input class="form-control" type="text" name="nbr_p" size="30" placeholder="Nombre de points"/> 
		            	</div>
						</div>
		                <div class="col-md-6">
						<br>
		                <button class="btn btn-success" type="submit" name="send_p">Confirmer</button>
                        </div>
		                <br/><br/>

		              </form>
					  </div>

		            </div>   
                    <br><br>
					<center><div class="col-md-3 "></div>
                    <div class="col-md-6 ">
								<?php
								if(isset($_POST['send_p']))
								{
								  $pseudo_p = htmlspecialchars($_POST['pseudo_p']);
								  $nbr_p = intval($_POST['nbr_p']);

					              $requete = $bdd->prepare('SELECT user_id FROM joueurs WHERE user_pseudo = :user_pseudo');
					              $requete->bindParam(':user_pseudo', $pseudo_p, PDO::PARAM_STR);
					              $requete->execute();
					          
					              if ($requete->rowCount() == 0)
					              {
					              	$show->showError("Le joueur n'existe pas.");
					              }
					              else
					              {
										$transfert = $bdd->prepare ("SELECT user_points FROM joueurs WHERE user_pseudo = :user_pseudo");
										$transfert->bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo']);
										$transfert->execute();

										$p1 = $transfert->fetch(PDO::FETCH_OBJ);

						                if(($p1->user_points >= $nbr_p) && ($nbr_p > 0))
						                {
							                  $time = time();
                                              $historique_echange = $bdd->prepare('INSERT INTO historique_echange(joueur, versjoueur, nombre_point, date_echange, adresse_ip) VALUES(:joueur, :versjoueur, :nombre_point, :date_echange, :adresse_ip)');
                                              $historique_echange -> bindParam(':joueur', $_SESSION['utilisateur']['user_pseudo'], PDO::PARAM_STR);
                                              $historique_echange -> bindParam(':versjoueur', $pseudo_p, PDO::PARAM_STR);
                                              $historique_echange -> bindParam(':nombre_point', $nbr_p, PDO::PARAM_STR);
                                              $historique_echange -> bindParam(':date_echange', $time, PDO::PARAM_STR);
                                              $historique_echange -> bindParam(':adresse_ip', $_SERVER["REMOTE_ADDR"]);
                                              $historique_echange -> execute();
                                              
                                              if($historique_echange->rowCount() == 1)
                                              {
                                                  $points_account = $p1->user_points - $nbr_p;
                                                  $_SESSION['utilisateur']['user_points'] = $points_account;

                                                  $update = $bdd->prepare('UPDATE joueurs SET user_points = :user_points WHERE user_pseudo = :user_pseudo');
                                                  $update -> bindParam(':user_points', $points_account);
                                                  $update -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo']);
                                                  $update -> execute();
                                                    
                                                    if($update->rowCount()==1)
                                                    {                
                                                      $update->closeCursor();

                                                      $update_2 = $bdd->prepare('UPDATE joueurs SET user_points = user_points + :user_points WHERE user_pseudo = :user_pseudo');
                                                      $update_2 -> bindParam(':user_points', $nbr_p);
                                                      $update_2 -> bindParam(':user_pseudo', $pseudo_p);
                                                      $update_2 -> execute();

                                                      $update_2->closeCursor();
                                                    }

                                                    $show->showSuccess('Les points ont bien été ajoutés au compte ciblé.');
                                                } 
                                                else 
                                                { 
                                                    $show->showEror('Problème lors du transfert.');
                                                }
						                }
						                else
						                {
						                	$show->showError('Impossible d\'effectuer cette transaction.');
						                    exit;
						                }

					                }
					    
					 			 }
					 			 ?>
					</div>
					</center>
				</ol>
		    <?php
			}
		    else
		   {
		   echo '<div class="bs-callout bs-callout-danger"><h4>Vous devez être connecté .</h4><p>Pour pouvoir accéder à cette page vous devez être connecté .</p><center><a type="button" class="btn btn-success" href="../connexion/"><i class="fa fa-unlock"></i>Connexion</a></center></div>';
		   }
		   ?>
	
	    </div>
    </section>

    <?php include '../jointures/footer.php'; ?>