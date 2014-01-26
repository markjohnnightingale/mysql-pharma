<?php
require "../connect.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);


$sql = 'SELECT `id_med`, `nom_med`, `equiv_generique`,`agents_actifs`,`prix`,`stock`,`fournisseur`,`maladie_traitee` FROM medicament'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<tr id="med_'.$row['id_med'].'">'; // put ID in CSS class to enable selecting specific rows of the table via JS in the form med_ID-GOES-HERE
  print '<td><a href="index.php?page=modifier-medicament&id='.$row['id_med'].'">'.ucwords(strtolower($row['nom_med'])).'</a> <span class="secondary radius label">'.$row['id_med'].'</span></td>'; // Name of medication and ID label
  print '<td>'.$row['equiv_generique'].'</td>';
  print '<td>'.$row['agents_actifs'].'</td>';
  print '<td>'.$row['maladie_traitee'].'</td>';
  $sqlFournisseur = 'SELECT `nom_fournisseur` FROM fournisseur WHERE `id_fournisseur` LIKE \''.$row['fournisseur'].'\'';
  foreach($conn->query($sqlFournisseur) as $rowFournisseur){
  	  print '<td><a href="index.php?page=fournisseur&id='.$row['fournisseur'].'">'.ucwords(strtolower($rowFournisseur['nom_fournisseur'])).'</a></td>'; //Fournisseur ID and encoded into URLso that onclick takes you to page with more details
  };

  print '<td>'.number_format($row['prix'],2).' €</td>';
  // Print stock with hidden modification buttons which enable modification of the stock amount, and a 'save' button which committs those changes to the DB
  print '<td class="stocks">
			<form class="form-update" method="POST" action="ajax/update-stock-ajax.php">
				<label style="visibility:hidden;" class="secondary radius label reduce">-</label>
				<span class="stock">'.$row['stock'].'</span>
				<input type="hidden" class="hide id_med"  name="id_med" value="'.$row['id_med'].'">
				<label style="visibility:hidden;" class="secondary radius label increment">+</label>
				<a class="tiny-text modify-button" href="#">modifier</a>
				<a class="tiny-text save hide" href="#">enregistrer</a>';
if ($row['stock']==0) { print '<span class="alert radius label">indisponible</span>';}
print '
			</form>
		  
			
	</td>';
	$alert = '';
	if ($row['stock']==0) {$alert = ' alert ';} 
print '<td><a href="index.php?page=commander&id='.$row['id_med'].'" class="button tiny '.$alert.' radius">Commander</a></td>'; //Display the 'Commander' button, for the specific med, and in red if out of stock
print '</tr>';
}
?>

<script>
//Modify quantities
$(document).ready(function(){
	$('.modify-button').click(function(){
		$(this).siblings('label.secondary').css('visibility','visible'); //Display + and - buttons when clicked on modify
		$(this).hide(); // hide the 'Modify' button
		$(this).siblings('.save').show(); // Show the 'Save' button
		return false; //Stop default action
	});
	$('.increment').click(function(){
		$(this).siblings('span.stock').text( parseInt($(this).siblings('span.stock').text()) +1 ); //Increment up 1
		return false;
	})
	$('.reduce').click(function(){
		if (parseInt( $(this).siblings('span.stock').text()) > 0 ){$(this).siblings('span.stock').text( parseInt($(this).siblings('span.stock').text()) -1 );} // Reduce down 1 to 0
		return false;
	});
	$('.save').click(function(){
		var id = $(this).siblings('.id_med').val(); // Grab the med_id concerned
		var no = $(this).siblings('.stock').text().trim(); //Grab the stock (and trim out any whitespace)
		
		//Post the values of id and stock using ajax. Grab the returned data, fade it into the field and reset the form.
		$.post( "ajax/update-stock.php", { id_med: id, stock: no } )
			.done(function(data){
				console.log(data);
				var $data = $.parseJSON(data);
				console.log($data);
				//alert('ID: ' + $data['id_med']);
				$('#med_'+$data['id_med']+' .stock').fadeOut().text($data['stock']).fadeIn(); 
				$('#med_'+$data['id_med']+' label.secondary').css('visibility','hidden');
				$('#med_'+$data['id_med']+' .save').hide();
				$('#med_'+$data['id_med']+' .modify-button').show();
				
			});
		return false;
	})
});

</script>