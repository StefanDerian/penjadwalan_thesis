<html>
<head>
	<title><?php echo $title; ?></title>
	<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/style.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/appendjs.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.js"></script>
</head>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Pendaftaran Thesis Periode <?php echo date('M Y'); ?></a>
		</div>
		<ul class="nav navbar-nav">


			<?php if($this->session->userdata('status') == 'dosen'){?>

			<li class=<?php echo $page == 'dosen/signup'?"active":"" ?>><a href="<?php echo base_url(); ?>index.php/dosen">Profil Dosen</a></li>
			<li class=<?php echo $page == 'dosen/jadwal'?"active":"" ?>><a href="<?php echo base_url(); ?>index.php/dosen/jadwal_dosen">Waktu Luang</a></li>
			
			<?php }else if($this->session->userdata('status') == 'mahasiswa'){ ?>

			<li class=<?php echo $page == 'mahasiswa/signup'?"active":"" ?>><a href="#">Profil Mahasiswa</a></li>
			<li><a href="#">Pendaftaran Ujian Thesis</a></li>

			<?php } ?>
			<li><a href="#">Jadwal Thesis</a></li>

		</ul>
	</div>
</nav>
<body>