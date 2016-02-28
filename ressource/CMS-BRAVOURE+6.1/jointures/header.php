    <div id="page-wrapper">
      
      <header id="header">
      
        <div id="top-bar" class="open">

          <div class="container">

            <ul class="links pull-left hidden-xs">
			       <li <?php if ($cogauche == 2) echo 'class="hidden"' ?> ><a href="../stats/"><i class="fa fa-rss"></i><?php if(JSONAPI == 1){?> <?php echo $server1["success"]; ?> Connect&Eacute;s<?php } ?></a></li>
            <li><a><i class="fa fa-users"></i>Nombre d'inscrits : <?php echo inscrit($bdd);?></a></li>

            </ul>

            <ul class="links pull-right no-float-xs">

			     <li <?php if ($cogauche == 1)  echo 'class="hidden"' ?>><a href="../stats/"><i class="fa fa-rss"></i><?php if(JSONAPI == 1){?> <?php echo $server1["success"]; ?> Connect&Eacute;s<?php } ?></a></li>

			     <?php if(!isset($_SESSION['utilisateur'])){?>  
            <li><a href="../connexion/"><i class="fa fa-unlock"></i>Connexion</a></li>
            <li><a href="../inscription/"><i class="fa fa-pencil"></i>Inscription</a></li>
        		<?php } else {?>
        		<li><a href="../membres/"><i class="fa fa-user"></i>Mon compte</a></li>
        		<li><a href="../connexion/deconnexion.php"><i class="fa fa-sign-out"></i>Deconnexion</a></li>
        		<?php }?>
            </ul>

          </div>
          
        </div>

        <div  id="main-nav" class="navbar navbar-default hide-icons">

          <div class="container" >
            
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="fa fa-bars fa-lg"></span>
              </button>
              <a href="../accueil/" class="navbar-brand">
                <img alt="Samant" src="../img/logo.png">
              </a>
            </div>
            
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="../accueil/"><i class="icon fa fa-home"></i>Accueil</a></li>
                <li><a href="../nous-rejoindre/"><i class="icon fa fa-home"></i>Nous rejoindre</a></li>
                <li><a href="../credit/"><i class="icon fa fa-home"></i>Ajouter des cr&eacute;dits</a></li>
                <li><a href="../boutique/"><i class="icon fa fa-home"></i>Boutique</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-comments"></i>Informations<i class="fa fa-angle-down parent-symbol"></i></a>
                  <ul class="dropdown-menu">
                    <li><a href="../staff/">L'&eacute;quipe</a></li>
                    <li><a href="../reglement/">R&egrave;glement</a></li>
        				    <?php
        				    $req = $bdd->prepare ("SELECT titre FROM pages WHERE id > 5 ");
        				    $req->execute(); 

        				    while($resultats = $req->fetch(PDO::FETCH_OBJ))
        				    {
        				      echo '<li><a href="../pages/';
        				      echo ''.Slug($resultats->titre).'';
        				      echo '">'.$resultats->titre.'</a></li>';
        				    }
        				    $req->closeCursor();
        				    ?>
					
                  </ul>
                </li>
        			<li><a href="../voter/"><i class="icon fa fa-home"></i>Voter</a></li>
              </ul>

            </div>
            
          </div>
          
        </div>
      
      </header>