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
			
			print '<div class="row"><div class="large-12 columns alert alert-box" data-alert-box>Erreur : Aucune ID de commande trouvé. Essayer de passer par la page Commandes</div></div>';
			
		}
	
		
		
	  	?>
	  <h1>La commande n˚ <?php print $commandeDetails['id_commande']; ?></h1>
	  <p>Depuis cette interface vous pouvez visualiser le détail d'une commande précédentes</p>
	  
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
				<h3>Détail de la commande</h3>
				<table id="liste-meds" class="large-12 columns">
					<thead>
						<th>Nom du médicament</th>
						<th>Qté commandée</th>
						<th>PU</th>
						<th>Sous-total</th>
					</thead>
					<tfoot>
						<td colspan="3" class="text-right"><strong>Total de la commande</strong></td>
						<td>#prix</td>
					</tfoot>
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
									} else { //echo " Select des noms des meds échouée"; 
									} 
								}
							}
							
						}
						
						?>
					</tbody>
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
			</strong>
			</div>
		</div>
	</div>
</div>

<div id="detail" class="hide">
</div>
	

<script>

$(document).ready(function(){
	
	//Switch to blank on load if no ID, else switch to correct ID(dropdown)
	function the_ID() {
	    var iD = "<?php  if (isset($_GET['id'])) { echo $_GET['id'];}  ?>";
	    if (iD.length > 1) {
			return iD
		} else {
			return false;
		}
	}
	
	// Function pour charger la page correspondante
	function ajaxLoadMed() {
		if ($('#med-dropdown').val() != "blanc") {
			var dropdown_id = $('#med-dropdown').val()
			if (dropdown_id.length > 0 && dropdown_id != "nouveau" ) {			
				$('#detail').hide().load('ajax/ajouter-medicament.php?id='+ dropdown_id ).fadeIn();
			} else {
				$('#detail').hide().load('ajax/ajouter-medicament.php').fadeIn();
			}
		} else { 
			$('#detail').fadeOut();
		}
	}
	
	// au début, select the correct dropdown and charge the appropriate page
	if (the_ID()) {
		$('#med-dropdown option[value="'+the_ID()+'"]').prop('selected',true);
		ajaxLoadMed();
	} else {
		$('#med-dropdown option[value="blanc"]').prop('selected',true);
		ajaxLoadMed();
	}
	
	
	//Open saisie 'Nouveau med' si on clique sur 'nouveau' dans le dropdown
	
	$('#med-dropdown').change(function(){
		ajaxLoadMed()
		
	});
	

});

</script>