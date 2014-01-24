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
	  <p>Depuis cette interface vous pouvez visualiser ou modifier des médicaments</p>
	  
  </div>

</div>

<div class="row">
	<div class="large-4 columns text-right">
		<label class="inline">Séléctionner un médicament</label>
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
	
	//Switch fournisseur to correct fournisseur
	//var id_fournisseur = $('#jq_fournisseur').text().trim();
	//$('#id_fournisseur option[value=' + id_fournisseur + ']').prop('selected', true);
	
	
	//Update existing medicament
	/*$('#update').click(function(){
		var formData = $('#form-med').serialize();
		console.log(formData);
		$.ajax( {
			type: "POST",
			url: 'ajax/update-med.php',
			data: formData,
			dataType:"json",
			success: function(data){
				console.log(data);
			if( $data = $.parseJSON(data) ) {
				$('#outcome').prepend('Modifications apportées au médicament : ' + $data['id_med']).fadeIn()
				return false;
			} else {
				$('#outcome').prepend('Error !').removeClass('success').addClass('failure').fadeIn();
				return false;
			}},
			error: function(data){
				$('#outcome').prepend('Error !' + data).removeClass('success').addClass('alert').fadeIn();
				return false;
				
			}
		}
		
		)
	})*/
	
});

</script>