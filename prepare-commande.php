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
					<tfoot>
						<td colspan="4" class="text-right"><strong>Total de la commande</strong></td>
						<td><span id="prix-total">0</span>&nbsp;€ </td>
					</tfoot>
					<!-- Table to list the current command -->
				</table>
				<p><small><strong>*</strong> Les stocks de cet/ces article(s) ne sont pas suffisants pour votre commande. Si vous confirmez quand même la commande, des stocks supplémentaires seront commandés.</small></p>
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
		  				  print '<option value="' . $row['id_med'] . '">' . $row['nom_med'] . ' (€ '.number_format($row['prix'],2). ') - '.$row['stock'].' en stock</option>'; // Fill out all medicaments in a drop-down
		  			  }
		  			  ?>
					  </select>
					</div>
					<div class="large-2 columns">
						<input id="quantite" type="number" name="qte" placeholder="Qté" required>
					</div>
					<button id="ajouter" class="large-2 button tiny columns">Ajouter</a
				</div>
			</div>
		</div>
		<div class="row">
			<div class="large-8 columns">
				<div class="panel">
				<h3>Mode de paiement</h3>
	  		  <div data-alert class="alert-box" style="display:none;" id="reglement-alert-box">
	  		  </div>
					<form>
						<input type="radio" name="mode_reglement" id="cb" value="Carte Bancaire"><label for="cb">Carte Bancaire</label><br>
						<input type="radio" name="mode_reglement" id="cheque" value="Chèque"><label for="cheque">Chèque</label><br>
						<input type="radio" name="mode_reglement" id="especes" value="Espèces"><label for="especes">Espèces</label><br>
					</form>
				</div>
			</div>
			<div class="large-4 columns">
				<a id="envoyer" class="button success">Envoyer >></a>
			</div>
		</div>
		<div class="row">
			<div id="" class="large-12 columns">
				<div class="alert-box" id="outcome" data-alert-box style="display:none;"></div>
			</div>
		</div>
		<div id="ask-fournisseur" class="reveal-modal" data-reveal> </div>
		<div id="modifier-commande-conformer" class="reveal-modal" data-reveal> </div>
		<div id="confirm-envoyer-mail-fournisseur" class="reveal-modal" data-reveal> </div>
		
	

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
			console.log("Add: "+id_client);
			//Send id_client
			$.post( "ajax/get-client-ajax.php", { no_client: id_client } )
				.done(function(data){
					if ( $clientData = $.parseJSON(data)) {
					console.log('Added: Client Name: ' + $clientData['nom'].toUpperCase());
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
	var prixTotal = 0;
	
	
	//Function to put item in table
	function addToOrder(id_med) {
		var nom_med = null;
		var prix = null;
		var stock = null;
		$.post( "ajax/get-med-ajax.php", { id_med: id_med } )
			.done(function(data){
				if ( $medData = $.parseJSON(data)) {
					console.log('Added: Med Id: ' + $medData['id_med'].toUpperCase());
					$('#med-alert-box').fadeOut();
					id_med = $medData['id_med'];
					nom_med = $medData['nom_med'];
					prix = parseFloat($medData['prix']);
					stock = parseInt($medData['stock']);
					qte = parseInt($('#quantite').val());
					var before = '<tr id="'+id_med+'">';
					var after = "</tr>";
					var id_med_champ = '<td class="id_med hide">'+id_med+'</td>'
					var nom_med_champ = '<td class="nom_med">'+nom_med+'</td>';
					var prix_champ = '<td><span class="prix">'+Number(prix).toFixed(2)+'</span>&nbsp;€ </td>';
					var stock_champ = '<td class="stock">'+stock+'</td>';
					if (qte > stock) {
						var qte_champ = '<td class="qte"><span class="understock" style="color:#DC3E49; font-weight: bold;">'+qte+'</span>&nbsp; &nbsp;*</td>';
						
					} else {
						var qte_champ = '<td class="qte">'+qte+'</td>';
	
					}
					var bouton_suppr = '<td><a href="javascript:void(0)" class="supprimer button secondary radius tiny">Supprimer</a></td>';
					var ligne_table = before + id_med + nom_med_champ + prix_champ + stock_champ + qte_champ + bouton_suppr + after;
					$('#liste-meds').append(ligne_table).show();
					id_meds.push({id_med: id_med, qte: qte, stock: stock}); // add to array of meds
					prixTotal += parseFloat(prix*qte); // add to total price
					$('#prix-total').text(Number(prixTotal).toFixed(2)); // update total price
					viderChamps();
					
					
				} else {
					$('#med-alert-box').addClass('alert').text("Error d\'exécution.").show();
				}
				
			
			});
	}
	
	//Supprimer line in commande
	$('#liste-meds').on('click','.supprimer',function(){
		
		//Grab line data
		var id_med_to_delete = $(this).parents('tr').attr('id');
		var qte = parseFloat($('#'+id_med_to_delete+' .qte').text());
		var prix = parseFloat($('#'+id_med_to_delete+' .prix').text());
		console.log('Delete : '+id_med_to_delete+' * '+qte+ " @  € "+prix)
		
		
		// Take med out of array
		//var index = id_meds.indexOf(id_med);
		//if (index > -1) {
		//    id_meds.splice(index, 1);
		//}


		id_meds = jQuery.grep(id_meds , function (value) {
		        return value.id_med != id_med_to_delete;
		});

				
		
		//Change total price
		prixTotal -= prix * qte;
		$('#prix-total').text(Number(prixTotal).toFixed(2)); // update total price
		
		
		// Take out of table
		$(this).parents('tr').remove();
	});
	
	
	// On click on Ajouter, add row to table for médoc and check 
	$('#ajouter').click(function(){
		addToOrder($('#med-dropdown').val());
	});
	
	
	// On click set mode_reglement
	var mode_reglement = null;
	$("input:radio[name=mode_reglement]").each(function(){
		$(this).prop('checked', false)
	});
	$("input:radio[name=mode_reglement]").click(function() {
	    mode_reglement = $(this).val();
	});
	
	
	
	// Function to Submit the order
	function envoyerCommande() {
		var id_client = $('#id_client').val();
		console.log("Client: "+id_client+" commande ");
		console.log("Meds: "+id_meds);
		console.log("Paid by :" +mode_reglement);
		console.log("Understock : "+$('.understock').length);				
		if (!id_client.length > 0) {
			$('#client-alert-box').addClass('alert').text('Merci de sélectionner un client').show();
		} else if (!id_meds.length > 0){
			$('#med-alert-box').addClass('alert').text('Merci d\'ajouter des médicaments').show();
		} else if (mode_reglement == null) {
			$('#reglement-alert-box').addClass('alert').text('Merci de sélectionner un moyen de paiement').show();
		} else if ($('.understock').length > 0) {

			//loop through each understock item find ID and qte. Store in array.
			var understock_meds = new Array;
			$('.understock').each(function(){
				var med = {
					id_med: $(this).parents('tr').attr('id'), 
					qte: parseInt( $(this).text() ), 
					stock: parseInt( $(this).parent().siblings('.stock').text() )
				};
				understock_meds.push(med);
				
				console.log(understock_meds);
			});
			
			
			
			// Case if Stock < Quantité voulu
			$('#ask-fournisseur').load('ajax/ask-fournisseur-ajax.php',{meds: id_meds, understock: understock_meds, id_client: id_client, mode_reglement: mode_reglement}).foundation('reveal', 'open');
		
		
		
		} else {
			//Close dialogues and submit form
			$('#client-alert-box').removeClass('alert').text('').hide();
			$('#med-alert-box').removeClass('alert').text('').hide();
			$('#reglement-alert-box').removeClass('alert').text('').hide();
			$.post( "ajax/inserer-commande-ajax.php", { id_client: id_client, id_meds: id_meds, mode_reglement: mode_reglement } )
				.done(function(data){
					console.log(data);
					$data = $.parseJSON(data)
					console.log($data['log']);
					if ($data['status'] > 0) {
						// Actions if success
						$('#outcome').removeClass('alert').addClass('success').text('Votre commande a été enregistrée.').fadeIn();
						var delay = 800; //Your delay in milliseconds
						setTimeout(function(){ window.location = 'index.php?page=visualiser-commande&id='+$data['id_commande']; }, delay)
					} else {
						// Actions if failure
						$('#outcome').removeClass('success').addClass('alert').text('Erreur dans l\'exécution de l\'ajout à la base de données.').fadeIn();
					} 
						
				});
		}
	}
	$('body').on('click','#envoyer',function(){
		envoyerCommande()
	});
	
});

</script>