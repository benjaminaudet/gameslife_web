			<div class="login-info">
				
				<span>
					<img src="img/avatars/sunny.png" alt="me" class="online" /> 
					<a href="javascript:void(0);" id="show-shortcut">
						<?php echo $_SESSION['admin']['pseudo']; ?> <i class="fa fa-angle-down"></i>
					</a> 
				</span>

			</div>

			<nav>

				<ul>
					<li <?php if($titre == 'Accueil') echo 'class="active"'; ?>>

						<a href="index.php" title="Dashboard">
							<i class="fa fa-lg fa-fw fa-home"></i> 
							<span class="menu-item-parent">Accueil</span>
						</a>
					</li>

					<li <?php if($titre == 'Payement' OR $titre == 'Configuration') echo 'class="active"'; ?>>

						<a href="#" title="Dashboard">
							<i class="fa fa-lg fa-fw fa-edit"></i> 
							<span class="menu-item-parent">Configuration</span>
						</a>

							<ul>
								<li>
									<a href="configuration.php"><i class="fa fa-plus"></i>Gérer</a>
								</li>

								<li>
									<a href="payement.php"><i class="fa fa-trash-o"></i> Moyen de payement</a>
								</li>
							</ul>

					</li>					

					<li>

						<a href="#" title="Upload">
							<i class="fa fa-lg fa-fw fa-cloud-upload"></i> 
							<span class="menu-item-parent">Upload</span>
						</a>

							<ul>
								<li>
									<a href="upload-ajouter"> Ajouter</a>
								</li>

								<li>
									<a href="upload-gerer"> Gérer</a>
								</li>
							</ul>

					</li>

					<li <?php if($titre == 'Ajouter une nouvelle' OR $titre == 'Gérer les nouvelles') echo 'class="active"'; ?>>

						<a href="#" title="Dashboard">
							<i class="fa fa-lg fa-fw fa-edit"></i> 
							<span class="menu-item-parent">Nouvelles</span>
						</a>

							<ul>
								<li>
									<a href="nouvelles-ajouter.php"><i class="fa fa-plus"></i> Ajouter</a>
								</li>

								<li>
									<a href="nouvelles-gerer.php"><i class="fa fa-trash-o"></i> Gérer</a>
								</li>
							</ul>

					</li>
					
					<li <?php if($titre == 'Boutique' OR $titre == 'Ajouter onglets') echo 'class="active"'; ?>>

						<a href="#" title="Dashboard">
							<i class="fa fa-lg fa-fw fa-shopping-cart"></i> 
							<span class="menu-item-parent">Boutique</span>
						</a>

							<ul>
								<li><a href="boutique.php"><i class="fa fa-cogs"></i> Gérer</a></li>
								<li><a href="promotions.php"><i class="fa fa-flag"></i> Promotions</a></li>
								<li>
									<a href="ajouter-onglets.php"><i class="fa fa-add"></i> Ajouter un onglet</a>
								</li>
							</ul>

					</li>
										
					<li <?php if($titre == 'Admins') echo 'class="active"'; ?>>
						<a href="#">
							<i class="fa fa-lg fa-fw fa-cogs"></i> 
							<span class="menu-item-parent">Admin</span>
						</a>

							<ul>
								<li>
									<a href="admin.php?step=2"><i class="fa fa-gear"></i> Gérer</a>
								</li>
							</ul>
					</li>	
					
					<li <?php if($titre == 'Membres inscrits') echo 'class="active"'; ?>>
						<a href="#">
							<i class="fa fa-lg fa-fw fa fa-group"></i> 
							<span class="menu-item-parent">Membres inscrits</span>
						</a>

							<ul>
								<li>
									<a href="membre-inscrit.php"><i class="fa fa-gear"></i> Gérer</a>
								</li>
							</ul>
					</li>	

					<li <?php if($titre == 'Ajouter récompense' OR $titre == 'Vote') echo 'class="active"'; ?>>

						<a href="ajouter-recompense.php" title="">
							<i class="fa fa-lg fa-fw fa-gift"></i> 
							<span class="menu-item-parent">Récompenses</span>
						</a>
					</li>

					<li>

						<a href="systeme-vote.php" title="">
							<i class="fa fa-lg fa-fw fa-bolt "></i> 
							<span class="menu-item-parent">Système de vote</span>
						</a>
					</li>
			
					<li <?php if($titre == 'Pages' OR $titre == 'Modifier la page') echo 'class="active"'; ?>>
						<a href="pages.php">
							<i class="fa fa-lg fa-fw fa-book"></i> 
							<span class="menu-item-parent">Pages</span>
						</a>
					</li>

					<li <?php if($titre == 'Staff') echo 'class="active"'; ?>>

						<a href="ajouter-staff.php" title="">
							<i class="fa fa-lg fa-fw fa-gift"></i> 
							<span class="menu-item-parent">Staff</span>
						</a>
					</li>
			


					<li <?php if($titre == 'Crédit' OR $titre == 'Achats' OR $titre == 'Echange de points entre membres') echo 'class="active"'; ?>>

						<a href="#" title="">
							<i class="fa fa-lg fa-fw fa-calendar"></i> 
							<span class="menu-item-parent">Historique</span>
						</a>

							<ul>
								<li>
									<a href="credit.php">Crédit</a>
								</li>								

								<li>
									<a href="achats.php"> Achats</a>
								</li>								

								<li>
									<a href="echanges.php"> Échanges</a>
								</li>

								<li>
									<a href="credit_paysafecard.php"> Paysafecard</a>
								</li>	

								<li>
									<a href="credit_paypal.php"> PayPal</a>
								</li>	
							</ul>

					</li>
					

					<li <?php if($titre == 'Ajouter des points boutique' OR $titre == 'Débiter des points boutique') echo 'class="active"'; ?>>

						<a href="#" title="">
							<i class="fa fa-lg fa-fw fa-credit-card"></i> 
							<span class="menu-item-parent">Points</span>
						</a>

							<ul>
								<li>
									<a href="crediter.php">Créditer</a>
								</li>								

								<li>
									<a href="debiter.php"> Débiter</a>
								</li>	
						

							</ul>

					</li>
						
					<li <?php if($titre == 'Modifier les images') echo 'class="active"'; ?>>

						<a href="modifier-images.php" title="">
							<i class="fa fa-lg fa-fw fa-upload"></i> 
							<span class="menu-item-parent">Modifier les images</span>
						</a>
					</li>

				<!--
					<li <?php if($titre == 'Support') echo 'class="active"'; ?>>

						<a href="support.php" title="Support">
							<i class="fa fa-lg fa-fw fa-comment"></i> 
							<span class="menu-item-parent">Support</span>
						</a>
					</li>
				
                  	<li <?php if($titre == 'Forum') echo 'class="active"'; ?>>
						<a href="#">
							<i class="fa fa-lg fa-fw fa-bars"></i> 
							<span class="menu-item-parent">Forum</span>
						</a>

							<ul>
								<li>
									<a href="forum-gerer"><i class="fa fa-flag"></i> Gérer le forum</a>
								</li>

								<li>
									<a href="forum-sujets-gerer"><i class="fa fa-cogs"></i> Gérer les sujets</a>
								</li>
							</ul>
					</li>
				-->

				</ul>
			</nav>


			<span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>
