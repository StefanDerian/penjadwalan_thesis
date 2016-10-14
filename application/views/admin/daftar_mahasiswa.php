<table class = "table table-striped">

	<tr>
		<td>No</td>
		<td>NIM Mahasiswa</td>
		<td>Nama</td>
		<td>Judul Thesis</td>
		<td>Minat</td>
		<td>Dosen Pembimbing 1</td>
		<td>Dosen Pembimbing 2</td>
		<td>Periode</td>
	</tr>
	<?php foreach($mahasiswas_data as $key=>$mahasiswa_data){     ?>
	<tr>
		<td><?php echo  $key+1; ?></td>
		<td><?php echo  $mahasiswa_data['id']; ?></td>
		<td><?php echo  $mahasiswa_data['nama']; ?></td>
		<td><?php echo  $mahasiswa_data['judul_thesis']; ?></td>
		<td><?php echo  $mahasiswa_data['minat']['topik']; ?></td>
		<td><?php echo  $mahasiswa_data['pembimbing'][0]['nama']; ?></td>
		<td><?php echo  $mahasiswa_data['pembimbing'][1]['nama']; ?></td>
		<td><?php echo  date('M Y',strtotime($mahasiswa_data['periode'])); ?></td>

	</tr>
	<?php } ?>

</table>
<a href = "<?php echo base_url(); ?>index.php/admin/generate_excel" class = "btn btn-md btn-primary"> Download Excel</a>