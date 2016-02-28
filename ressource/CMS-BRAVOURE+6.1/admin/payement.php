<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Payement';
  //----------------------------------//

  require 'inc/head.php';
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
?>
    <body>

        <!-- HEADER -->
        <header id="header">

            <div id="logo-group">

                <span id="logo"> 
                    <img src="img/logo.png"> 
                </span>

                <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
                <?php include 'doc/notifications.php'; ?>
                <!-- END AJAX-DROPDOWN -->
            </div>

            <!-- pulled right: nav area -->
            <div class="pull-right">

                <!-- collapse menu button -->
                <div id="hide-menu" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
                </div>
                <!-- end collapse menu -->

                <!-- logout button -->
                <div id="logout" class="btn-header transparent pull-right">
                    <span> 
                        <a href="deconnexion.php" title="Se déconnecter">
                            <i class="fa fa-sign-out"></i>
                        </a> 
                    </span>
                </div>
                <!-- end logout button -->

                <!-- input: search field -->
                    <?php include 'doc/recherche.php'; ?>
                <!-- end input: search field -->

                <?php include 'inc/translate.php'; ?>

            </div>
            <!-- end pulled right: nav area -->

        </header>
        <!-- END HEADER -->

        <!-- Left panel : Navigation area -->
        <aside id="left-panel">
            <?php include 'inc/aside.php'; ?>
        </aside>
        <!-- END NAVIGATION -->

        <!-- MAIN PANEL -->
        <div id="main" role="main">


            <!-- MAIN CONTENT -->

                <br><?php include 'doc/situation.php'; ?>
                <article class="col-sm-6">

                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

                        <header role="heading">
                            <h2>Gérer les offres Paypal</h2>
                        </header>

                        <!-- widget div-->
                        <div role="content">

                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->

                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <?php      
                                    require_once("../configuration/paypal.php");

                                    if(isset($_POST['paypal']))
                                    {
                                        if(!isset($_POST['paypal_lv']))
                                        {
                                          echo '<div class="alert alert-danger">Vous devez renseigner si vous avez un paypal ou non.</div>';
                                        }
                                        else
                                        {
                                            if($_POST['paypal_lv'] == 'Oui') 
                                            {
                                            $email_paypal = $_POST['email_paypal'];
                                            $paypal_offre_1 = $_POST['paypal_offre_1'];
                                            $nbp_offre_1 = $_POST['nbp_offre_1'];

                                            $paypal_offre_2 = $_POST['paypal_offre_2'];
                                            $nbp_offre_2 = $_POST['nbp_offre_2'];

                                            $paypal_offre_3 = $_POST['paypal_offre_3'];
                                            $nbp_offre_3 = $_POST['nbp_offre_3'];

                                            $datapaypal = '
                                            <?php

                                              $paypal = true; // si paypal = false : non actif
                                              $email_paypal = "'.$email_paypal.'"; // Votre adresse PAYPAL

                                                  /**************************/
                                                  /***** PRIX EN EUROS/******/
                                                  /**************************/    
                                                  $prix_offre_1 = "'.$paypal_offre_1.'"; 
                                                  $prix_offre_2 = "'.$paypal_offre_2.'"; 
                                                  $prix_offre_3 = "'.$paypal_offre_3.'"; 

                                                  /**************************/
                                                  /***** PRIX EN EUROS/******/
                                                  /**************************/  
                                                  $points_offre_1 = "'.$nbp_offre_1.'"; 
                                                  $points_offre_2 = "'.$nbp_offre_2.'"; 
                                                  $points_offre_3 = "'.$nbp_offre_3.'"; 


                                                  $points_offre_1 = "'.$nbp_offre_1.' points boutique €'.$paypal_offre_1.' EUR"; 
                                                  $points_offre_1_CREDIT = "'.$nbp_offre_1.'";

                                                  $points_offre_2 = "'.$nbp_offre_2.' points boutique €'.$paypal_offre_2.' EUR"; 
                                                  $points_offre_2_CREDIT = "'.$nbp_offre_2.'";

                                                  $points_offre_3 = "'.$nbp_offre_3.' points boutique €'.$paypal_offre_3.' EUR";
                                                  $points_offre_3_CREDIT = "'.$nbp_offre_3.'";

                                            ?>
                                            ';

                                            $fppaypal = fopen("../configuration/paypal.php","w+");
                                            fwrite($fppaypal, $datapaypal);
                                            fclose($fppaypal);

                                            echo '<div class="alert alert-success">Modification du Paypal avec succès</div>';
                                            } else {
                                                $datapaypal = '
                                                <?php

                                                  $paypal = false; // si paypal = false : non actif
                                                  $email_paypal = "'.$email_paypal.'"; // Votre adresse PAYPAL

                                                      /**************************/
                                                      /***** PRIX EN EUROS/******/
                                                      /**************************/    
                                                      $prix_offre_1 = "'.$paypal_offre_1.'"; 
                                                      $prix_offre_2 = "'.$paypal_offre_2.'"; 
                                                      $prix_offre_3 = "'.$paypal_offre_3.'"; 

                                                      /**************************/
                                                      /***** PRIX EN EUROS/******/
                                                      /**************************/  
                                                      $points_offre_1 = "'.$nbp_offre_1.'"; 
                                                      $points_offre_2 = "'.$nbp_offre_2.'"; 
                                                      $points_offre_3 = "'.$nbp_offre_3.'"; 


                                                      $points_offre_1 = "'.$nbp_offre_1.' points boutique €'.$paypal_offre_1.' EUR"; 
                                                      $points_offre_1_CREDIT = "'.$nbp_offre_1.'";

                                                      $points_offre_2 = "'.$nbp_offre_2.' points boutique €'.$paypal_offre_2.' EUR"; 
                                                      $points_offre_2_CREDIT = "'.$nbp_offre_2.'";

                                                      $points_offre_3 = "'.$nbp_offre_3.' points boutique €'.$paypal_offre_3.' EUR";
                                                      $points_offre_3_CREDIT = "'.$nbp_offre_3.'";

                                                ?>
                                                ';

                                                $fppaypal = fopen("../configuration/paypal.php","w+");
                                                fwrite($fppaypal, $datapaypal);
                                                fclose($fppaypal);

                                                echo '<div class="alert alert-success">Modification du Paypal avec succès</div>';
                                            }
                                        }
                                    }
                                    
                                ?>
                                
                                <form action="" class="smart-form" method="post">
                                    <header>
                                        Remplissez le formulaire ci-dessous
                                    </header>

                                    <fieldset>

                                        <section>
                                            <label class="label">Avez-vous Paypal ?</label>
                                                <input type="radio" name="paypal_lv" value="Oui" <?php if($paypal==true) echo "checked"; ?>> Oui
                                                <input type="radio" name="paypal_lv" value="Non" <?php if($paypal==false) echo "checked"; ?>> Non
                                        </section>

                                        <section>
                                            <label class="label">Entrez votre email PayPal</label>
                                            <label class="input">
                                                <input type="text" name="email_paypal" value="<?php if(!empty($email_paypal)) echo $email_paypal;?>">
                                            </label>
                                        </section>

                                        <section>
                                            <label class="label">Prix Offre 1</label>
                                            <label class="input">
                                                <input type="text" name="paypal_offre_1" value="<?php if(!empty($prix_offre_1)) echo $prix_offre_1;?>">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="label">Nombre de points :</label>
                                            <label class="input">
                                                <input type="text" name="nbp_offre_1" value="<?php if(!empty($points_offre_1)) echo $points_offre_1_CREDIT;?>">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="label">Prix Offre 2</label>
                                            <label class="input">
                                                <input type="text" name="paypal_offre_2" value="<?php if(!empty($prix_offre_2)) echo $prix_offre_2;?>">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="label">Nombre de points :</label>
                                            <label class="input">
                                                <input type="text" name="nbp_offre_2" value="<?php if(!empty($points_offre_2)) echo $points_offre_2_CREDIT;?>">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="label">Prix Offre 3</label>
                                            <label class="input">
                                                <input type="text" name="paypal_offre_3" value="<?php if(!empty($prix_offre_3)) echo $prix_offre_3;?>">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="label">Nombre de points :</label>
                                            <label class="input">
                                                <input type="text" name="nbp_offre_3" value="<?php if(!empty($points_offre_3)) echo $points_offre_3_CREDIT;?>">
                                            </label>
                                        </section>
                                    </fieldset>

                                    <footer>
                                        <input type="submit" class="btn btn-primary" value="Modifier" name="paypal">
                                    </footer>

                                </form>

                                <div class="clear"></div>
                            </div>
                                <!-- end widget content -->

                        </div>
                        <!-- end widget div -->

                    </div>
                </article>
                <article class="col-sm-6">  

                        <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

                                <header role="heading">
                                    <h2>Gérer les offres Starpass</h2>
                                </header>

                                <!-- widget div-->
                                <div role="content">

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->

                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body no-padding">

                                        <?php
                                            require_once("../configuration/starpass.php");

                                            if(isset($_POST['starpass']))
                                            {
                                                $idp_offre_1 = $_POST['idp_offre_1'];
                                                $idd_offre_1 = $_POST['idd_offre_1'];
                                                $nbt_offre_1 = $_POST['nbt_offre_1'];

                                                $idp_offre_2 = $_POST['idp_offre_2'];
                                                $idd_offre_2 = $_POST['idd_offre_2'];
                                                $nbt_offre_2 = $_POST['nbt_offre_2'];

                                                $idp_offre_3 = $_POST['idp_offre_3'];
                                                $idd_offre_3 = $_POST['idd_offre_3'];
                                                $nbt_offre_3 = $_POST['nbt_offre_3'];


                                                $data = '
                                                  <?php

                                                        $name_points = "points"; // Le nom de vos points

                                                    /************************************/
                                                    /************* STARPASS *************/
                                                    /************************************/  

                                                      $idd_1 = "'.$idd_offre_1.'";
                                                      $idp_1 = "'.$idp_offre_1.'";
                                                      $nombre_points_1 = "'.$nbt_offre_1.'";

                                                      $idd_2 = "'.$idd_offre_2.'";
                                                      $idp_2 = "'.$idp_offre_2.'";
                                                      $nombre_points_2 = "'.$nbt_offre_2.'";

                                                      $idd_3 = "'.$idd_offre_3.'";
                                                      $idp_3 = "'.$idp_offre_3.'";
                                                      $nombre_points_3 = "'.$nbt_offre_3.'";

                                                      
                                                ?>
                                                ';

                                                $fp = fopen("../configuration/starpass.php","w+");
                                                fwrite($fp, $data);
                                                fclose($fp);

                                                $show->showSuccess("Succès, les offres starpass ont été modifiés.");
                                                            
                                            }
                                        ?>

                                        <form action="" class="smart-form" method="post">
                                            <header>
                                                Remplissez le formulaire ci-dessous
                                            </header>

                                            <fieldset>

                                            <section>
                                                <label class="label">IDP (offre 1)</label>
                                                <label class="input">
                                                    <input type="text" name="idp_offre_1" value="<?php if(!empty($idp_1)) echo $idp_1;?>">
                                                </label>
                                            </section>
                                            <section>
                                                <label class="label">IDD (offre 1)</label>
                                                <label class="input">
                                                    <input type="text" name="idd_offre_1" value="<?php if(!empty($idd_1)) echo $idd_1;?>">
                                                </label>
                                            </section>
                                            <section>
                                                <label class="label">Nombre de points (offre 1)</label>
                                                <label class="input">
                                                    <input type="text" name="nbt_offre_1" value="<?php if(!empty($nombre_points_1)) echo $nombre_points_1;?>">
                                                </label>
                                            </section>

                                            <section>
                                                <label class="label">IDP (offre 2)</label>
                                                <label class="input">
                                                    <input type="text" name="idp_offre_2" value="<?php if(!empty($idp_2)) echo $idp_2;?>">
                                                </label>
                                            </section>
                                            <section>
                                                <label class="label">IDD (offre 2)</label>
                                                <label class="input">
                                                    <input type="text" name="idd_offre_2" value="<?php if(!empty($idd_2)) echo $idd_2;?>">
                                                </label>
                                            </section>
                                            <section>
                                                <label class="label">Nombre de points (offre 2)</label>
                                                <label class="input">
                                                    <input type="text" name="nbt_offre_2" value="<?php if(!empty($nombre_points_2)) echo $nombre_points_2;?>">
                                                </label>
                                            </section>

                                            <section>
                                                <label class="label">IDP (offre 3)</label>
                                                <label class="input">
                                                    <input type="text" name="idp_offre_3" value="<?php if(!empty($idp_3)) echo $idp_3;?>">
                                                </label>
                                            </section>
                                            <section>
                                                <label class="label">IDD (offre 3)</label>
                                                <label class="input">
                                                    <input type="text" name="idd_offre_3" value="<?php if(!empty($idd_3)) echo $idd_3;?>">
                                                </label>
                                            </section>
                                            <section>
                                                <label class="label">Nombre de points (offre 3)</label>
                                                <label class="input">
                                                    <input type="text" name="nbt_offre_3" value="<?php if(!empty($nombre_points_3)) echo $nombre_points_3;?>">
                                                </label>
                                            </section>


                                            </fieldset>

                                            <footer>
                                                <input type="submit" class="btn btn-primary" value="Modifier" name="starpass">
                                            </footer>

                                        </form>
                                    </div>
                                <!-- end widget content -->

                                </div>
                            <!-- end widget div -->

                        </div>
                    </article>
            <!-- END MAIN CONTENT -->

            <?php include 'inc/admin.php'; ?>
            
        </div>
        <!-- END MAIN PANEL -->

        

        <!--================================================== -->

        <?php include 'inc/footer.php'; ?>

    </body>

</html>
<?php
}
?>