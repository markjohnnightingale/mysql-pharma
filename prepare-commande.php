<div class="row">
   
  <div class="large-6 push-3 columns">
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
			  <a href="#" class="close">&times;</a>
		  </div>
		</div>
	</div>
	<div class="large-8 columns">
		<div class="row">
			<div class="large-12 columns">
				<h3>Votre commande</h3>
		  		  <div data-alert class="alert-box" id="med-alert-box">
		  			  Ajouter des médicaments
		  			  <a href="#" class="close">&times;</a>
		  		  </div>
				<table id="liste-meds" class="hide">
					<!-- Table to list the current command -->
				</table>
			</div>
		</div>
		<div class="row">
			<div class="panel large-12 columns">
				<h4>Ajouter à la commande</h4>
				<div class="row">
					<div class="large-6 columns">
						#Drop down for medicine
					</div>
					<div class="large-2 columns">
						#Price
					</div>
					<div class="large-2 columns">
						#Stock
					</div>
					<button type="submit" class="large-2 button alert radius tiny columns">Ajouter</a>
				</div>
			</div>
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
					var $clientData = $.parseJSON(data);
					console.log('ID: ' + $clientData['nom'].toUpperCase());
					$('#nom_complet_client').text($clientData['civilite'] + ' ' + $clientData['prenom']+ ' ' + $clientData['nom'].toUpperCase() );
					$('#adresse_client').text($clientData['adresse']);
					$('#code_postal_client').text($clientData['code_postal']);
					$('#ville_client').text($clientData['ville'].toUpperCase());
					$('#email_client').text($clientData['email'].toLowerCase());
					$('.client_details').show();
					
				
				});
		} else {
			$('#client-alert-box').show();
			$('.client_details').hide();
		}
	});
	
});

</script>