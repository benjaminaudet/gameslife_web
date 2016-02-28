<?php
session_start();
  header('Content-type: text/html; charset=utf-8');
  
  //----------------------------------//
  require_once 'database/mysql.php';
  set_session($bdd);
  //----------------------------------//
  
  if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) 
  {
  	if($_GET['show'] == 1)
  	{
  		$i=1;

		?>
		<table id="inbox-table" class="table table-striped table-hover">
			<tbody>

			<?php
    $h_minuit = date("H");
    $min_minuit = date("i");
    $p1 = time() - ($h_minuit * 3600 + $min_minuit * 60);
    $p2 = time();
    
    $requete = $bdd->prepare('SELECT * FROM historique WHERE date_achat BETWEEN "'.$p1.'" AND "'.$p2.'" ORDER BY id DESC limit 0,5');
    $requete->execute();
            
            while($resultats = $requete->fetch(PDO::FETCH_OBJ))
            {	
                $raq = $bdd->prepare("SELECT nom, prix, serveur FROM boutique WHERE id = '".$resultats->nom_offre."'");
                $raq->execute();
                $boutique=$raq->fetch();		
	  			?>
					
					<tr>
														
						<td class="inbox-table-icon"></td>

							<td>
								<div>
									<?php echo strtoupper($resultats->joueur) . '  <i>' . $resultats->adresse_ip.'</i>'; ?>
								</div>
							</td>
						
						<td>
							<div>
								<?php echo '<span>le '.date('d/m/Y', $resultats->date_achat).' à '.date('H:i', $resultats->date_achat).' - Achat : <b>'.$boutique['nom'].'</b> </span>'; ?>
							</div>
						</td>


						<td>
							<div>
								<?php echo date('d-m-Y à H:i', $resultats->date_achat); ?>
							</div>
						</td>
					
					</tr>
	  			<?php
  			}
  			?>
			</tbody>
		</table>

		<br>

  			<?php
  	}
  	if($_GET['show'] == 2)
	{
?>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th style="width:15%">Titre</th>
				<th style="width:20%">Date</th>
			</tr>
		</thead>

		<tbody>
		<?php
		$requete = $bdd->prepare("SELECT * FROM news ORDER BY id ASC LIMIT 10");
		$requete->execute();
			                                            
			while($resultats = $requete->fetch(PDO::FETCH_OBJ))
			{
			?>
					<tr onclick="window.location='nouvelles-editer.php?id=<?php echo $resultats->id; ?>'" style="cursor:pointer;">
					<?php
						echo '<td>'.$resultats->titre.'</td>';
						echo '<td>le '.date("d/m/Y", $resultats->date).'</td>';
					echo '</tr>';
			}
		?>
		</tbody>
	</table>
<?php
	}
}
?>