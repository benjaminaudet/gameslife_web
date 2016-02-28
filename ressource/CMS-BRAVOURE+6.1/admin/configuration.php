<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  $titre = 'Configuration';
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
                <br><article style="padding:25px;">
                    <?php include 'doc/situation.php'; ?>

                        <div class="jarviswidget">

                                <header role="heading">
                                    <h2>Configuration Générale</h2>
                                </header>

                                <!-- widget div-->
                                <div role="content">

                                    <!-- widget edit box -->
                                    <div class="jarviswidget-editbox">
                                        <!-- This area used as dropdown edit box -->

                                    </div>
                                    <!-- end widget edit box -->

                                    <!-- widget content -->
                                    <div class="widget-body">

                                      <?php
                                        require_once("../configuration/configuration.php");

                                        if(isset($_POST['submit']))
                                        {
                                          if(empty($_POST['nom_serveur']) || empty($_POST['vote']) || empty($_POST['skype']) || empty($_POST['ip_serveur']) || empty($_POST['description']))
                                          {
                                            echo '<div class="alert alert-danger">Vous devez rentrer vos informations serveur.</div>';
                                          }
                                          else
                                          {
                                            $nom = htmlspecialchars(stripcslashes($_POST['nom_serveur']));
                                            $vote = htmlspecialchars($_POST['vote']);
                                            $skype = htmlspecialchars($_POST['skype']);
                                            $ip_serveur = htmlspecialchars(stripcslashes($_POST['ip_serveur']));
                                            $description = htmlspecialchars_decode(stripcslashes($_POST['description']));
                                            
                                            $data = '
                                            <?php
                                                // Ne pas toucher
                                                define("ROOTPATH", "http://".$_SERVER["HTTP_HOST"]."", true);
                                                $ip = $_SERVER["REMOTE_ADDR"];
                                                // Ne pas toucher

                                                // Remplacer Samant par le nom de votre site
                                                define("SITE", "'.$nom.'", true);
                                                define("JSONAPI", "1", true); // 0 : fermé / 1 : ouvert
                                                define("NombreServeur", "1", true); // nombre de serveur

                                                    $skype = "'.$skype.'"; // skype du modérateur
                                                    $ip_serveur = "'.$ip_serveur.'"; // IP serveur
                                                    $description = "'.$description.'"; // description sur la page accueil

                                                    /*************************************************************************/
                                                    /************************** SYSTEME DE VOTE  *****************************/
                                                    /*************************************************************************/  
                                                  $rpgURL = "'.$vote.'"; 

                                                    /*************************************************************************/
                                                    /************* BOUTIQUE - Modifications des images - Bug *****************/
                                                    /*************************************************************************/  

                                                    $largeur_image = "60"; // la largeur des images dans la boutique en pixels
                                                    $longueur_image = "100"; // la longueur des images dans la boutique en pixels

                                                    /*************************************************************************/
                                                    /************* SYSTEME JSONAPI CONNEXION /!\ ATTENTION /!\   *************/
                                                    /*************************************************************************/  
                                                    if (JSONAPI == 1) 
                                                    { 
                                                        include("../configuration/jsonapi_configuration.php");
                                                    }

                                                    /*******************************************************************/
                                                    /************* SYSTEME DE PAIEMENT /!\ ATTENTION /!\   *************/
                                                    /*******************************************************************/  

                                                        include ("../configuration/starpass.php");


                                                    /**********************************/
                                                    /************* PAYPAL *************/
                                                    /**********************************/  

                                                    include ("../configuration/paypal.php");


                                                    /****************************************************************************/
                                                    /************* MODIFIER LA COULEUR DE VOTRE SITE (BackGround)   *************/
                                                    /****************************************************************************/ 

                                                    include "../configuration/couleurs.php";


                                            ?>

                                            ';

                                              $fp = fopen("../configuration/configuration.php","w+");
                                              fwrite($fp, $data);
                                              fclose($fp);

                                              $show->showSuccess('Modification réussi!');
                                            }
                                        }
                                        ?>
                                        
                                        <form action="" class="smart-form" method="post">
                                          <header>
                                              Remplissez le formulaire ci-dessous
                                          </header>

                                          <fieldset>

                                              <section>
                                                  <label class="label">Nom du serveur</label>
                                                  <label class="input">
                                                      <input type="text" name="nom_serveur" value="<?php echo SITE;?>">
                                                  </label>
                                              </section>
                                              <section style="display:none;">
                                                  <label class="label">Lien de vote</label>
                                                  <label class="input">
                                                      <input type="text" name="vote" value="<?php if(!empty($rpgURL)) echo $rpgURL;?>">
                                                  </label>
                                              </section>
                                              <section>
                                                  <label class="label">Skype</label>
                                                  <label class="input">
                                                      <input type="text" name="skype" value="<?php if(!empty($skype)) echo $skype;?>">
                                                  </label>
                                              </section>
                                              <section>
                                                  <label class="label">IP du serveur</label>
                                                  <label class="input">
                                                      <input type="text" name="ip_serveur" value="<?php if(!empty($ip_serveur)) echo $ip_serveur;?>">
                                                  </label>
                                              </section>
                                              <section>
                                                  <label class="label">Description sur l'accueil</label>
                                                  <label class="input">
                                                      <textarea name="description" id="tinyeditor" style="width:100%;"><?php if(!empty($description)) echo $description;?></textarea>
                                                  </label>
                                              </section>
                                          </fieldset>

                                          <footer>
                                              <input type="submit" class="btn btn-primary" value="Modifier" name="submit">
                                          </footer>

                                      </form>

                                      <div class="clear"></div>

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