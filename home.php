<div class="row">


  <div class="large-12 columns text-left">
      <h1>Marea</h1>
	  <h2>Gestion commerciale de pharmacie</h2>
  </div>

</div>

<div class="row">


  <div class="large-9 columns">
      <div class="panel"><img src="images/pills.jpg"></div>
  </div>
  <div class="large-3 columns text-right">
	  <div class="panel">
		  <h4>Gestion des médicaments</h4>
		  <p>L'interface de Marea vous permet de gérer tous les médicaments, clients et fournisseurs de votre pharmacie.</p>
	  </div>
	  <div class="panel">
		  <a href="index.php?page=preparer-commande" class="button">Préparer une commande >></a>
	  </div>
  </div>
</div>
<div class="row">


    <div class="large-4 columns">
  	  <div class="panel">
  		  <h4>Médicaments en rupture</h4>
		  <?php
		  
		  $sql = "SELECT `nom_med`, `id_med` FROM medicament WHERE `stock` < 1";
		  if ($meds = $conn->query($sql)) {
			  print '<table width="100%"><tr>';
			  foreach ($meds as $med) {
				  print '<tr class="med_row" id="med_'.$med['id_med'].'"><td>'.$med['nom_med'].'&nbsp;<span class="label alert radius">Rupture de stock</span></td><td><a href="#" class="envoyer-mail button tiny">Demander de nouveaux stocks</a></td></tr>';
			  }
			  print '</tr></table>';
		  } else {
			  print '<div class="alert alert-box">Erreur de requête SQL</div>';
		  }
			
		  ?>
  	  </div>
    </div>
  <div class="large-8 columns">
	  <div class="panel">
		  <div class="row">
		  <div class="large-6 columns">
		  <h4>Je viens de recevoir une livraison :</h4>
		  <a class="button small" href="index.php?page=afficher-catalogue">Mettre à jour la base de données</a>
		  </div>
		  <div class="large-6 columns">
		  <h4>Je veux préparer une commande client :</h4>
		  <a class="button small" href="index.php?page=preparer-commande">Préparer une commande</a>
		  </div>
		  </div>
	  </div>
	  <div class="panel">
		  <h4>Commandes en attente de stocks</h4>
		  <?php
		  
		  $sql = "SELECT `id_commande`, `client`, 'date' FROM commande WHERE `statut` = 'En attente des stocks'";
		  $storeMeds = []  ;
		  
		  if ($commandes = $conn->query($sql)) {
			  print '<table width="100%"><tr>';
			  foreach ($commandes as $commande) {
				  print '<tr id="'.$commande['id_commande'].'"><td><a href="index.php?page=visualiser-commande&id='.$commande['id_commande'].'">N˚ '.$commande['id_commande'].'&nbsp;<span class="label">En attente</span></a></td>';
				  print '<td>';
				  print '<table>
					<thead>
						<th>Nom du médicament</th>
						<th>Qté commandée</th>
						<th>Qté actuellement en stock</th>
					</thead>';
				  
				  
				  
				
				  // Medicaments en attente
				  
				$understockCount = 0;
				$totalUnderstock = 0;
				$sql = "SELECT `id_med`, `qte` FROM commande_medicaments WHERE `id_commande` LIKE :id_commande";
				if (!$stmt = $conn->prepare($sql)) {
					//echo "Error: Select Meds Statement invalid.";
				}else{
					//echo "Statement prepared.";
					if ($stmt->execute(array(
						':id_commande' => $commande['id_commande']
					))) { 
						//echo " Select réussie"; 
						$meds = $stmt->fetchAll();
						$storeMeds[$commande['id_commande']] = $meds;
					} else { //echo " Select échouée"; 
					}
					
					// Save all the meds in an array with the commande ID as index
					$storeMeds[$commande['id_commande']] = $meds;
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
								
								
							print "<tr><td><a href=index.php?page=modifier-medicament&id=".$med['id_med'].">".$med['nom_med']."</a></td><td>".$med['qte']."</td><td ".$color."><strong>".$med['stock']."</td></tr>";	
						} else { //echo " Select des noms des meds échouée"; 
							} 
							
						}
						
					}
	  			  print '</table>';
				  // End meds table
				  if ($understockCount<1) {
				  							print ' Les stocks sont maintenant suffisants pour valider cette commande. <br><br><a id="valider_'.$commande['id_commande'].'" class="button small valider-commande success">Valider >></a>';
				  						}
			  } 
		  }
			  print '</tr></table>';
			  
		 
		  } else {
			  print '<div class="alert alert-box">Erreur de requête SQL</div>';
		  }
			
		  ?>
		  <div id="success"></div>
	  </div>
	  
  </div>
 
</div>


    

<!--Reveal stuff-->
<div id="email-fournisseur" class="reveal-modal" data-reveal> </div>

<script>
$(document).ready(function(){
	
	$('.envoyer-mail').click(function(){
		var understock_meds = [ {id_med: $(this).parents('.med_row').attr('id').substring(4) , qte : "50"} ];
		console.log(understock_meds);
		$('#email-fournisseur').load('ajax/confirm-envoyer-mail-fournisseur-ajax.php',{understock: understock_meds}).foundation('reveal','open');
		return false;
	});
	
	$('.valider-commande').click(function(){
		id_commande = $(this).attr('id').substring(8);
		storeMeds = <?php echo json_encode($storeMeds);?>;
		meds = storeMeds[id_commande];
		//console.log(meds);
		alertify.confirm("Vous allez basculer la commande "+id_commande+" en statut 'validée'. Les médicaments seront décomptés du stock et la commande sera passée. Souhaitez-vous continuer ?", function(e){
			if (e) {
				$.post('ajax/valider-commande.php',{id_commande: id_commande, meds:meds}).done(function(data){
					//console.log(data);
					$data = $.parseJSON(data);
					if ($data.success == 1) {
						$('#success').append('<div class="alert-box success" data-alert-box> Commande validée ! </div>');
						var delay = 800; //Your delay in milliseconds
						setTimeout(function(){ window.location = 'index.php'; }, delay);
					} else {
						$('#success').append('<div class="alert-box error" data-alert-box> Une erreur s\'est produite !</div>');
					}
				});
			}
		});
	});
	

});
</script>
