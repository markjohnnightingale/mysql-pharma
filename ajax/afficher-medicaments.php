<?php
require "../connect.php";

$sql = 'SELECT `id_med`, `nom_med`, `equiv_generique`,`agents_actifs`,`prix`,`stock`,`fournisseur`,`maladie_traitee` FROM medicament';
foreach ($conn->query($sql) as $row) {
  print '<tr id="med_'.$row['id_med'].'">';
  print '<td>'.$row['nom_med'].' <span class="secondary radius label">'.$row['id_med'].'</span></td>';
  print '<td>'.$row['equiv_generique'].'</td>';
  print '<td>'.$row['agents_actifs'].'</td>';
  print '<td>'.$row['maladie_traitee'].'</td>';
  print '<td><a href="index.php?page=fournisseur&id='.$row['fournisseur'].'">'.$row['fournisseur'].'</a></td>';
  print '<td>€ '.$row['prix'].'</td>';
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
print '<td><a href="index.php?page=commander&id='.$row['id_med'].'" class="button tiny '.$alert.' radius">Commander</a></td>';
print '</tr>';
}
?>

<script>
//Modify quantities
$(document).ready(function(){
	$('.modify-button').click(function(){
		$(this).siblings('label.secondary').css('visibility','visible');
		$(this).hide();
		$(this).siblings('.save').show();
		return false;
	});
	$('.increment').click(function(){
		$(this).siblings('span').text( parseInt($(this).siblings('span').text()) +1 );
	})
	$('.reduce').click(function(){
		if (parseInt( $(this).siblings('span').text()) > 0 ){$(this).siblings('span').text( parseInt($(this).siblings('span').text()) -1 );}
	});
	$('.save').click(function(){
		var id = $(this).siblings('.id_med').val();
		var no = $(this).siblings('.stock').text().trim();
		$.post( "ajax/update-stock.php", { id_med: id, stock: no } )
			.done(function(data){
				var $data = $.parseJSON(data)
				//alert('ID: ' + $data['id_med']);
				$('#med_'+$data['id_med']+' .stock').fadeOut().text($data['stock']).fadeIn();
				$('#med_'+$data['id_med']+' label.secondary').css('visibility','hidden');
				$('#med_'+$data['id_med']+' .save').hide();
				$('#med_'+$data['id_med']+' .modify_button').show();
				
			});
	})
});

</script>