<?php 

echo validation_errors(); 

echo isset($validation)?$validation:"";
?>

<div class="panel panel-default">
	<div class="panel-heading">
		ISI DATA SESUAI KETENTUAN
	</div>
	<div class="panel-body">
		<form method = "post" action = "<?php echo base_url(); ?>index.php/mahasiswa/submit_mahasiswa">
			<div class="form-group">
				<label for="nim">NIM:</label>
				<input type="text" class="form-control" id="nim" disabled value="<?php echo $this->session->has_userdata('id')?$this->session->userdata('id'):''?>">
			</div>
			<div class="form-group">
				<label for="nama">Nama:</label>
				<input type="text" class="form-control" id="nama" disabled value="<?php echo $this->session->has_userdata('nama')?$this->session->userdata('nama'):''?>">
			</div>
			<div class="form-group">
				<label for="ipk">IPK:</label>
				<input type="number" class="form-control" id="ipk" name = "ipk"  step="0.01" value="<?php echo $mahasiswa_data['ipk'] === "" ?'':$mahasiswa_data['ipk']; ?>">
			</div>
			<div class="form-group">
				<label for="thesis">Judul Thesis:</label>
				<input type="text" class="form-control" id="thesis" name = "thesis" value="<?php echo $mahasiswa_data['judul_thesis'] === "" ?'':$mahasiswa_data['judul_thesis']; ?>" >
			</div>
			<div class="form-group">
				<label for="minat" >Minat:</label>
				<select class="form-control" id="minat" name = "minat" >
					<?php
					foreach ($minats_data as $minat_data) {
						# code...
						?>
						<option value ="<?php echo $minat_data['id']; ?>" <?php echo $mahasiswa_data['id_minat'] === $minat_data['id'] ?'selected':''; ?> ><?php echo $minat_data['topik']; ?></option>
						<?php
					}

					?>
				</select>
			</div>
			<div class="form-group">
				<label for="dosen1">Dosen Pembimbing 1:</label>
				<select class="form-control" id="dosen1" name = "dosen1" value ="">
					<option value ="">-</option>
					<?php
					foreach ($dosens_data as $dosen_data) {
	# code...
						?>
						<option value ="<?php echo $dosen_data['id']; ?>" <?php echo isset($pembimbing_data[0]['id_dosen'])&&$pembimbing_data[0]['id_dosen'] === $dosen_data['id'] ?'selected':''; ?> ><?php echo $dosen_data['nama']; ?></option>
						<?php
					}

					?>
				</select>
			</div>
			<div class="form-group">
				<label for="dosen1">Dosen Pembimbing 2:</label>
				<select class="form-control" id="dosen2" name = "dosen2">
					<option value ="">-</option>
					<?php
					foreach ($dosens_data as $dosen_data) {
	# code...
						?>
						<option value ="<?php echo $dosen_data['id']; ?>" <?php echo isset($pembimbing_data[1]['id_dosen'])&&$pembimbing_data[1]['id_dosen'] === $dosen_data['id'] ?'selected':''; ?> ><?php echo $dosen_data['nama']; ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-default"><?php echo $status == "Signup"?"Daftar":"Ubah";?></button>
		</form>

	</div>
</div>