<div class="row">

  <div class="large-6 push-3 columns">
	  <h1>Afficher les stocks</h1>
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
		  <tbody>
			  <tr>
				  <td>Doliprane <span class="secondary radius label">ID: DOL1548754</span></td>
				  <td>Paracétamol</td>
				  <td>Paracétamol</td>
				  <td>Douleurs</td>
				  <td>Galxosmithcline</td>
				  <td>€ 4.20</td>
				  <td>5</td>
				  <td><a href="#" class="button tiny radius">Commander</a></td>
			  </tr>
			  <tr>
				  <td>Doliprane <span class="secondary radius label">ID: DOL1548754</span></td>
				  <td>Paracétamol</td>
				  <td>Paracétamol</td>
				  <td>Douleurs</td>
				  <td>Galxosmithcline</td>
				  <td>€ 4.20</td>
				  <td>0 <span class="alert round label">hors stock</span></td>
				  <td><a href="#" class="button alert tiny radius">Commander</a></td>
				  
			  </tr>
			  <tr>
				  <td>Doliprane <span class="secondary radius label">ID: DOL1548754</span></td>
				  <td>Paracétamol</td>
				  <td>Paracétamol</td>
				  <td>Douleurs</td>
				  <td>Galxosmithcline</td>
				  <td>€ 4.20</td>
				  <td>5</td>
				  <td><a href="#" class="button tiny radius">Commander</a></td>
				  
			  </tr>
			  <thead>
				  <th colspan="12" class="text-center">Ajouter à la base</th>
			  </thead>
			  <tr>
				  <form id="add-to-db" method="POST">
					  <td>
						  <label>Nom du médicament</label>
					      <select id="nom_med_menu">
							  
							  <option value=" " selected="selected"> </option>
					          <option value="nouveau">[Nouveau]</option>
							  <?php
							  $sql = 'SELECT `id_med`, `nom_med` FROM medicament';
							  foreach ($conn->query($sql) as $row) {
								  print '<option value="' . $row['id_med'] . '">' . $row['nom_med'] . '</option>';
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
								  print '<option value="' . $row['id_fournisseur'] . '">' . $row['nom_fournisseur'] . '</option>';
							  }
							  ?>
						  </select>
					  </td>
					  <td><input id="prix" name="prix" type="number" size="2" placeholder="Prix"></td>
					  <td><input id="stock" name="stock" type="number" size="2" placeholder="Stock"></td>
					  <td><button type="submit" class="button alert tiny radius">Ajouter</a></td>
				  </form>
			  </tr>
		  </tbody>
	  </table>
	  <div id="outcome" data-alert class="alert-box" style="display: none;">
		  <a href="#" class="close">&times;</a>
	  </div>
  </div>

</div>
<script>
$(document).ready(function(){
	$('#nom_med_menu').change(function(){
		if ($(this).val() != " "){
			if ($(this).val() != "nouveau") {
				$('#id_med_field').val( $(this).val() ).hide();
				$('#nom_med_field').val( $(this).children('option[value='+$(this).val()+']').text().trim() ).hide();
				$('#equiv_generique, #agents_actifs, #maladie_traitee, #prix, #id_fournisseur').prop('disabled', true);
			} else {
				$('#id_med_field').show().val('');
				$('#nom_med_field').show().val('');
				$('#equiv_generique, #agents_actifs, #maladie_traitee, #prix, #id_fournisseur').prop('disabled', false);
				
			}
		}
	})
	$('#add-to-db').on('submit',function(){
		$.ajax({
		  url:'inserer-medicament-ajax.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success:function(data){
			  $('#outcome').prepend(data).fadeIn();
		   }
		});
		
		return false;
	});
	
});
</script>