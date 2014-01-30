<div class="row">
  <div class="large-12 columns">
	  <?php
		
		$modifier = false;
		
		
	  	if (isset($_GET['id'])) {
			
			
			// Get global id
	  		$idFournisseur = $_GET['id'];
			
		}
	
		
		
	  	?>
	  <h1>Visualiser / ajouter un fournisseur</h1>
	  <p>Depuis cette interface vous pouvez visualiser ou modifier des fournisseurs.</p>
	  
  </div>

</div>

<div class="row">
	<div class="large-4 columns text-right">
		<label class="inline">Sélectionner un fournisseur</label>
	</div>
	<div class="large-6 pull-2 columns">
		<select id="dropdown">
			<option value="blanc">&nbsp;&nbsp;&nbsp;</option>
			<option value="nouveau">&nbsp;&nbsp;&nbsp;[nouveau]</option>
			<?php
			$sql = 'SELECT `id_fournisseur`, `nom_fournisseur`, `personne_contact` FROM fournisseur';
			foreach ($conn->query($sql) as $row) {
			  print '<option value="' . $row['id_fournisseur'] . '">' . $row['nom_fournisseur'] . ' ('.$row['personne_contact'].')'; // Fill out all suppliers in a drop-down
			}
			?>
		</select>
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
	function ajaxLoadFournisseur() {
		if ($('#dropdown').val() != "blanc") {
			var dropdown_id = $('#dropdown').val()
			if (dropdown_id.length > 0 && dropdown_id != "nouveau" ) {			
				$('#detail').hide().load('ajax/ajouter-fournisseur.php?id='+ dropdown_id ).fadeIn();
			} else {
				$('#detail').hide().load('ajax/ajouter-fournisseur.php').fadeIn();
			}
		} else { 
			$('#detail').fadeOut();
		}
	}
	
	// au début, select the correct dropdown and charge the appropriate page
	if (the_ID()) {
		$('#dropdown option[value="'+the_ID()+'"]').prop('selected',true);
		ajaxLoadFournisseur();
	} else {
		$('#dropdown option[value="blanc"]').prop('selected',true);
		ajaxLoadFournisseur();
	}
	
	
	//Open saisie 'Nouveau fournisseur' si on clique sur 'nouveau' dans le dropdown
	
	$('#dropdown').change(function(){
		ajaxLoadFournisseur()
		
	});
	
});

</script>