<div class="row">
  <div class="large-12 columns">
	  <?php
		
		$modifier = false;
		
		
	  	if (isset($_GET['id'])) {
			
			
			// Get global id
	  		$idMed = $_GET['id'];
			
		}
	
		
		
	  	?>
	  <h1>Visualiser / ajouter un médicament</h1>
	  <p>Depuis cette interface vous pouvez visualiser ou modifier des médicaments.</p>
	  
  </div>

</div>

<div class="row">
	<div class="large-4 columns text-right">
		<label class="inline">Sélectionner un médicament</label>
	</div>
	<div class="large-6 pull-2 columns">
		<select id="med-dropdown">
			<option value="blanc">&nbsp;&nbsp;&nbsp;</option>
			<option value="nouveau">&nbsp;&nbsp;&nbsp;[nouveau]</option>
			<?php
			$sql = 'SELECT `id_med`, `nom_med`, `prix` FROM medicament';
			foreach ($conn->query($sql) as $row) {
			  print '<option value="' . $row['id_med'] . '">' . $row['nom_med'] . ' ('.$row['prix']. ' €)'; // Fill out all medicaments in a drop-down
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