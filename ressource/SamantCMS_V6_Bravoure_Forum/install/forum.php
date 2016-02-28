<?php
require_once("../configuration/baseDonnees.php");

    $support = $bdd->exec("

      CREATE TABLE IF NOT EXISTS `categories` (
        `id` int(7) NOT NULL AUTO_INCREMENT,
        `overid` int(7) DEFAULT NULL,
        `titre` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



      CREATE TABLE IF NOT EXISTS `derniers_commentaires` (
        `id` int(7) NOT NULL AUTO_INCREMENT,
        `overid` int(7) DEFAULT NULL,
        `sous_categorie` varchar(255) DEFAULT NULL,
        `topic_titre` varchar(255) DEFAULT NULL,
        `user_id` int(7) DEFAULT NULL,
        `user_pseudo` varchar(255) DEFAULT NULL,
        `date` int(15) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;



      CREATE TABLE IF NOT EXISTS `sous_categories` (
        `id` int(7) NOT NULL AUTO_INCREMENT,
        `overid` int(15) DEFAULT NULL,
        `id_categorie` int(7) DEFAULT NULL,
        `nom` varchar(255) DEFAULT NULL,
        `description` varchar(255) DEFAULT NULL,
        `background` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


      CREATE TABLE IF NOT EXISTS `topics` (
        `id` int(7) NOT NULL AUTO_INCREMENT,
        `sous_categorie` varchar(255) DEFAULT NULL,
        `titre` varchar(255) DEFAULT NULL,
        `texte` text,
        `date` int(15) DEFAULT NULL,
        `user_id` int(7) DEFAULT NULL,
        `importance` varchar(255) DEFAULT NULL,
        `locked` int(5) DEFAULT '0',
        `prefix` int(10) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;


      CREATE TABLE IF NOT EXISTS `topics_comments` (
        `id` int(7) NOT NULL AUTO_INCREMENT,
        `topic_id` int(7) DEFAULT NULL,
        `user_id` int(7) DEFAULT NULL,
        `date` int(15) DEFAULT NULL,
        `texte` text,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;


    ");

    if(count($support) == 1) echo '- <font color="green">TABLES du support ont bien été ajouté !</font> <br>';



  unlink('../install/forum.php');
