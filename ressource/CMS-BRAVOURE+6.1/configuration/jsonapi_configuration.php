
                <?php
                        // Ajout du fichier JSONAPI
                        require_once ("JSONAPI.php");
                          
                        ####### CONFIGURATION
                        $var_salt_1 = ""; // cryptage
                        $var_ip_1 = "";
                        $var_user_1 = "";
                        $var_mdp_1 = "";
                        $var_port_1 = "";
                       
                        ####### A NE PAS SUPPRIMER 
                          
                        $connexion_1 = new JSONAPI($var_ip_1, $var_port_1, $var_user_1, $var_mdp_1, $var_salt_1);
                          
                        $server1 = $connexion_1->call("getPlayerCount"); 
                        $server1_limit = $connexion_1->call("getPlayerLimit");
						$server1_membre = $connexion_1->call("getPlayerNames");
                ?>
                