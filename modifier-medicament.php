<div class="row">
  <div class="large-6 push-3 columns">
	  <?php
		
		$modifier = false;
		
		
	  	if (isset($_GET['id'])) {
			
			// Persistant variables
			$DBdata = null;
			$modifier = null;
			
			// Get global id
	  		$idMed = $_GET['id'];
			
			
	  		$sql = "SELECT COUNT(*) FROM medicament WHERE `id_med` LIKE '$idMed' ";
	  		if ($res = $conn->query($sql)) {
	  			if( $res->fetchColumn() > 0) {
	  				$modifier = true;
					
					$sql = "SELECT * FROM medicament WHERE `id_med` LIKE :id_med";
					if ($stmt = $conn->prepare($sql)) {
						if ($stmt->execute(array(
							':id_med' => $idMed
						))) { 
							$DBdata = $stmt->fetch(PDO::FETCH_ASSOC);
						} else { ## $log .= " Select échouée"; 
						}
					}
					
	  			} else {
	  				print "<div data-alert class=\"alert-box alert\" id=\"client-alert-box\">
			  		  		Erreur : Le médicament avec l'ID $idMed n'est pas dans la base.
		  		  			</div>";
							$modifier = false;
	  			}
	  		}

	  		    /* Check the number of rows that match the SELECT statement */
		  
	  		}

	  		$res = null;
	
		
		
	  	?>
	  <h1><?php if ($modifier == true) { print 'Modifier : ' . $DBdata['nom_med']; } else { print 'Nouveau médicament';}?></h1>
	  <h2><small><?php if ($modifier == true) { print 'ID : ' . $DBdata['id_med']; }?></small></h2>
	  <p>Depuis cette interface vous pouvez Créer ou modifier des médicaments</p>
	  
  </div>

</div>


<div class="row">
	<div class="large-6 columns">
		<h2><?php if ($modifier == true) { print $DBdata['nom_med'];} else { print "Nouveau medicament";}?></h2>
	</div>
</div>
<form id="form-med" method="POST">
<div class="row">

	  <div class="large-4 columns">
		   <label>ID <?php if ($modifier == true) { print '(non modifiable)';} ?></label>
		  <input id="id_med_field" name="id_med" style="" type="text" placeholder="ID (10 chifres)" <?php if ($modifier == true) { print 'readonly';} ?> value="<?php if ($modifier == true) { print $DBdata['id_med'];};?>">
	  </div>
	  <div class="large-4 columns">
		   <label>Equivalent Générique</label>
		  <input id="equiv_generique" name="equiv_generique" type="text" placeholder="Générique" value="<?php if ($modifier == true) { print $DBdata['equiv_generique'];};?>"><br>
	  </div>
	  <div class="large-4 columns">
		  <label>Fournisseur</label>
		  <span id="jq_fournisseur" class="hide"><?php if ($modifier == true) { print $DBdata['fournisseur'];}?></span>
		  <select id="id_fournisseur" name="fournisseur">
			  <?php
			  $sql = 'SELECT `id_fournisseur`, `nom_fournisseur` FROM fournisseur';
			  foreach ($conn->query($sql) as $row) {
				  print '<option value="' . $row['id_fournisseur'] . '">' . $row['nom_fournisseur'] . '</option>'; // Fill out all fournisseurs in a drop-down
			  }
			  ?>
		  </select>
	  </div>
</div>

<div class="row">
	
	<div class="large-4 columns">
		 <label>Nom du médicament</label>
		<input id="nom_med_field" name="nom_med" style="" type="text" placeholder="Nom" value="<?php if ($modifier == true) { print $DBdata['nom_med'];}?>"><br>
	</div>
	<div class="large-4 columns">
		 <label>Agents actifs</label>
		<input id="agents_actifs" name="agents_actifs" type="text" placeholder="Agent(s) Actif" value="<?php if ($modifier == true) { print $DBdata['agents_actifs'];}?>"><br>
	</div>
	<div class="large-2 columns">
		 <label>Prix</label>
		<div class="row collapse">
			<div class="small-3 columns">
				<span class="prefix">€</span>
			</div>
			<div class="small-9 columns">
				<input id="prix" name="prix" type="number" size="2" placeholder="Prix" value="<?php if ($modifier == true) { print $DBdata['prix'];}?>">
			</div>
		</div>
	</div>
	<div class="large-2 columns">
		 <label>Stock</label>
		<input id="stock" name="stock" type="number" size="2" placeholder="Stock" value="<?php if ($modifier == true) { print $DBdata['stock'];}?>">
	</div>
</div>
<div class="row">
	<div class="large-4 push-4 columns">
		 <label>Maladie traitée (Indications)</label>
	    <input id="maladie_traitee" name="maladie_traitee" type="text" placeholder="Indications" value="<?php if ($modifier == true) { print $DBdata['maladie_traitee'];}?>">
	</div>
	<a href="javascript:void(0)" id="<?php if ($modifier == true) { print "update"; } else { print "ajouter"; }?>"class="large-4 columns button alert radius"><?php if ($modifier == true) { print "Modifier"; } else { print "Ajouter"; }?></a>
</div>
</form>
<div class="row">
<div data-alert id="outcome" class="large-12 columns alert-box success" style="display:none;">
	<a href="#" class="close">&times;</a>
</div>
</div>
	

<script>

$(document).ready(function(){
	
	//Switch fournisseur to correct fournisseur
	var id_fournisseur = $('#jq_fournisseur').text().trim();
	$('#id_fournisseur option[value=' + id_fournisseur + ']').prop('selected', true);
	
	
	//Update existing medicament
	$('#update').click(function(){
		var formData = $('#form-med').serialize();
		console.log(formData);
		$.ajax( {
			type: "POST",
			url: 'ajax/update-med.php',
			data: formData,
			dataType:"json",
			success: function(data){
			if( $data = $.parseJSON(data) ) {
				$('#outcome').prepend('Modifications apportées au médicament : ' + $data['nom_med']).fadeIn()
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
	})
	
});

</script>