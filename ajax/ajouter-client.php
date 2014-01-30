
	  <?php
		
		$modifier = false;
		
		require "../connect.php";
	  	if (isset($_GET['id'])) {
			
			// Persistant variables
			$DBdata = null;
			
			// Get global id
	  		$idClient = $_GET['id'];
			
			
	  		$sql = "SELECT COUNT(*) FROM clients WHERE `no_client` LIKE '$idClient' ";
	  		if ($res = $conn->query($sql)) {
	  			if( $res->fetchColumn() > 0) {
	  				$modifier = true;
					
					$sql = "SELECT * FROM clients WHERE `no_client` LIKE :no_client";
					if ($stmt = $conn->prepare($sql)) {
						if ($stmt->execute(array(
							':no_client' => $idClient
						))) { 
							$DBdata = $stmt->fetch(PDO::FETCH_ASSOC);
						} else { ## $log .= " Select échouée"; 
						}
					}
					
	  			} else {
	  				print "<div data-alert class=\"alert-box alert\" id=\"client-alert-box\">
			  		  		Erreur : Le client $idClient n'est pas dans la base.
		  		  			</div>";
							$modifier = false;
	  			}
	  		}

	  		    /* Check the number of rows that match the SELECT statement */
		  
	  		}

	  		$res = null;
	
		
		
	  	?>
	  

<div class="row">
	<div class="large-6 columns">
		<h2><?php if ($modifier == true) { print $DBdata['civilite']."&nbsp;".$DBdata['prenom']."&nbsp;".$DBdata['nom'];} else { print "Nouveau client";}?></h2>
	</div>
</div>
<div class="row">
<div data-alert id="outcome" class="large-12 columns alert-box success" style="display:none;">

</div>
</div>
<form id="form-client" method="POST">
<div class="row">

	<div class="large-4 columns">
		   <label>ID <?php if ($modifier == true) { print '(non modifiable)';} ?></label>
		   <input id="no_client_field" name="no_client" style="" type="text" placeholder="ID (10 chifres)" <?php if ($modifier == true) { print 'readonly';} ?> value="<?php if ($modifier == true) { print $DBdata['no_client'];};?>" required>
	</div>
	<div class="large-4 columns">
			<label>Adresse</label>
			<input id="adresse" required name="adresse" type="text" placeholder="Adresse" value="<?php if ($modifier == true) { print $DBdata['adresse'];}?>"><br>
	</div>
	<div class="large-4 columns">
			<label>N° INSEE</label>
			<input id="no_insee" required name="no_insee" type="text" placeholder="N° INSEE" value="<?php if ($modifier == true) { print $DBdata['no_insee'];}?>"><br>
	</div>
</div>

<div class="row">
	
	<div class="large-1 columns">
		 <label>Civilité</label>
		<select id="civilite" required name="civilite" placeholder="Civilité" value="<?php if ($modifier == true) { print $DBdata['civilite'];}?>"><br>
			<option value="Mr.">Mr.</option>
			<option value="Mme">Mme</option>
		</select>
	</div>
	<div class="large-1 columns">
		<label>Prénom</label>
	    <input id="prenom" name="prenom" required type="text" placeholder="Prénom" value="<?php if ($modifier == true) { print $DBdata['prenom'];}?>">
	</div>
	<div class="large-2 columns">
		<label>Nom</label>
	    <input id="nom" name="nom" required type="text" placeholder="Nom" value="<?php if ($modifier == true) { print $DBdata['nom'];}?>">
	</div>
	<div class="large-2 columns">
		 <label>CP</label>
		<input id="code_postal" required name="code_postal" type="text" placeholder="Code Postal" value="<?php if ($modifier == true) { print $DBdata['code_postal'];}?>"><br>
	</div>
	<div class="large-2 columns">
		<label>Ville</label>
		<input id="ville" required name="ville" type="text" placeholder="Ville" value="<?php if ($modifier == true) { print $DBdata['ville'];}?>"><br>
	</div>
	<div class="large-4 columns">
		<label>Caisse</label>
	    <input id="caisse" name="caisse" required type="text" placeholder="Caisse Obligatoire" value="<?php if ($modifier == true) { print $DBdata['caisse'];}?>">
	</div>
</div>
<div class="row">
	<div class="large-4 columns">
		<label>Date de naissance</label>
	    <input id="date_naissance" name="date_naissance" required type="text" placeholder="Date de naissance YYYY-MM-DD" value="<?php if ($modifier == true) { print $DBdata['date_naissance'];}?>">
	</div>
	<div class="large-4 columns">
			<label>Téléphone</label>
			<input id="tel" required name="tel" type="text" placeholder="Téléphone" value="<?php if ($modifier == true) { print $DBdata['tel'];}?>"><br>
	</div>
	<div class="large-4 columns">
		<label>Mutuelle</label>
	    <input id="mutuelle" name="mutuelle" required type="text" placeholder="Mutuelle" value="<?php if ($modifier == true) { print $DBdata['mutuelle'];}?>">
	</div>
</div>
<div class="row">	
	<div class="large-4 columns">
		<label>E-mail</label>
	    <input id="email" name="email" required type="text" placeholder="E-mail" value="<?php if ($modifier == true) { print $DBdata['email'];}?>">
	</div>
	<?php if ($modifier == true) { ?>
		<div class="large-3 columns push-2">
			<a href="javascript:void(0)" id="supprimer" class="large-12 radius button alert">Supprimer</a>
		</div>
	<?php } ?>
			
		<div class="<?php if ($modifier == false) { print ""; }?> large-3 columns">
			<a href="javascript:void(0)" id="<?php if ($modifier == true) { print "update"; } else { print "ajouter"; }?>" class="radius large-12 button"><?php if ($modifier == true) { print "Enregistrer"; } else { print "Ajouter"; }?></a>
		</div>
</div>
</form>

	

<script>

$(document).ready(function(){	
	
	//Submit new if new
	var modifier = "<?php print $modifier; ?>";
	if (modifier == "") {
		$('#ajouter').click(function(){
			$.ajax({
			  url:'ajax/inserer-client-ajax.php',
			  data:$('#form-client').serialize(),
			  type:'POST',
			  success:function(data){
				  $('#outcome').prepend("Le client a été ajouté à la base.").fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-clients'; }, delay);
			  	}
			});
	
			return false;
		});
	} else if (modifier == "1") {
		$('#update').click(function(){
			$.ajax({
			  url:'ajax/update-client.php',
			  data:$('#form-client').serialize(),
			  type:'POST',
			  success:function(data){
				  console.log(data);
				  $data = $.parseJSON(data);
				  console.log($data);
				  $message = "Le client "+$data['no_client']+" a été mis à jour."
				  $('#outcome').prepend($message).fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-clients'; }, delay);
			  	}
			});
	
			return false;
		});
		$('#supprimer').click(function(){
			$.ajax({
			  url:'ajax/sup-client.php',
			  data:$('#form-client').serialize(),
			  type:'POST',
			  success:function(data){					
				  $('#outcome').prepend(data).fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-clients'; }, delay);
			  	}
			});
		})
	}
});

</script>