<div class="row">
  <div class="large-12 columns">
	  <?php
		
		$modifier = false;
		
		
	  	if (isset($_GET['id'])) {
			
			
			// Get global id
	  		$id_commande = $_GET['id'];
			
			// Grab all data about the commande
			$sql = "SELECT * FROM commande WHERE `id_commande` LIKE :id_commande";
			if (!$stmt = $conn->prepare($sql)) {
				## $log .= "Error: Update Statement invalid.";
			}else{
				## $log.= "Statement prepared.";
				if ($stmt->execute(array(
					':id_commande' => $id_commande
				))) { 
					## $log .= " Select réussie"; 
					$commandeDetails = $stmt->fetch(PDO::FETCH_ASSOC);
				} else { ## $log .= " Select échouée"; 
				}
			}
			
			
			// Grab all the data about the client
			$sql = "SELECT * FROM clients WHERE `no_client` LIKE :id_client";
			if (!$stmt = $conn->prepare($sql)) {
				//echo "Error: Select Client Statement invalid.";
			}else{
				//echo "Statement prepared.";
				if ($stmt->execute(array(
					':id_client' => $commandeDetails['client']
				))) { 
					//echo " Select réussie"; 
					$clientDetails = $stmt->fetch(PDO::FETCH_ASSOC);
				} else { //echo " Select échouée"; 
				}
			}
		} else {
			
			print '<div class="row"><div class="large-12 columns alert alert-box" data-alert-box>Erreur : Aucune commande avec cet ID n\'a été trouvée. Essayez de passer par la page Commandes.</div></div>';
			
		}
	
		
		
	  	?>
	  <h1>La commande n˚ <?php print $commandeDetails['id_commande']; ?></h1>
	  <p>Depuis cette interface vous pouvez visualiser le détail d'une commande précédente.</p>
	  
  </div>

</div>

<div class="row">
	<div class="large-4 columns">
		<div class="panel">
			<h3>Client</h3>
			  <div class="client_details">
			  <ul class="vcard"> 
				  <li class="fn" id="nom_complet_client"><?php print $clientDetails['civilite']." ".$clientDetails['prenom']." ".strtoupper($clientDetails['nom']); ?></li> 
				  <li class="street-address" id="adresse_client"><?php print $clientDetails['adresse']; ?></li> 
				  <li><span class="zip" id="code_postal_client"><?php print $clientDetails['code_postal']; ?></span> <?php print $clientDetails['ville']; ?><span class="city" id="ville_client"></span></li> 
				  <li class="email" id="email_client"><?php print $clientDetails['email']; ?></li> 
				  <li class="telephone" id="telephone_client"><?php print $clientDetails['tel']; ?></li> 
				  
			  </ul>		  
		  </div>
		</div>
	</div>
	<div class="large-8 columns">
		<div class="row">
			<div class="large-12 columns">
				<h3>Détails de la commande</h3>
				<p><strong>Statut de la commande :</strong> <?php print $commandeDetails['statut'];?><?php if ($commandeDetails['statut'] == "En attente des stocks") { print '&nbsp;<small><a data-reveal-id="valider-modal"">Valider la commande</a></small>';}?></p>
				<div data-reveal class="reveal-modal small" id="valider-modal">
					<h2>Valider cette commande</h2>
					<p>Cette commande a été mise en attente parce que certains médicaments n'étaient pas disponible. La liste des médicaments et de leurs stocks est disponible ci-dessus. Si les stocks sont disponibles, vous pouvez valider cette commande, et elle sera alors confirmée. </p>
					<table>
						<thead>
							<th>Nom du médicament</th>
							<th>Qté commandée</th>
							<th>Qté actuellement en stock</th>
					<?php
					
					// Get all medicaments attached to this commande
					$understockCount = 0;
					$sql = "SELECT `id_med`, `qte` FROM commande_medicaments WHERE `id_commande` LIKE :id_commande";
					if (!$stmt = $conn->prepare($sql)) {
						//echo "Error: Select Meds Statement invalid.";
					}else{
						//echo "Statement prepared.";
						if ($stmt->execute(array(
							':id_commande' => $commandeDetails['id_commande']
						))) { 
							//echo " Select réussie"; 
							$meds = $stmt->fetchAll();
						} else { //echo " Select échouée"; 
						}
						// for each med, grab the details from the database
						foreach ($meds as $med) {
							$sql = "SELECT `nom_med`, `stock` FROM medicament WHERE `id_med` LIKE :id_med";
							if (!$stmt = $conn->prepare($sql)) {
								//echo "Error: Select Med Statement invalid.";
							}else{
								//echo "Statement prepared.";
								//echo $med['id_med'].".";
								if ($stmt->execute(array(
									':id_med' => $med['id_med']
								))) { 
									//echo " Select réussie"; 
									$results = $stmt->fetch(PDO::FETCH_ASSOC);
									$med['nom_med'] = $results['nom_med'];
									$med['stock'] = $results['stock'];
									
									if (intval($med['qte']) > intval($med['stock'])) {
										$color = 'style="color: red;"';
										$understockCount += 1;
									} else {
										$color = 'style="color: #68B35C;"';
									}
									
									
								print "<tr><td>".$med['nom_med']."</td><td>".$med['qte']."</td><td ".$color."><strong>".$med['stock']."</td></tr>";	
							} else { //echo " Select des noms des meds échouée"; 
								} 
							}
						}
						
						
						// If there are understocks, do not allow validation
						
					}
					?>
				</table>
				<?php if ($understockCount>0) {
							print "<p>Certains médicaments dans cette commande ne sont toujours pas disponibles. Vous ne pouvez valider cette commande qu'à partir du moment où tous les médicaments sont disponibles.</p>";
							print '<a class="close-reveal-modal">Fermer</a>';
						} else {
							print "<p>Tous les articles de cette commande sont disponibles.</p>";
							print '<a class="close-reveal-modal">Fermer</a>';
							print '<a id="valider-commande" class="button success">Valider >></a>';
						}
						?>
				
						<div id="success">
						</div>
				</div>
				<table id="liste-meds" class="large-12 columns">
					<thead>
						<th>Nom du médicament</th>
						<th>Qté commandée</th>
						<th>PU</th>
						<th>Sous-total</th>
					</thead>
					
					<tbody>
						<?php
						
						// Grab all the ids of the meds attached 
						$sql = "SELECT `id_med`, `qte` FROM commande_medicaments WHERE `id_commande` LIKE :id_commande";
						if (!$stmt = $conn->prepare($sql)) {
							//echo "Error: Select Meds Statement invalid.";
						}else{
							//echo "Statement prepared.";
							if ($stmt->execute(array(
								':id_commande' => $commandeDetails['id_commande']
							))) { 
								//echo " Select réussie"; 
								$meds = $stmt->fetchAll();
							} else { //echo " Select échouée"; 
							}
							// for each med, grab the details from the database
							$prix_total = 0;
							foreach ($meds as $med) {
								$sql = "SELECT `nom_med`, `prix` FROM medicament WHERE `id_med` LIKE :id_med";
								if (!$stmt = $conn->prepare($sql)) {
									//echo "Error: Select Med Statement invalid.";
								}else{
									//echo "Statement prepared.";
									//echo $med['id_med'].".";
									if ($stmt->execute(array(
										':id_med' => $med['id_med']
									))) { 
										//echo " Select réussie"; 
										$results = $stmt->fetch(PDO::FETCH_ASSOC);
										$med['nom_med'] = $results['nom_med'];
										$med['prix'] = $results['prix'];
										
										
										
									print "<tr><td>".$med['nom_med']."</td><td>".$med['qte']."</td><td>".number_format($med['prix'],2)." € </td><td><strong>".number_format($med['prix']*$med['qte'],2)." € </td></tr>";	
									$prix_total += floatval($med['prix']) * intval($med['qte']);
									} else { //echo " Select des noms des meds échouée"; 
									} 
								}
							}
							
						}
						
						?>
					</tbody>
					<tfoot>
						<td colspan="3" class="text-right"><strong>Total de la commande</strong></td>
						<td><?php echo number_format($prix_total,2); ?> € </td>
					</tfoot>
				</table>
				<p><em>Montant réglé par : </em><strong><?php
				
					if ($commandeDetails['mode_reglement'] == "cb") {
						print "Carte Bancaire";
					} else if ($commandeDetails['mode_reglement'] == "cheque"){
						print "Chèque";
					} else if ($commandeDetails['mode_reglement'] == "cheque"){
						print "Espèces";
					} else {
						print "Autre";
					}
				?>
			</strong></p>
			</div>
		</div>
	</div>
</div>

<div id="detail" class="hide">
</div>
	

<script>

$(document).ready(function(){
	
	$('#valider-commande').click(function(){
		id_commande = "<?php echo $_GET['id'] ;?>";
		meds = <?php echo json_encode($meds);?>;
		$.post('ajax/valider-commande.php',{id_commande: id_commande, meds:meds}).done(function(data){
			console.log(data);
			$data = $.parseJSON(data);
			if ($data.success == 1) {
				$('#success').append('<div class="alert-box success" data-alert-box> Commande validée ! </div>');
				var delay = 800; //Your delay in milliseconds
				setTimeout(function(){ window.location = 'index.php?page=visualiser-commande&id='+$data['id_commande']; }, delay);
			} else {
				$('#success').append('<div class="alert-box error" data-alert-box> Une erreur s\'est produite !</div>');
			}
		})
	})
	

});

</script>