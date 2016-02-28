<?php                 
   try
    {
      $bdd = new PDO("mysql:host=localhost;dbname=", "root", "");
      $bdd->exec("SET NAMES utf8");
    }
    catch (Exception $e)
    {
      die($e->getMessage());
    }

?>
                