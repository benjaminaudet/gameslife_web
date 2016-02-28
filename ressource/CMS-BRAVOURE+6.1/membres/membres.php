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
  
 $titre = 'Fiche membre';
  require_once ("../jointures/head.php");
  require_once ("../jointures/header.php");
?>
    <section class="content-block default-bg">

        <div class="container">

          <div class="section-title">		
            <h2>Membres</h2>
            <div class="line"></div>
            <p>Informations sur un membre du serveur .</p>
          </div>
      
      <?php
      if(isset($_GET['membre']) && !empty($_GET['membre']))
      {

      	$inputSearch =  htmlspecialchars($_GET['membre']);
      	$req = $bdd->prepare('SELECT COUNT(user_pseudo) FROM joueurs WHERE user_pseudo = :inputSearch');
      	$req->bindParam(':inputSearch', $inputSearch, PDO::PARAM_STR, 100);
      	$req->execute();
                  
      	$verifie = $req->fetch(); 
      	if($verifie[0] > 0) 
      	{

              if(JSONAPI == 1)
              {
                
                $user = $connexion_1->getPlayer($inputSearch);
                
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
                
                $pseudo = $inputSearch;
                
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
                $groupe = 'Admin';
                $money = 15880071;
              }

                   $query = $bdd->prepare ("SELECT * FROM joueurs WHERE user_pseudo = :inputSearch");
                   $query->bindParam(':inputSearch', $inputSearch, PDO::PARAM_STR);
                   $query->execute();
                
                   $resultats = $query->fetch(PDO::FETCH_OBJ); 
                                
                  echo '<h4><u>Informations générales</u></h4>';
                   echo '<img src="https://minotar.net/avatar/'.$resultats->user_pseudo.'/64.png" style="margin-right:25px; border-radius:5px;  box-shadow: 4px 4px 8px #555; ">';
                  echo 'Profil du joueur <b>'.strtoupper($resultats->user_pseudo).'</b><br><br>';
                   
                      echo '<table width="100%" color="black" class="table table-striped">';
                      
                      /// Corps
                        echo '<tr>';
                         echo '<td width="35%">Inscrit le :</td>';
                         echo '<td> '.date('d/m/Y', $resultats->user_inscription).' à '.date('H:i', $resultats->user_inscription).'  </td>';
                          echo '</tr>';

                        echo '<tr>';
                         echo '<td width="35%">Points :</td>';
                         echo '<td> '.$resultats->user_points.' <img src="../img/gold.png" style="display:inline; position:relative; top:0px;"/></td>';
                          echo '</tr>';
                        
                        echo '<tr>';
                         echo '<td width="35%">Votes :</td>';
                         echo '<td> '.$resultats->vote.'</td>';
                        echo '</tr>';
                        
                        echo '<tr>';
                         echo '<td width="35%">Classement vote :</td>';
                         echo '<td><i class="fa fa-trophy"></i> '.rang_vote_profil($inputSearch, $bdd).' </td>';
                          echo '</tr>';
                        
                        echo '<tr>';
                         echo '<td width="35%">Argent :</td>';
                         echo '<td>';
                          echo number_format($money,0, ',', ' ');
                         echo ' PO </td>';
                          echo '</tr>';
                        
                        echo '<tr>';
                        echo '<td width="35%">Grade : </td>';
                        echo '<td>';
                          grade_semi($groupe);
                          
                         echo '</td>';
                         echo '</tr>';

                         ?>
                          <tr>
                            <td>Banni : </td>
                            <td><?php if(JSONAPI == 1) echo ($user['success']['banned']==1)?'Oui':'Non';  ?></td>
                          </tr>

                      </table>
                      <br><br>

                      <center>
                        <img src="../ajax/skin.php?u=<?php echo $resultats->user_pseudo; ?>&s=400"/>
                      </center>
                
        <?php
        }
        else
        {
        $show->showError(' Le joueur « '.htmlspecialchars($_GET['membre']).' »  n\'existe pas.');
        }
        }
        else
        {
            $show->showError('Le joueur recherché n\'existe pas.');
        }
        ?>
        </div>
    </section>

    <div class="footer-copyright">
    	<?php require_once("../jointures/footer.php");?> 
	</div>