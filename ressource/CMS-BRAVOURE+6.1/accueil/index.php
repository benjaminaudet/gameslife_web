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

	   $titre = 'Accueil';
	  require_once ("../jointures/head.php");
	  require_once("../jointures/header.php");
	?>

	<section class="intro-block page-bg">
		  
		<div class="overlay default">
		
		  <div class="container">
			
			<div class="text-slider no-js">

			  <ul class="bxslider" id="text-slider" data-call="bxslider" data-options="parentSelector:'.text-slider', removeParentClass:'no-js', prevText:'', nextText:'', pager:true, controls:false, mode:'horizontal', auto:true, autoReload:true">
				<li>
				  <div class="slide">
					<h2>Rejoignez l'aventure dès maintenant !</h2>
				  </div>
				</li>
			  </ul>
			
			  <p class="meta"><?php echo $infoserveur; ?></p>
			  
			  <div>
				<?php if(!isset($_SESSION['utilisateur'])){?>
				<a href="../connexion/" class="scroll-to btn btn-primary"><i class="fa fa-unlock"></i>Connexion</a>
				<a href="../inscription/" class="scroll-to btn btn-white"><i class="fa fa-lock"></i>Inscription</a>
				<?php } else {?>
				<a href="../nous-rejoindre/" class="scroll-to btn btn-primary"><i class="fa fa-download"></i>Nous rejoindre</a>
				<?php }?>
					
			  </div>
				  
			</div>

		  </div>
			  
		</div>
			
	</section>


	<section class="content-block default-bg">
		  
		<div class="container">
		  <div class="row">
			  
			<div class="col-xs-12 col-sm-4 col-md-4">
			  <div class="service-box no-border tts-1">
				<i class="icon fa fa-rocket color-1-bg tts-1-target"></i>
				<h4 class="u-case"><?php echo $service1; ?></h4>
				<p><?php echo $infoservice1; ?></p>
			  
			  </div>
			  
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4">
			  <div class="service-box no-border tts-1">
				<i class="icon fa fa-apple color-1-bg tts-1-target"></i>
				<h4 class="u-case"><?php echo $service2; ?></h4>
				<p><?php echo $infoservice2; ?></p>
				
			  </div>
			</div>
				
			<div class="col-xs-12 col-sm-4 col-md-4">
			  <div class="service-box no-border tts-1">
				<i class="icon fa fa-download color-1-bg tts-1-target"></i>
				<h4 class="u-case"><?php echo $service3; ?></h4>
				<p><?php echo $infoservice3; ?></p>
				
			  </div>
			</div>

		  </div>
		   
		</div>
		  
	</section>
		  

	<section class="content-block page-bg dark-bg">
		  
		<div class="overlay default">
			
		  <div class="container">
			  
		  <div class="section-title">		
			<h2>Voter</h2>
			<div class="line color-1-bg"></div>
			<p>Voter et tentez de gagner pleins de cadeaux !</p>
			<br><br><br>
				<form action="../voter/traitement-vote.php" method="post">                  
					<div class="col-sm-8" style=" margin-left: 0px; ">               
						<?php
							if (isset($_SESSION['utilisateur']))
							{
							echo '<input class="form-control" type="text" placeholder="Votre pseudo" id="inputString" name="inputString" value="'.$_SESSION['utilisateur']['user_pseudo'].'" autocomplete="on"/>';
							}
							else
							{
							echo '<input class="form-control" type="text" placeholder="Votre pseudo" id="inputString" name="inputString" autocomplete="on"/>';
							}
						?>
					</div>
					<div class="col-sm-4">
					<button class="btn btn-primary btn-thicker space" type="submit"/>Continuer</button>
					</div>
				</form>
		  </div>
					
		  </div>
			
		</div>
			
	</section>

		  
	<section class="content-block default-bg">
	  
		<div class="container">
		
		  <div class="section-title">		
			<h2>Annonces et Nouveautés</h2>
			<div class="line color-1-bg"></div>
		  </div>

		    <?php
		
			  $query = $bdd->prepare ('SELECT * FROM news ORDER BY id DESC ');
			  $query->execute();	
				   
			  while($results = $query->fetch(PDO::FETCH_OBJ))
			  {		
			?>
			<article class="blog-entry">
				  
				<div class="meta">
				  <span class="name"><i class="fa fa-file"></i><a><?php echo stripcslashes ($results->titre); ?></a></span>
				  <span class="date"><i class="fa fa-calendar"></i><a><?php echo date('d/m/Y à H:i', $results->date); ?></a></span>
				  <span class="author"><i class="fa fa-user"></i><a>par <?php echo $results->auteur; ?></a></span>
				</div>
				<p><?php $texte = stripcslashes(smiley($results->texte)); ?><?php echo nl2br($texte); ?></p>
					
			</article>
			<?php
			  }

			?>

		</div>

	</section>


	<section class="content-block page-bg dark-bg">
 
		<div class="overlay default">
			
		  <div class="container">
		  
		  <div class="section-title">		
			<h2>Classement des votes</h2>
			<div class="line color-1-bg"></div>
			<p>Les meilleurs voteurs sont remercier à la fin du mois .</p>
		  </div>
				
			  <table class="table content-block default-bg">
				<thead>
				<tr>
				  <th><a>#</a></th>
				  <th><a>Pseudo</a></th>
				  <th><a>Votes</a></th>
				</tr>
				</thead>
				<tbody>
					<?php
						  $requete = $bdd->prepare ("SELECT * FROM joueurs ORDER BY vote DESC limit 5");
						  $requete->execute();
							$i = 1;
				  
						  while($resultats = $requete->fetch(PDO::FETCH_OBJ))
							{
					?>
				<tr>
				  <td><a><div id="<?php echo $i; ?>"> <?php echo $i; ?></div></a></td>
				  <td>
					<img src="https://minotar.net/avatar/<?php echo $resultats->user_pseudo; ?>/24.png" style="margin-right:25px; border-radius:5px;  box-shadow: 4px 4px 8px #555; max-width:24px ">
					<a href="../membres/membres.php?membre=<?php echo $resultats->user_pseudo; ?>" class="bouton"><?php echo $resultats->user_pseudo; ?></a>
				  </td>
				  <td><a><?php echo $resultats->vote; ?></a></td>
				</tr>
					<?php
					 $i++;
					 }
					?>
				</tbody>
			  </table> 
			  
		  </div>
		
		</div>
			
	</section>


	<section class="content-block default-bg">

		<div class="container">
			
		  <div class="section-title">		
			<h2><?php echo SITE; ?></h2>
			<div class="line"></div>
			<p><?php echo $descpa1; ?></p>
		  </div>

		  <div class="split-buttons">
			<?php if(!isset($_SESSION['utilisateur'])){?>
			<a href="../inscription/" class="btn btn-lg btn-primary">S'inscrire</a><a href="../connexion/" class="btn btn-lg btn-secondary">Se connecter</a>	
			<span>ou</span>
			<?php } else {?>
			<a href="../nous-rejoindre/" class="btn btn-lg btn-primary">Nous rejoindre</a><a href="../boutique/" class="btn btn-lg btn-secondary">Boutique</a>	
			<span>ou</span>
			<?php }?>
		  </div>
			
		</div>

	</section>
	  
    <div>
	<?php include '../jointures/footer.php'; ?>
	</div>