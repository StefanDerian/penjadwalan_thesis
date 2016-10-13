

<?php 

	echo validation_errors(); 

	echo isset($validation)?$validation:"";
?>

<div class="panel panel-default">
	<div class="panel-heading">
		LOGIN
	</div>
	<div class="panel-body">
		<form action = "<?php echo base_url(); ?>index.php/login/login_ops" method="post">
			<div class="form-group">
				<label for="nim">NIM</label>
				<input type="text" class="form-control" id="nim" name = "nim">
			</div>
			<div class="form-group">
				<label for="pwd">Password:</label>
				<input type="password" class="form-control" id="pwd" name = "pwd">
			</div>
			<div class="checkbox">
				<label><input type="checkbox"> Remember me</label>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>

	</div>
</div>