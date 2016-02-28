<div id="voter" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h3 id="myModalLabel">Les récompenses</h3>
								</div>
								<div class="modal-body">
									<p><table class="table table-striped">
					<?php

					$calcul = $bdd->prepare ("SELECT SUM(p) AS TOTAL FROM probabilites");
					$calcul->execute();
					$sum = $calcul->fetch(PDO::FETCH_OBJ);

						$req = $bdd->prepare ("SELECT * FROM probabilites");
						$req->execute();
						$i = 1;

						while($resultats = $req->fetch(PDO::FETCH_OBJ))
						{
							$pourcentage = ($resultats->p/$sum->TOTAL) * 100;
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $resultats->quantite; ?> <?php echo $resultats->nom; ?></td>
								<td><?php echo round($pourcentage, 0); ?></td>
							</tr>
		              		<?php
		              		$i++;
		              	}
		              	?>
		            </table></p>
								</div>
								<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
									<button href="../voter/classement.php" class="btn btn-primary">Classement</button>
								</div>
							</div>