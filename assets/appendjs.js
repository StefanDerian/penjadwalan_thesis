$(document).ready(function(){



	var penelitianId = $('#jumlahPenelitian').val();


	var maxTambahClick = $('#tambahPenelitian').data('max');
	console.log(penelitianId);
	$('#tambahPenelitian').on('click',function(){
		/** 
		$('.form-penelitian').append("<div class='form-group' id = 'penelitian-"+penelitianId+"'>"+
			"<label for='dosen1'>Topik Penelitian:</label>"+
			"<select class='form-control' id='dosen1'>"+
			"<option>1</option>"+
			"<option>2</option>"+
			"<option>3</option>"+
			"<option>4</option>"+
			"</select>"+
			"<label for='nama'>Rating:</label>"+
			"<input type='number' class='form-control' id='rating-"+penelitianId+"'>"+
			"<button data-id = "+penelitianId+" class = 'btn btn-md btn-warning btn-delete-penelitian' >Delete</button>"+
			"</div>");**/
			

			if(penelitianId < maxTambahClick){

				$( "#penelitian-1").clone().appendTo( ".form-penelitian" );

				penelitianId++;

				setFormProperties(penelitianId,true);
			}else{
				$('[data-toggle="tooltip"]').tooltip();
				
			}


			
			return false;
		}); 

	$('.form-penelitian').on('click','.btn-delete-penelitian',function(){
		var id = $(this).data('id');

		$('#penelitian-'+id).remove();

		$( ".form-group-penelitian" ).each(function( index, element ){
			var seq = $( element ).data('seq');

			if(seq > id){
				setFormProperties(index+1);
			}

		});



		penelitianId--;
		return false;
	});


	function setFormProperties(penelitianId,deleteButton){
		var lastFormGroup = $('.form-group-penelitian').last();
		var selectForm = lastFormGroup.find('select');
		var ratingForm = lastFormGroup.find('.form-rating');

		lastFormGroup.attr('id','penelitian-'+penelitianId);

		lastFormGroup.attr('data-seq',penelitianId);

		lastFormGroup.find('label.topik-label').attr('for','topik'+penelitianId);

		selectForm.attr('id','topik'+penelitianId);

		selectForm.attr('name','penelitian['+(penelitianId-1)+'][id_penelitian]');

		ratingForm.attr('id','rating-'+penelitianId);

		lastFormGroup.find('label.rating-label').attr('for','rating-'+penelitianId);

		ratingForm.attr('name','penelitian['+(penelitianId-1)+'][rating]');

		ratingForm.val('');


		if(deleteButton !== undefined){
			lastFormGroup.append("<button data-id = "+penelitianId+" class = 'btn btn-md btn-warning btn-delete-penelitian' >Delete</button>");
		}else{
			lastFormGroup.find('label.rating-label').attr('data-id',penelitianId);
		}
		

	}


});