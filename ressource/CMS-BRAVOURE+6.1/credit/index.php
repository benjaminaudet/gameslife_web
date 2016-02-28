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
 	
 	$titre = 'Créditer mon compte';
	require_once ("../jointures/head.php");
  	require_once("../jointures/header.php");
?>
    <section class="content-block default-bg">

	    <div class="container">

          <div class="section-title">		
            <h2>Créditer mon compte</h2>
            <div class="line"></div>
            <p>Créditer mon compte pour pouvoir acheter sur la boutique .</p>
          </div>

          <?php if (isset($_SESSION['utilisateur'])) { ?>
		        <?php
             if(isset($_GET['paysafecard']) && isset($_POST['valider'])) {
               if(!empty($_POST['input1']) && !empty($_POST['input2']) && !empty($_POST['input3']) && !empty($_POST['input4'])) {
                 $i1 = htmlspecialchars($_POST['input1']);
                 $i2 = htmlspecialchars($_POST['input2']);
                 $i3 = htmlspecialchars($_POST['input3']);
                 $i4 = htmlspecialchars($_POST['input4']);

                 $code = "{$i1} {$i2} {$i3} {$i4}";
                 $time = time();

                 $requete = $bdd->prepare('SELECT * FROM historique_paysafecard WHERE code = :code');
                 $requete->bindParam(':code', $code, PDO::PARAM_STR);
                 $requete->execute();

                 if($requete->rowCount() == 0) {
                   $req = $bdd->prepare('INSERT INTO historique_paysafecard(user_pseudo, user_id, code, date_achat) VALUES(:user_pseudo, :user_id, :code, :date_achat)');
                   $req -> bindParam(':user_pseudo', $_SESSION['utilisateur']['user_pseudo'], PDO::PARAM_STR);
                   $req -> bindParam(':user_id', $_SESSION['utilisateur']['user_id'], PDO::PARAM_STR);
                   $req -> bindParam(':code', $code, PDO::PARAM_STR);
                   $req -> bindParam(':date_achat', $time, PDO::PARAM_STR);
                   $req -> execute();

                   $show->showSuccess("Merci de votre achat, nous allons vérifier votre code Paysafecard le plus rapidement possible. Votre compte sera crédité sous 24h.");

                 } else {
                   $show->showError("Ce code Paysafecard a déjà été utilisé.");
                 }

               } else {
                 $show->showError("Merci de remplir le formulaire.");
               }
             }

             ?>
            <div class="row">
            
              <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="price-plan">
                
                  <div class="header">
                    <h4 class="title">Simple</h4>
                  </div>
                  
                  <div class="price-box">
                    <h2 class="price tts-1-target"><?php echo $nombre_points_1; ?></h2>
                  </div>
                  
                  <ul class="features">
                    <li>Appels et SMS.</li>
					          <li>Reversement instantané</li>
            
                  </ul>
                  
                  <div class="footer">
                    <a href="credit_object.php?offre=<?php echo $idd_1; ?>" class="btn btn-color white-bg-20pc">Acheter</a>
                  </div>
                
                </div>
              </div>
              
              <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="price-plan">
                
                  <div class="header">
                    <h4 class="title">Standard</h4>
                  </div>
                  
                  <div class="price-box">
                    <h2 class="price tts-1-target"><?php echo $nombre_points_2; ?></h2>
                  </div>
                  
                  <ul class="features">
                    <li>Appels et SMS.</li>
					          <li>Reversement instantané</li>
                  </ul>
                  
                  <div class="footer">
                    <a href="credit_object.php?offre=<?php echo $idd_2; ?>" class="btn btn-color white-bg-20pc">Acheter</a>
                  </div>
                
                </div>
              </div>

              <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="price-plan featured">
                
                  <div class="header">
                    <h4 class="title">Parfait</h4>
                  </div>
                  
                  <div class="price-box">
                    <h2 class="price tts-1-target"><?php echo $nombre_points_3; ?></h2>
                  </div>
                  
                  <ul class="features">
                    <li>Appels et SMS.</li>
					          <li>Reversement instantané</li>
                  </ul>
                  
                  <div class="footer">
                    <a href="credit_object.php?offre=<?php echo $idd_3; ?>" class="btn">Acheter</a>
                  </div>
                
                </div>
              </div>
                        
            </div>

	    </div>
				
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h3>Acheter des points avec PayPal</h3>
            <center>
              <div id="paypal"> </div>
                  <tr>
                  <td>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

                <div class="col-sm-6">
                <select name="amount" class="form-control">
                    <option value="<?php echo $prix_offre_1;?>">Offre de <?php echo $points_offre_1;?></option>
                    <option value="<?php echo $prix_offre_2;?>">Offre de <?php echo $points_offre_2;?></option>
                    <option value="<?php echo $prix_offre_3;?>">Offre de <?php echo $points_offre_3;?></option>
                  </select>
                </div>

                <input name="currency_code" type="hidden" value="EUR" />
                <input name="shipping" type="hidden" value="0.00" />
                <input name="tax" type="hidden" value="0.00" />

                <input name="return" type="hidden" value="<?php echo ROOTPATH; ?>/credit/paiementValide.php" />
                <input name="cancel_return" type="hidden" value="<?php echo ROOTPATH; ?>/credit/paiementAnnule.php" />
                <input name="notify_url" type="hidden" value="<?php echo ROOTPATH; ?>/credit/ipn_paypal.php" />

                <input name="cmd" type="hidden" value="_xclick" />
                <input name="business" type="hidden" value="<?php echo $email_paypal; ?>" />
                <input name="item_name" type="hidden" value="Achat de <?php echo $name_points; ?> - <?php echo $_SESSION['utilisateur']['user_pseudo'];?>" />
                <input name="no_note" type="hidden" value="1" />
                <input name="lc" type="hidden" value="FR" />
                <input name="bn" type="hidden" value="PP-BuyNowBF" />
                <input name="custom" type="hidden" value="pseudo=<?php echo $_SESSION['utilisateur']['user_pseudo'];?>" />

                                  

              </td>
                <td>
                  <center>
                    <input alt="effectuez vos paiements via paypal : une solution rapide, gratuite et sécurisée" name="submit" src="../img/paypal_btn_pay.gif" type="image" /><img src="https://www.paypal.com/fr_fr/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
                  </center>
                </form>
                </td>

                  </tr>      
              </center>


              <div style="clear:both"></div>

              <h3>Acheter des points avec PaysafeCard</h3>
              <ol class="breadcrumb">
                Rentrez votre code ci-dessous. Attention, il faut environ 24h pour que votre compte soit crédité. <br> <br>
                <form method="post" action="../credit/?paysafecard">
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input1" maxlength="4">
                  </div>                  

                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input2" maxlength="4">
                  </div>                  

                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input3" maxlength="4">
                  </div>                  

                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="input4" maxlength="4">
                  </div>

                  <div class="col-sm-3">
                    <button name="valider" class="btn btn-primary pull-right" style="margin-right: 20px;"> Valider </button>
                  </div>
                  <div style="clear:both"></div><br><br>
                  <?php $show->showError("Merci de ne pas rentrer des codes erronés sous peine de sanction."); ?>
                </form>
                <div class="clear"></div>
             </ol>
          </div>
        </div>
      </div>


    <br><br><br>

		  <?php }  else  {    echo '<div class="bs-callout bs-callout-danger"><h4>Vous devez être connecté .</h4><p>Pour pouvoir accéder à cette page vous devez être connecté .</p><center><a type="button" class="btn btn-success" href="../connexion/"><i class="fa fa-unlock"></i>Connexion</a></center></div>';  }  ?>

    </section>

    <div>
	<?php require_once ("../jointures/footer.php"); ?>
    </div>	