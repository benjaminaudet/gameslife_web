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

	$titre = 'Page';
	

	$requete = $bdd->prepare("SELECT DISTINCT(titre) FROM pages");
	$requete->execute();

	while($resultats = $requete->fetch(PDO::FETCH_OBJ))
	{
	   if(isset($_GET['titre']) && !empty($_GET['titre']))
	   {
	      if(Slug($resultats->titre) == $_GET['titre'])
	      {
	        $titre_categorie = htmlspecialchars($resultats->titre);
	        $titre = $titre_categorie;
	      }
	  }
	}
	$requete->closeCursor();

	require_once ("../jointures/head.php");
	require_once("../jointures/header.php");
?>
    <section class="content-block default-bg">
      
        <div class="container">
		
        <div class="row">
		  
          <div class="section-title">		
            <h2><?php echo $titre; ?></h2>
            <div class="line"></div>
          </div>
		  
				<?php
					echo '<div>';
						if(isset($titre_categorie) && !empty($titre_categorie))
						{
						$requete = $bdd->prepare ("SELECT * FROM pages WHERE titre LIKE '%".$titre_categorie."%'");
						$requete->execute();	

						if($requete->rowCount() == 1)
						{
							$resultats = $requete->fetch(PDO::FETCH_OBJ);
							echo stripcslashes(nl2br(smiley($resultats->page)));
						}
						else
						{
							$show->showError("Problème lors du chargement de la page ...");
						}

						$requete->closeCursor();
					}
				echo '</div>';
					?>	
		  
		</div>
		  
        </div>

    </section>

    <?php require_once("../jointures/footer.php");?>