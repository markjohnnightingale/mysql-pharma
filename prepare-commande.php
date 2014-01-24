<div class="row">
   
  <div class="large-10 push-3 columns">
	  <h1>Préparer une commande</h1>
	  <p>Depuis cette interface vous pouvez préparer une commande client pour des médicaments.</p>
  </div>

</div>

<div class="row">
   
	<div class="large-4 columns">
		<div class="panel">
			<h3>Client</h3>
  		  <select id="id_client" name="id_client">
			  <option value="" selected> </option>
  			  <?php
  			  $sql = 'SELECT `no_client`, `civilite`, `prenom`, `nom` FROM clients';
  			  foreach ($conn->query($sql) as $row) {
  				  print '<option value="' . $row['no_client'] . '">' . $row['civilite'].' '.$row['prenom'].' '.strtoupper($row['nom']). '</option>'; // Fill out all Clients in a drop-down
  			  }
  			  ?>
  		  </select>
		  <div class="client_details hide">
			  <ul class="vcard"> 
				  <li class="fn" id="nom_complet_client"></li> 
				  <li class="street-address" id="adresse_client"></li> 
				  <li><span class="zip" id="code_postal_client"></span> <span class="city" id="ville_client"></span></li> 
				  <li class="email" id="email_client"></li> 
			  </ul>		  
		  </div>
		  <div data-alert class="alert-box" id="client-alert-box">
			  Sélectionnez un client
			  
		  </div>
		</div>
	</div>
	<div class="large-8 columns">
		<div class="row">
			<div class="large-12 columns">
				<h3>Votre commande</h3>
		  		  <div data-alert class="alert-box" id="med-alert-box">
		  			  Ajouter des médicaments
		  		  </div>
				<table id="liste-meds" class="hide large-12 columns">
					<thead>
						<th>Nom du médicament</th>
						<th>Prix</th>
						<th>Stock Disponible</th>
						<th>Qté commandée</th>
						<th>Supprimer</th>
					</thead>
					<!-- Table to list the current command -->
				</table>
			</div>
		</div>
		<div class="row">
			<div class="panel large-12 columns">
				<h4>Ajouter à la commande</h4>
				<div class="row">
					<div class="large-8 columns">
						<select id="med-dropdown">
							<option value="" selected> </option>
		  			  <?php
		  			  $sql = 'SELECT `id_med`, `nom_med`, `prix`, `stock` FROM medicament';
		  			  foreach ($conn->query($sql) as $row) {
		  				  print '<option value="' . $row['id_med'] . '">' . $row['nom_med'] . ' (€ '.$row['prix']. ') - '.$row['stock'].' en stock</option>'; // Fill out all medicaments in a drop-down
		  			  }
		  			  ?>
					  </select>
					</div>
					<div class="large-2 columns">
						<input id="quantite" type="number" name="qte" placeholder="Qté" required>
					</div>
					<button id="ajouter" class="large-2 button radius tiny columns">Ajouter</a>
				</div>
			</div>
		</div>
		<div class="row">
			<a id="envoyer" class="button tiny radius large-4 columns">Envoyer</a>
		</div>
	

</div>

<script>

$(document).ready(function(){
	//Set Dropdown to zero on load
	$('#id_client option[value=""]').prop('selected', true);
	
	
	$('#id_client').change(function(){
		// Remove the alert box
		if ($(this).val() != "") {
			$('#client-alert-box').hide();
			
			var id_client = $('#id_client').val()
			console.log(id_client)
			//Send id_client
			$.post( "ajax/get-client-ajax.php", { no_client: id_client } )
				.done(function(data){
					if ( $clientData = $.parseJSON(data)) {
					console.log('ID: ' + $clientData['nom'].toUpperCase());
					$('#nom_complet_client').text($clientData['civilite'] + ' ' + $clientData['prenom']+ ' ' + $clientData['nom'].toUpperCase() );
					$('#adresse_client').text($clientData['adresse']);
					$('#code_postal_client').text($clientData['code_postal']);
					$('#ville_client').text($clientData['ville'].toUpperCase());
					$('#email_client').text($clientData['email'].toLowerCase());
					$('.client_details').fadeIn();
				} else {
					$('#client-alert-box').text('Erreur de MySQL');
				}
					
				
				});
		} else {
			$('#client-alert-box').show();
			$('.client_details').fadeOut();
		}
	});
	function viderChamps() {
		$('#med-dropdown').val('');
		$('#quantite').val('1');
	}
	//On pageload empty fields
	viderChamps();
	
	// Declare variable for id_meds
	var id_meds = new Array;
	
	
	//Function to put item in table
	function addToOrder(id_med) {
		var nom_med = null;
		var prix = null;
		var stock = null;
		$.post( "ajax/get-med-ajax.php", { id_med: id_med } )
			.done(function(data){
				if ( $medData = $.parseJSON(data)) {
					console.log('ID: ' + $medData['id_med'].toUpperCase());
					$('#med-alert-box').fadeOut();
					id_med = $medData['id_med'];
					nom_med = $medData['nom_med'];
					prix = $medData['prix'];
					stock = $medData['stock'];
					var before = '<tr id="'+id_med+'">';
					var after = "</tr>";
					var id_med_champ = '<td class="id_med hide">'+id_med+'</td>'
					var nom_med_champ = '<td class="nom_med"><a href="#">'+nom_med+'</a></td>';
					var prix_champ = '<td class="prix">'+Number(prix).toFixed(2)+'&nbsp;€ </td>';
					var stock_champ = '<td class="stock">'+stock+'</td>';
					var qte_champ = '<td class="qte">'+$('#quantite').val();+'</td>';
					var bouton_suppr = '<td><a href="javascript:void(0)" class="supprimer button secondary radius tiny">Supprimer</a></td>';
					var ligne_table = before + id_med + nom_med_champ + prix_champ + stock_champ + qte_champ + bouton_suppr + after;
					$('#liste-meds').append(ligne_table).show();
					id_meds.push(id_med);
					viderChamps();
					
					
				} else {
					$('#med-alert-box').addClass('alert').text("Error d'exécution.");
				}
				
			
			});
	}
	
	//Supprimer line in commande
	$('#liste-meds').on('click','.supprimer',function(){
		console.log("delete");
		var id_med = $(this).parents('tr').attr('id')
		console.log(id_med)
		var index = id_meds.indexOf(id_med);
		if (index > -1) {
		    id_meds.splice(index, 1);
		}		
		$(this).parents('tr').remove();
	});
	
	
	// On click on Ajouter, add row to table for médoc and check 
	$('#ajouter').click(function(){
		addToOrder($('#med-dropdown').val());
	});
	
	
	
	
	
	// Function to Submit the order
	function envoyerCommande() {
		var id_client = $('#id_client').val();
		console.log("Client: "+id_client+" commande ");
		console.log(id_meds);
		$.post( "ajax/inserer-commande.php", { id_client: id_client, id_meds: id_meds, mode_reglement: mode_reglement } )
			.done(function(data){
				console.log(data);		
			});
	}
	$('body').on('click','#envoyer',function(){
		envoyerCommande()
	});
	
});

</script>