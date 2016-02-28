<?php
@session_start();
header('Content-type: text/html; charset=utf-8');
 //ini_set("display_errors",0);
 //error_reporting(0);
 
  //---------------------------------------------------------
  // Requires fichiers database
  //---------------------------------------------------------
  require_once('../configuration/configuration.php');

 $titre = 'Installation de SamantCMS';
 require_once ("../jointures/head.php");
?>
  <body>

  <div class="container">
  
      <center><img src="../install/samant.png">

        <div class="box-shadow well news-body">
          
          <h2><b>Etape 1 :</b> Configuration de la base de donnée</h2></center>
<?php
          if(isset($_POST['etape1']))
          {
            if(empty($_POST['hote_mysql']) || empty($_POST['login_mysql']) || empty($_POST['nom_mysql']))
            {
              echo '<div class="alert alert-danger">Vous devez rentrer vos informations MySQL.</div>';
            }
            else
            {

              $bdd_addr_serveur=$_POST['hote_mysql'];
              $bdd_login=$_POST['login_mysql'];
              $bdd_mot_de_passe=$_POST['mdp_mysql'];
              $bdd_nom_base=$_POST['nom_mysql'];
               
              try
              {
                $bdd = new PDO('mysql:host='.$bdd_addr_serveur.';dbname='.$bdd_nom_base.'', ''.$bdd_login.'', ''.$bdd_mot_de_passe.'');
                $bdd->exec('SET NAMES utf8');

                $data = '
                <?php                 
                   try
                    {
                      $bdd = new PDO("mysql:host='.$bdd_addr_serveur.';dbname='.$bdd_nom_base.'", "'.$bdd_login.'", "'.$bdd_mot_de_passe.'");
                      $bdd->exec("SET NAMES utf8");
                    }
                    catch (Exception $e)
                    {
                      die($e->getMessage());
                    }

                ?>
                ';

                $fp = fopen("../configuration/baseDonnees.php","w+");
                fwrite($fp, $data);
                fclose($fp);


                echo '<div class="clear"></div><a href=""><h4>Terminé !</h4></a> <br>';                

                    $commentaire = $bdd->exec("
                    CREATE TABLE IF NOT EXISTS `commentaires` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `id_new` int(11) DEFAULT NULL,
                      `titre_new` varchar(255) DEFAULT NULL,
                      `user_pseudo` varchar(50) DEFAULT NULL,
                      `texte` text,
                      `date` varchar(25) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
                    ");

                  $admin = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `admin` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `pseudo` varchar(50) DEFAULT NULL,
                    `email` varchar(50) DEFAULT NULL,
                    `mdp` varchar(50) DEFAULT NULL,
                    `actif` int(5) DEFAULT '0',
                    `aleatoireChiffres` varchar(30) DEFAULT NULL,
                    `dateConnexion` varchar(30) DEFAULT NULL,
                    `ipConnexion` varchar(40) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");

                  $boutique = $bdd->exec("
                      CREATE TABLE IF NOT EXISTS `boutique` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `ordre_id` varchar(11) NOT NULL,
                    `nom` varchar(255) NOT NULL,
                    `description` text NOT NULL,
                    `texte` text NOT NULL,
                    `serveur` varchar(20) NOT NULL,
                    `commande` varchar(255) NOT NULL,
                    `categorie` varchar(255) NOT NULL,
                    `prix` int(10) NOT NULL,
                    `image` varchar(255) NOT NULL,
                    `grade_necessaire` varchar(50) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;");

                  $boutique_onglets = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `boutique_onglets` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `onglet` varchar(50) DEFAULT NULL,
                    `serveur` varchar(50) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;");

                  $historique = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `historique` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `joueur` varchar(32) NOT NULL,
                    `date_achat` int(255) NOT NULL,
                    `nom_offre` varchar(255) NOT NULL,
                    `adresse_ip` varchar(30) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;");

                  $historique_credit = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `historique_credit` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `joueur` varchar(32) NOT NULL,
                    `date_achat` int(255) NOT NULL,
                    `nom_offre` varchar(255) NOT NULL,
                    `adresse_ip` varchar(30) NOT NULL,
                    `user_points_after` varchar(50) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;");

                  $historique_echange = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `historique_echange` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `joueur` varchar(255) NOT NULL,
                    `versjoueur` varchar(255) NOT NULL,
                    `nombre_point` int(11) NOT NULL,
                    `date_echange` int(15) NOT NULL,
                    `adresse_ip` varchar(50) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

                  $joueurs = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `joueurs` (
                    `user_id` int(11) NOT NULL AUTO_INCREMENT,
                    `user_pseudo` varchar(32) NOT NULL,
                    `user_mdp` varchar(40) NOT NULL,
                    `user_mail` varchar(100) NOT NULL,
                    `user_level` tinyint(1) NOT NULL DEFAULT '0',
                    `user_points` int(255) NOT NULL DEFAULT '0',
                    `user_skin` tinyint(1) NOT NULL DEFAULT '0',
                    `user_cloak` tinyint(1) NOT NULL DEFAULT '0',
                    `user_inscription` int(255) NOT NULL,
                    `user_derniere_visite` int(255) NOT NULL,
                    `sessionId` varchar(255) NOT NULL,
                    `user_banni` int(1) NOT NULL DEFAULT '0',
                    `vote` int NOT NULL,
                    `date_vote` text NOT NULL,
                    `friends` text,
                    `reponse` varchar(100),
                    PRIMARY KEY (`user_id`),
                    UNIQUE KEY `user_pseudo` (`user_pseudo`),
                    UNIQUE KEY `user_mail` (`user_mail`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;");

                  $messages = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `messages` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `id_expediteur` int(11) DEFAULT NULL,
                    `id_destinataire` int(11) DEFAULT NULL,
                    `date` int(15) DEFAULT NULL,
                    `titre` text,
                    `message` text,
                    `etat` int(5) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

                  $news = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `news` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `titre` varchar(35) DEFAULT NULL,
                    `date` varchar(50) DEFAULT NULL,
                    `texte` text,
                    `auteur` varchar(50) DEFAULT NULL,
                    `img` text,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;");

                  $pages = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `pages` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `titre` varchar(50) NOT NULL,
                    `page` text NOT NULL,
                    `date` varchar(25) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
                  -- ----------------------------
                  -- Records of pages
                  -- ----------------------------
                  INSERT INTO `pages` VALUES ('2', 'Presentation', 'Présentation', '');
                  INSERT INTO `pages` VALUES ('5', 'Reglement', 'Reglement a éditer', '');
                  INSERT INTO `pages` VALUES ('8', 'CGU', '<strong style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; color: rgb(127, 127, 127);\">La seule contrepartie à l\'utilisation de ces mentions légales, est l\'engagement total à laisser le lien crédit subdelirium sur cette page de mentions légales.</strong><br style=\"color: rgb(127, 127, 127); font-family: Raleway; font-size: 17px; line-height: 20px;\"><span style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; color: rgb(127, 127, 127); background-color: rgb(245, 245, 245);\">Vos mentions légales :</span><h2 style=\"font-family: Raleway; font-size: 25px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">Informations légales</h2><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">1. Présentation du site.</h3><p style=\"margin: 0px 0px 10px;\"><font color=\"#7f7f7f\" style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px;\">En vertu de l\'article 6 de la loi n° 2004-575 du 21 juin 2004 pour la confiance dans l\'économie numérique, il est précisé aux utilisateurs du site</font><b><font color=\"#cc0000\"><font face=\"Raleway\"><span style=\"font-size: 17px; line-height: 20px;\">&nbsp;</span></font></font></b><a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\"><font color=\"#cc0000\" size=\"4\">www.monsite.fr</font></a><font color=\"#7f7f7f\" style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px;\">&nbsp;l\'identité des différents intervenants dans le cadre de sa réalisation et de son suivi :</font></p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; margin: 0px 0px 10px;\"><span style=\"color: rgb(127, 127, 127); font-weight: normal;\"><strong>Propriétaire</strong>&nbsp;: </span><b><font color=\"#cc0000\">Nom de mon serveur</font></b><br><strong style=\"color: rgb(127, 127, 127); font-weight: normal;\">Créateur</strong><font color=\"#7f7f7f\">&nbsp;:&nbsp;</font><a href=\"http://www.antoinebourlart.fr/\" style=\"color: rgb(119, 119, 119); font-weight: normal; text-decoration: none;\">Antoine BOURLART</a><br><strong style=\"color: rgb(127, 127, 127); font-weight: normal;\">Responsable publication</strong><font color=\"#7f7f7f\">&nbsp;:&nbsp;</font><b><font color=\"#cc0000\">Nom de mon serveur</font></b><font color=\"#7f7f7f\">– monemail@gmail.com</font><br><font color=\"#7f7f7f\">Le responsable publication est une personne physique ou une personne morale.</font><br><strong style=\"color: rgb(127, 127, 127); font-weight: normal;\">Webmaster</strong><font color=\"#7f7f7f\">&nbsp;:&nbsp;</font><b><font color=\"#cc0000\">Nom de mon serveur</font></b><font color=\"#7f7f7f\">– monemail@gmail.com</font><br><strong style=\"color: rgb(127, 127, 127); font-weight: normal;\">Hébergeur</strong><font color=\"#7f7f7f\">&nbsp;:&nbsp;</font><br><font color=\"#7f7f7f\">Crédits : les mentions légales ont étés générées et offertes par Subdelirium&nbsp;</font><a target=\"_blank\" href=\"http://www.subdelirium.com/referencement/\" alt=\"referencement site internet charente\" style=\"color: rgb(119, 119, 119); font-weight: normal; text-decoration: none;\">référencement Charente</a></p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">2. Conditions générales d’utilisation du site et des services proposés.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">L’utilisation du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;implique l’acceptation pleine et entière des conditions générales d’utilisation ci-après décrites. Ces conditions d’utilisation sont susceptibles d’être modifiées ou complétées à tout moment, les utilisateurs du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;sont donc invités à les consulter de manière régulière.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Ce site est normalement accessible à tout moment aux utilisateurs. Une interruption pour raison de maintenance technique peut être toutefois décidée par Nom de mon serveur, qui s’efforcera alors de communiquer préalablement aux utilisateurs les dates et heures de l’intervention.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;est mis à jour régulièrement par Nom de mon serveur. De la même façon, les mentions légales peuvent être modifiées à tout moment : elles s’imposent néanmoins à l’utilisateur qui est invité à s’y référer le plus souvent possible afin d’en prendre connaissance.</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">3. Description des services fournis.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"color: rgb(119, 119, 119); text-decoration: none;\">www.monsite.fr</a>&nbsp;a pour objet de fournir une information concernant l’ensemble des activités de la société.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Nom de mon serveur s’efforce de fournir sur le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;des informations aussi précises que possible. Toutefois, il ne pourra être tenue responsable des omissions, des inexactitudes et des carences dans la mise à jour, qu’elles soient de son fait ou du fait des tiers partenaires qui lui fournissent ces informations.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Tous les informations indiquées sur le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;sont données à titre indicatif, et sont susceptibles d’évoluer. Par ailleurs, les renseignements figurant sur le site&nbsp;<font color=\"#cc0000\" style=\"text-decoration: none;\"><a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\">www.monsite.fr</a></font>&nbsp;ne sont pas exhaustifs. Ils sont donnés sous réserve de modifications ayant été apportées depuis leur mise en ligne.</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">4. Limitations contractuelles sur les données techniques.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le site utilise la technologie JavaScript.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le site Internet ne pourra être tenu responsable de dommages matériels liés à l’utilisation du site. De plus, l’utilisateur du site s’engage à accéder au site en utilisant un matériel récent, ne contenant pas de virus et avec un navigateur de dernière génération mis-à-jour</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">5. Propriété intellectuelle et contrefaçons.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Nom de mon serveur est propriétaire des droits de propriété intellectuelle ou détient les droits d’usage sur tous les éléments accessibles sur le site, notamment les textes, images, graphismes, logo, icônes, sons, logiciels.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de : Nom de mon serveur.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Toute exploitation non autorisée du site ou de l’un quelconque des éléments qu’il contient sera considérée comme constitutive d’une contrefaçon et poursuivie conformément aux dispositions des articles L.335-2 et suivants du Code de Propriété Intellectuelle.</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">6. Limitations de responsabilité.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Nom de mon serveur ne pourra être tenue responsable des dommages directs et indirects causés au matériel de l’utilisateur, lors de l’accès au site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>, et résultant soit de l’utilisation d’un matériel ne répondant pas aux spécifications indiquées au point 4, soit de l’apparition d’un bug ou d’une incompatibilité.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Nom de mon serveur ne pourra également être tenue responsable des dommages indirects (tels par exemple qu’une perte de marché ou perte d’une chance) consécutifs à l’utilisation du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Des espaces interactifs (possibilité de poser des questions dans l’espace contact) sont à la disposition des utilisateurs. Nom de mon serveur se réserve le droit de supprimer, sans mise en demeure préalable, tout contenu déposé dans cet espace qui contreviendrait à la législation applicable en France, en particulier aux dispositions relatives à la protection des données. Le cas échéant, Nom de mon serveur se réserve également la possibilité de mettre en cause la responsabilité civile et/ou pénale de l’utilisateur, notamment en cas de message à caractère raciste, injurieux, diffamant, ou pornographique, quel que soit le support utilisé (texte, photographie…).</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">7. Gestion des données personnelles.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">En France, les données personnelles sont notamment protégées par la loi n° 78-87 du 6 janvier 1978, la loi n° 2004-801 du 6 août 2004, l\'article L. 226-13 du Code pénal et la Directive Européenne du 24 octobre 1995.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">A l\'occasion de l\'utilisation du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>, peuvent êtres recueillies : l\'URL des liens par l\'intermédiaire desquels l\'utilisateur a accédé au site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>, le fournisseur d\'accès de l\'utilisateur, l\'adresse de protocole Internet (IP) de l\'utilisateur.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">En tout état de cause Nom de mon serveur ne collecte des informations personnelles relatives à l\'utilisateur que pour le besoin de certains services proposés par le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>. L\'utilisateur fournit ces informations en toute connaissance de cause, notamment lorsqu\'il procède par lui-même à leur saisie. Il est alors précisé à l\'utilisateur du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;l\'’obligation ou non de fournir ces informations.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Conformément aux dispositions des articles 38 et suivants de la loi 78-17 du 6 janvier 1978 relative à l’informatique, aux fichiers et aux libertés, tout utilisateur dispose d’un droit d’accès, de rectification et d’opposition aux données personnelles le concernant, en effectuant sa demande écrite et signée, accompagnée d’une copie du titre d’identité avec signature du titulaire de la pièce, en précisant l’adresse à laquelle la réponse doit être envoyée.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Aucune information personnelle de l\'utilisateur du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;n\'est publiée à l\'insu de l\'utilisateur, échangée, transférée, cédée ou vendue sur un support quelconque à des tiers. Seule l\'hypothèse du rachat de Nom de mon serveur et de ses droits permettrait la transmission des dites informations à l\'éventuel acquéreur qui serait à son tour tenu de la même obligation de conservation et de modification des données vis à vis de l\'utilisateur du site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"color: rgb(119, 119, 119); text-decoration: none;\">www.monsite.fr</a>.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le site n\'est pas déclaré à la CNIL car il ne recueille pas d\'informations personnelles. .</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Les bases de données sont protégées par les dispositions de la loi du 1er juillet 1998 transposant la directive 96/9 du 11 mars 1996 relative à la protection juridique des bases de données.</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">8. Liens hypertextes et cookies.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"color: rgb(119, 119, 119); text-decoration: none;\">www.monsite.fr</a>&nbsp;contient un certain nombre de liens hypertextes vers d’autres sites, mis en place avec l’autorisation de Nom de mon serveur. Cependant, Nom de mon serveur n’a pas la possibilité de vérifier le contenu des sites ainsi visités, et n’assumera en conséquence aucune responsabilité de ce fait.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">La navigation sur le site&nbsp;<a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a>&nbsp;est susceptible de provoquer l’installation de cookie(s) sur l’ordinateur de l’utilisateur. Un cookie est un fichier de petite taille, qui ne permet pas l’identification de l’utilisateur, mais qui enregistre des informations relatives à la navigation d’un ordinateur sur un site. Les données ainsi obtenues visent à faciliter la navigation ultérieure sur le site, et ont également vocation à permettre diverses mesures de fréquentation.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Le refus d’installation d’un cookie peut entraîner l’impossibilité d’accéder à certains services. L’utilisateur peut toutefois configurer son ordinateur de la manière suivante, pour refuser l’installation des cookies :</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Sous Internet Explorer : onglet outil (pictogramme en forme de rouage en haut a droite) / options internet. Cliquez sur Confidentialité et choisissez Bloquer tous les cookies. Validez sur Ok.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Sous Firefox : en haut de la fenêtre du navigateur, cliquez sur le bouton Firefox, puis aller dans l\'onglet Options. Cliquer sur l\'onglet Vie privée. Paramétrez les Règles de conservation sur : utiliser les paramètres personnalisés pour l\'historique. Enfin décochez-la pour désactiver les cookies.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Sous Safari : Cliquez en haut à droite du navigateur sur le pictogramme de menu (symbolisé par un rouage). Sélectionnez Paramètres. Cliquez sur Afficher les paramètres avancés. Dans la section \"Confidentialité\", cliquez sur Paramètres de contenu. Dans la section \"Cookies\", vous pouvez bloquer les cookies.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Sous Chrome : Cliquez en haut à droite du navigateur sur le pictogramme de menu (symbolisé par trois lignes horizontales). Sélectionnez Paramètres. Cliquez sur Afficher les paramètres avancés. Dans la section \"Confidentialité\", cliquez sur préférences. Dans l\'onglet \"Confidentialité\", vous pouvez bloquer les cookies.</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">9. Droit applicable et attribution de juridiction.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px;\"><font color=\"#7f7f7f\">Tout litige en relation avec l’utilisation du site&nbsp;</font><a href=\"http://www.monsite.fr/\" title=\"Nom de mon serveur - www.monsite.fr\" style=\"text-decoration: none;\"><font color=\"#cc0000\">www.monsite.fr</font></a><font color=\"#7f7f7f\">&nbsp;est soumis au droit français. Il est fait attribution exclusive de juridiction aux tribunaux compétents de Paris.</font></p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">10. Les principales lois concernées.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Loi n° 78-87 du 6 janvier 1978, notamment modifiée par la loi n° 2004-801 du 6 août 2004 relative à l\'informatique, aux fichiers et aux libertés.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Loi n° 2004-575 du 21 juin 2004 pour la confiance dans l\'économie numérique.</p><h3 style=\"font-family: Raleway; font-size: 24.5px; font-style: normal; font-variant: normal; line-height: 40px; font-weight: normal; margin: 10px 0px; color: rgb(127, 127, 127); text-rendering: optimizelegibility;\">11. Lexique.</h3><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Utilisateur : Internaute se connectant, utilisant le site susnommé.</p><p style=\"font-family: Raleway; font-size: 17px; font-style: normal; font-variant: normal; line-height: 20px; font-weight: normal; margin: 0px 0px 10px; color: rgb(127, 127, 127);\">Informations personnelles : « les informations qui permettent, sous quelque forme que ce soit, directement ou non, l\'identification des personnes physiques auxquelles elles s\'appliquent » (article 4 de la loi n° 78-17 du 6 janvier 1978).</p>', '1394986796');

                ");

                  $probabilites = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `probabilites` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `nom` varchar(50) DEFAULT NULL,
                    `p` varchar(10) DEFAULT NULL,
                    `commande` varchar(100) DEFAULT NULL,
                    `serveur` varchar(25) DEFAULT NULL,
                    `quantite` int(10) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

                  INSERT INTO `probabilites` VALUES ('9', 'Points boutique', '100', 'POINTS 50', 'f', '50');");

                  $requetesall = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `req_boutique` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `nbr_achat` int(11) DEFAULT NULL,
                    `commande` varchar(80) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

                  CREATE TABLE IF NOT EXISTS `req_credit` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `nbr_achat` int(11) DEFAULT NULL,
                    `commande` varchar(80) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

                  $staff = $bdd->exec("
                  CREATE TABLE IF NOT EXISTS `staff` (
                    `id` int(5) NOT NULL AUTO_INCREMENT,
                    `rang` varchar(30) NOT NULL,
                    `pseudo` varchar(50) NOT NULL,
                    `age` int(2) NOT NULL,
                    `role` varchar(50) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;");

                  $vote_ip = $bdd->exec("
                    CREATE TABLE IF NOT EXISTS `vote_ip` (
                      `id` int(5) NOT NULL AUTO_INCREMENT,
                      `ip` varchar(20) NOT NULL,
                      `date_vote` text NOT NULL,
                      `nom` varchar(255) DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `id` (`id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

                  CREATE TABLE IF NOT EXISTS `statistiques` (
                    `id` int(7) NOT NULL AUTO_INCREMENT,
                    `ip` varchar(50) DEFAULT NULL,
                    `date` int(15) DEFAULT NULL,
                    `page` text,
                    `pays` varchar(50) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
                  ");

                    $stats = $bdd->exec("
                    CREATE TABLE IF NOT EXISTS `statistiques` (
                      `id` int(7) NOT NULL AUTO_INCREMENT,
                      `ip` varchar(50) DEFAULT NULL,
                      `date` int(15) DEFAULT NULL,
                      `page` text,
                      `pays` varchar(50) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
                    ");
                    
                    $admin1 = $bdd->exec("
                    CREATE TABLE IF NOT EXISTS `paypal` (
                      `id` int(7) NOT NULL AUTO_INCREMENT,
                      `pseudo` varchar(255) DEFAULT NULL,
                      `offre` varchar(255) DEFAULT NULL,
                      `transaction_number` varchar(255) DEFAULT NULL,
                      `informations` text,
                      `datas` text,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1
                    ");
                    $postit = $bdd->exec("
                    CREATE TABLE `postit` (
                  `id` int(7) NOT NULL AUTO_INCREMENT,
                  `texte` text,
                  `date` int(20) DEFAULT NULL,
                  PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



                    --
                    -- Contenu de la table `postit`
                    --

                    INSERT INTO `postit` (`id`, `texte`, `titre_new`) VALUES(1, 'test1', NULL);
                    INSERT INTO `postit` (`id`, `texte`, `titre_new`) VALUES(2, 'test2', NULL);");
                    $postit = $bdd->exec("

                    CREATE TABLE IF NOT EXISTS `vote_joueurs` (
                      `id` int(7) NOT NULL AUTO_INCREMENT,
                      `user_pseudo` varchar(255) DEFAULT NULL,
                      `nom` varchar(255) DEFAULT NULL,
                      `date` int(16) DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

                    CREATE TABLE IF NOT EXISTS `vote_sites` (
                      `id` int(7) NOT NULL AUTO_INCREMENT,
                      `nom` varchar(255) DEFAULT NULL,
                      `url` text,
                      `temps` int(10) DEFAULT NULL,
                      `image` text,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

                    INSERT INTO `vote_sites` (`id`, `nom`, `url`, `temps`, `image`) VALUES
                    (1, 'Rpg-Paradize', 'http://www.rpg-paradize.com/?page=vote&vote=', 180, '../images/rpg.jpg');

                    CREATE TABLE `logs` (
                      `log_id` int(7) NOT NULL AUTO_INCREMENT,
                      `user_id` int(7) NOT NULL,
                      `log_timestamp` int(15) NOT NULL,
                      `log_ip` varchar(50) NOT NULL,
                      `log_country` varchar(50) DEFAULT NULL,
                      PRIMARY KEY (`log_id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


                    CREATE TABLE `historique_paysafecard` (
                      `id` int(7) NOT NULL AUTO_INCREMENT,
                      `user_pseudo` varchar(255) NOT NULL,
                      `user_id` int(7) DEFAULT NULL,
                      `code` varchar(255) NOT NULL,
                      `date_achat` int(15) NOT NULL,
                      `statut` int(20) NOT NULL DEFAULT '0',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

                    ALTER TABLE boutique ADD `prix_promotion` int(7) NOT NULL DEFAULT '0';
                    ALTER TABLE joueurs ADD `recompenses` int(7) NOT NULL DEFAULT '0';
                    ");

                    if(count($commentaire) == 1 && count($admin) == 1 && count($boutique) == 1 && count($boutique_onglets) == 1 
                    && count($historique) == 1 && count($historique_credit) == 1 && count($historique_echange) == 1 
                    && count($joueurs) == 1 && count($messages) == 1 && count($news) == 1 && count($pages) == 1 
                    && count($probabilites) == 1 && count($requetesall) == 1 && count($staff) == 1 && count($vote_ip) == 1 
                    && count($stats)== 1 && count($admin1) == 1 && count($postit) == 1){
                       echo '<div class="alert alert-success">Les TABLES ont été crées.</div>';
                       echo '<div class="alert alert-success">Etape validée redirection vers la suivante dans 3 secondes</div>';
                       header ("Refresh: 3;URL=../install/liaisonjsonapi.php");

                       echo '<a href="../install/liaisonjsonapi.php" class="btn btn-primary">Etape suivante</a>';

                    }
              }
              catch (Exception $e)
              {
                  echo '<div class="alert alert-danger">Erreur : ' . $e->getMessage().'</div>';
              }

            }

          }?>
            <br><h4><u>Progression de l'installation</u></h4>
            <div class="progress progress-striped active">
                <div class="bar" style="width: 12%;"></div>
              </div><br>

            <div class="alert alert-info">Assurez vous que le fichier configuration/baseDonnees.php soit en mode CHMOD 777 lors de l'installation</div>

            <form action="" method="post">

              <div class="span6">
                <div class="form-group">
                  <label for="">Hôte MySQL</label>
                  <input type="text" class="form-control" name="hote_mysql">
                </div>

                <div class="form-group">
                  <label for="">Login MySQL</label>
                  <input type="text" class="form-control" name="login_mysql">              
                </div>

                <div class="form-group">
                  <label for="">Mot de passe MySQL</label>
                  <input type="password" class="form-control" name="mdp_mysql">              
                </div>

                <div class="form-group">
                  <label for="">Nom de la base MySQL</label>
                  <input type="text" class="form-control" name="nom_mysql">              
                </div>

               <input type="submit" name="etape1" class="btn btn-info" value="Valider">

              </div>
            </form>

            <div class="clear"></div>
        </div>

    <?php require_once("../install/footer.php");?>  

  </div>

  </body>
</html>