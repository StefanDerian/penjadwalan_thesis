<?php 

echo validation_errors(); 

echo isset($validation)?$validation:"";
?>

<div class="panel panel-default">
	<div class="panel-heading">
		ISI DATA SESUAI KETENTUAN
	</div>
	<div class="panel-body">
		<form action = "<?php echo base_url(); ?>index.php/dosen/submit_dosen" method = "post">
			<div class="form-group">
				<label for="nim">NIP:</label>
				<input type="text" class="form-control" id="nim" disabled value="<?php echo $this->session->has_userdata('id')?$this->session->userdata('id'):''?>">
			</div>
			<div class="form-group">
				<label for="nama">Nama:</label>
				<input type="text" class="form-control" id="nama" disabled value="<?php echo $this->session->has_userdata('nama')?$this->session->userdata('nama'):''?>">
			</div>
			<div class = "form-penelitian">
				<?php if($status == 'signup'){ ?>

				<div class="form-group form-group-penelitian" id = "penelitian-1" data-seq = 1>
					<label for="penelitian1" class = "topik-label">Topik Penelitian:</label>
					<select class="form-control" id="topik1" name = "penelitian[0][id_penelitian]">
						<?php
						foreach ($penelitians_data as $penelitian_data) {
						# code...
							?>
							<option value ="<?php echo $penelitian_data['id']; ?>"><?php echo $penelitian_data['topik']; ?></option>
							<?php
						}

						?>
					</select>
					<label for="rating-1" class = "rating-label">Rating:</label>
					<input type="number" class="form-control form-rating" id="rating-1" name = "penelitian[0][rating]" step = "0.01">
				</div>

				<?php }else{ ?>

				<?php foreach($dosen_penelitians_data as $key => $dosen_penelitian_data){ ?>

				
				<div class="form-group form-group-penelitian" id = "penelitian-<?php echo($key+1); ?>" data-seq = <?php echo($key+1); ?>>
					<label for="penelitian<?php echo($key+1); ?>" class = "topik-label">Topik Penelitian:</label>
					<select class="form-control" id="topik<?php echo($key+1); ?>" name = "penelitian[<?php echo $key; ?>][id_penelitian]; ?>">
						<?php
						foreach ($penelitians_data as $penelitian_data) {
						# code...
							?>
							<option value ="<?php echo $penelitian_data['id']; ?>" <?php echo $penelitian_data['id'] === $dosen_penelitian_data['id_penelitian']?'selected':''; ?> ><?php echo $penelitian_data['topik']; ?></option>
							<?php
						}

						?>
					</select>
					<label for="rating-1" class = "rating-label">Rating:</label>
					<input type="number" class="form-control form-rating" id="rating-1" name = "penelitian[<?php echo $key; ?>][rating]"" step = "0.01" value = "<?php echo $dosen_penelitian_data['rating'] ;?>">
					<?php if($key > 0){ ?>
					<button data-id = "<?php echo ($key+1);?>" data-max =<?php echo $jumlah_penelitians?>  class = 'btn btn-md btn-warning btn-delete-penelitian' >Delete</button>
					<?php } ?>
				</div>
				

				<?php } ?>



				<?php } ?>

			</div>
			
			
			<button data-placement="top" title="Hanya Bisa menambah sampai dengan <?php echo $jumlah_penelitians;  ?>" id = "tambahPenelitian" class = "btn btn-lg btn-primary" data-max = "<?php echo $jumlah_penelitians; ?>">Tambah Penelitian</button><br>
			<input type="hidden" name="type" value = "<?php echo $status;  ?>">
			<input type="hidden" name="type" id = "jumlahPenelitian" value = "<?php echo $dosen_jumlah_penelitian;  ?>">

			<button type="submit" class="btn btn-default">SIMPAN</button>
		</form>

	</div>
</div>