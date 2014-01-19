<div class="row">

  <div class="large-6 push-3 columns">
	  <h1>Gérer les stocks</h1>
	  <p>Depuis cette interface vous povuez gérer et ajouter aux stocks de votre magasin.</p>
  </div>

</div>



<div class="row">

  <div class="large-12 columns">
	  <table>
		  <thead>
			  <tr>
				  <th>Nom du médicament</th>
				  <th>Générique</th>
				  <th>Agents actifs</th>
				  <th>Indications</th>
				  <th>Nom du fournisseur</th>
				  <th width="100">Prix</th>
				  <th>Stock</th>
				  <th>Commander</th>
			  </tr>
		  </thead>
		  <tbody id="ajax-load-list-med">
			  <tr><td colspan=12><div class="windows8">
				  <div id="followingBallsG">
				  <div id="followingBallsG_1" class="followingBallsG">
				  </div>
				  <div id="followingBallsG_2" class="followingBallsG">
				  </div>
				  <div id="followingBallsG_3" class="followingBallsG">
				  </div>
				  <div id="followingBallsG_4" class="followingBallsG">
				  </div>
				  </div></td></tr>
		  </tbody>  
		  <thead>
			  <th colspan="12" class="text-center">Ajouter à la base</th>
		  </thead>
		  <tr>
			  <div id="outcome" data-alert class="alert-box" style="display: none;">
				  <a href="#" class="close">&times;</a>
			  </div>
		  </tr>
		  <tr>
			  <form id="add-to-db" method="POST">
				  <td>
					  <label>Nom du médicament</label>
				      <select id="nom_med_menu">
						  
						  <option value=" " selected="selected"> </option>
				          <option value="nouveau">[Nouveau]</option>
						  <?php
						  $sql = 'SELECT `id_med`, `nom_med` FROM medicament'; // SQL Query
						  foreach ($conn->query($sql) as $row) {
							  print '<option value="' . $row['id_med'] . '">' . $row['nom_med'] . '</option>'; // Fill out all pre-existing medicines
						  }
						  ?>
					  </select>
					  <br>
					  <input id="id_med_field" name="id_med" style="display:none;" type="text" placeholder="ID (10 chifres)">
					  <input id="nom_med_field" name="nom_med" style="display:none;" type="text" placeholder="Nom">
				  </td>
				  <td><input id="equiv_generique" name="equiv_generique" type="text" placeholder="Générique"></td>
				  <td><input id="agents_actifs" name="agents_actifs" type="text" placeholder="Agent(s) Actif"></td>
				  <td><input id="maladie_traitee" name="maladie_traitee" type="text" placeholder="Indications"></td>
				  <td>
					  <select id="id_fournisseur" name="id_fournisseur">
						  <?php
						  $sql = 'SELECT `id_fournisseur`, `nom_fournisseur` FROM fournisseur';
						  foreach ($conn->query($sql) as $row) {
							  print '<option value="' . $row['id_fournisseur'] . '">' . $row['nom_fournisseur'] . '</option>'; // Fill out all fournisseurs in a drop-down
						  }
						  ?>
					  </select>
				  </td>
				  <td><input id="prix" name="prix" type="number" size="2" placeholder="Prix"></td>
				  <td><input id="stock" name="stock" type="number" size="2" placeholder="Stock"></td>
				  <td><button type="submit" class="button alert tiny radius">Ajouter</a></td>
			  </form>
		  </tr>
	  </table>
  </div>

</div>
<script>

$(document).ready(function(){
	
	//Clear the form
	jQuery.fn.emptyMyForm = function(){
	    return this.each(function(){
			if ($(this).val() != " "){
				if ($(this).val() != "nouveau") {
					$('#id_med_field').val( $(this).val() ).hide();
					$('#nom_med_field').val( $(this).children('option[value='+$(this).val()+']').text().trim() ).hide();
					$('#equiv_generique, #agents_actifs, #maladie_traitee, #prix, #id_fournisseur').prop('disabled', true);
				} else {
					$('#id_med_field').show().val('');
					$('#nom_med_field').show().val('');
					$('#equiv_generique, #agents_actifs, #maladie_traitee, #prix, #id_fournisseur').prop('disabled', false).val('');
				
				}
			}
	    });
	};
	$('#nom_med_menu').emptyMyForm();
	$('#nom_med_menu').change(function(){
		$(this).emptyMyForm();
	})
	
	//Grab the table of medicines by Ajax
	$('#ajax-load-list-med').hide().load('ajax/afficher-medicaments.php').fadeIn();
	$('#add-to-db').on('submit',function(){
		$.ajax({
		  url:'ajax/inserer-medicament-ajax.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success:function(data){
			  $('#outcome').prepend(data).fadeIn();
			  $('#ajax-load-list-med').fadeOut().load('ajax/afficher-medicaments.php').fadeIn();
			  
		  	}
		});
		
		return false;
	});
	
	
	
});
</script>