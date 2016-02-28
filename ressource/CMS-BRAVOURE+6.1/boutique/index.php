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

	$titre = 'Boutique';
	require_once ("../jointures/head.php");
	require_once("../jointures/header.php");

 actualisation_session($bdd);
 $titre = 'Boutique';
  if(isset($_GET['serveur']) && !empty($_GET['serveur']))
  {
    $serveur_get = intval($_GET['serveur']);

    $i = array(1,2,3,4,5,6,7,8,9,10);
    if (in_array($serveur_get, $i)) 
    {
      for ($i = 1; $i <= 10; $i++) 
      {
        if($serveur_get == $i)
        {
          $serveur = 'connexion_'.$i.'';
        }
      }
    }
    else
    {
      $serveur = 'connexion_1'; 
    }

  }
  else
  {
    $serveur = 'connexion_1'; 
  }
    

$requete = $bdd->prepare("SELECT DISTINCT(onglet) FROM boutique_onglets");
$requete->execute();


while($resultats = $requete->fetch(PDO::FETCH_OBJ))
{
   if(isset($_GET['items']) && !empty($_GET['items']))
   {
      if($resultats->onglet == $_GET['items'])
      {
        $item_categorie = $resultats->onglet;
      }
   }
   else
   {
    $item_categorie = 'Grades';
   }

}
$requete->closeCursor();

 function boutique($nom, $serveur, $bdd)
   {
       echo '<div class="clear"></div><br>';
       ?>
        <div class="col-lg-12">
         <center><h3><?php echo $nom; ?></h3></center>
          <div>
            <hr>
          </div>
        </div>
       <div class="clear"></div>
       <?php
       $requete = $bdd->prepare("SELECT * FROM boutique WHERE categorie = '".$nom."' AND serveur = '".$serveur."' ORDER BY id ASC");
       $requete->execute();
       $i=1;
         while($resultats = $requete->fetch(PDO::FETCH_OBJ)){?>  
          <a href="buy_object.php?id=<?php echo $resultats->id; ?>&serveur=<?php echo $resultats->serveur;?>"> 
          <div class="col-xs-6 col-sm-4 col-md-4">
      			<div class="product clearfix">
      			
      				<center>
      					<div class="image"> 
      						<a class="main"><img src="<?php echo $resultats->image; ?>" height="140" style="width: inherit;height: inherit;max-height: 155px;"></a>
      					</div>
      				</center>
				
                <div class="title">
                  <a class="name"><?php echo stripcslashes($resultats->nom); ?></a>
                </div>
				
                <div class="links">
                  <span class="price">
                    <?php
                      if($resultats->prix_promotion == 0){
                        echo $resultats->prix;
                      } else {
                        echo '<div style="text-decoration: line-through; color: #CD0000;display: inline;font-size: 15px;">'.$resultats->prix.'</div>';
                        echo '<div style="color:#0E8600;display: inline;"> '.$resultats->prix_promotion.'</div>';
                      }
                    ?>

                    <img src="../img/gold.png"></span>
                  <a class="cart" href="buy_object.php?id=<?php echo $resultats->id; ?>&serveur=<?php echo $resultats->serveur;?>"><i class="fa fa-shopping-cart"></i><span>Acheter</span></a>	
                </div>
				

        			</div>
        		</div>
          </a>
         <?php
          if($i%3 == 0) echo '<div class="clear"></div><br>';
          $i++;
         }
   }
?>
	<section class="content-block default-bg">
		<div class="container">
					
			<div class="row-fluid">

				   <div class="section-title">		
					 <h2>Boutique</h2>
						<div class="line color-1-bg"></div>
				   </div>
			  
			  
					<div class="jumbotron">
						<?php if(!isset($_SESSION['utilisateur'])){?> 
					 <center><h1 class="bold"><i class="fa fa-info"></i> Vous n'êtes pas connecté ! <i class="fa fa-info"></i></h1></center>
					 <p class="lead">Vous devez être connecté pour pouvoir acheter dans la boutique .</p>
						<a class="btn btn-primary btn-thicker space" href="../connexion/"><i class="fa fa-unlock"></i>Se connecter</a>
						<a class="btn btn-secondary btn-thicker space" href="../inscription/"><i class="fa fa-pencil"></i>Se créer un compte</a>
						<?php } else {?>
					   <center><h1 class="bold"><i class="fa fa-info"></i> Points Boutique <i class="fa fa-info"></i></h1></center>
					 <p class="lead">Il vous faut des points boutique pour acheter dans la boutique .</p>
						<a class="btn btn-primary btn-thicker space" href="../credit/"><i class="fa fa-dollar"></i>Créditer mon compte</a>
						<?php }?>
						</center>
					</div>

					
				<div class="navbar-inner">
					<center>Choisissez la boutique de votre serveur : <br><br>
					<p>
				   <?php 
				   $btn=1;

					$requete = $bdd->prepare("SELECT DISTINCT(serveur) FROM boutique_onglets  ORDER BY id ASC");
					$requete->execute();
					
					while($resultats = $requete->fetch(PDO::FETCH_OBJ)) { ?>
						<a href="?serveur=<?php echo $btn; ?>" class="btn btn-primary btn-thicker space"> <?php echo SITE; ?> - Boutique <?php echo $btn; ?></a>
				   <?php $btn++; }?>
				
					</p>
					</center>
					  <ul class="nav" role="navigation">
					    <div class="row-fluid">
						<div id="myTabContent" class="tab-content">
							
						    <?php
                  $requete = $bdd->prepare("SELECT * FROM boutique_onglets WHERE serveur = '".$serveur."' ORDER BY id ASC");
                  $requete->execute();

                   while($resultats = $requete->fetch(PDO::FETCH_OBJ))
                   {
                      boutique(''.$resultats->onglet.'', $serveur, $bdd);
                   }                            
                ?>
						</div>
						</div>
					  </ul>

		        </div>
		    </div>
	   </div>
	</section>

	<div class="footer-copyright">
	<?php require_once("../jointures/footer.php");?> 
	</div>   
	
