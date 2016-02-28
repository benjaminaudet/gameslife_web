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

	$titre = "S'enregistrer";
	require_once ("../jointures/head.php");
	require_once ("../jointures/header.php");
?>
    <section class="content-block default-bg">
      
        <div class="container">
        
          <div class="form-block clearfix">
                
            <div class="pull-left col"> 
              <h4><i class="fa fa-unlock"></i></i>Inscription validée ?</h4>
              <p>Cliquez sur le bouton ci-dessous pour vous connecter.</p>
              <a href="../connexion/" class="btn btn-default">Se connecter</a>
            </div>
            <div class="pull-right col"> 
              <h4><i class="fa fa-user"></i></i>Inscription</h4>
        			  <div id="message_Inscription"></div>
        			  <input class="form-control" type="text" name="pseudo" id="pseudo" value="<?php if($_SESSION['pseudo_info'] == '') echo htmlspecialchars($_SESSION['form_pseudo'], ENT_QUOTES) ; ?>" placeholder="Pseudo">
        			  <input type="password" name="mdp" class="form-control" id="mdp" placeholder="Mot de passe" onkeyup="evalPwd(this.value);" value="<?php if($_SESSION['mdp_info'] == '') echo htmlspecialchars($_SESSION['form_mdp'], ENT_QUOTES) ; ?>"/>
        			  <input type="password" class="form-control" placeholder="Confirmation du MDP" name="mdp_verif" id="mdp_verif" value="<?php if($_SESSION['mdp_verif_info'] == '') echo htmlspecialchars($_SESSION['form_mdp_verif'], ENT_QUOTES) ; ?>" />
        			  <input type="text" class="form-control" placeholder="E-mail" name="mail" id="mail" onClick="javascript:visibilite('Email');" value="<?php if($_SESSION['mail_info'] == '') echo htmlspecialchars($_SESSION['form_mail'], ENT_QUOTES) ; ?>">
        			  <input type="text" class="form-control" placeholder="Confirmation de l'E-mail" name="mail_verif" id="mail_verif" value="<?php if($_SESSION['mail_verif_info'] == '') echo htmlspecialchars($_SESSION['form_mail_verif'], ENT_QUOTES) ; ?>">
        			  <input type="text" class="form-control" name="reponse" id="reponse" placeholder="Réponse secrète *">
        			  <h5><small>* Premet de récupérer votre mot de passe si vous l'avez perdu</small></h5>
        			  <button type="submit" form="validate" class="btn btn-primary"  onclick="javascript:creationCompte();">S'inscrire</button>
            </div>
            <script src="../ajax/query.js"></script>
          </div>
      
        </div>
        
    </section>

    <?php include '../jointures/footer.php'; ?>