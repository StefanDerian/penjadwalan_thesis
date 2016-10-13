<form action = "<?php echo base_url(); ?>index.php/dosen/submit_jadwal_dosen" method = "post">
	<label for="waktu">Waktu Luang:</label>
	<table class="table-bordered" id="waktu" border="1">
		<tr>

			<?php 
			$jadwal_index = 0;
			for($i = 0  ; $i < 6 ;$i++){ 
				$time = 7 ;
				$day = "";
				switch ($i) {
					case 1:
					$day = "Monday";
					break;
					case 2:
					$day = "Tuesday";
					break;
					case 3:
					$day = "Wednesday";
					break;
					case 4:
					$day = "Thursday";
					break;
					case 5:
					$day = "Friday";
					break;
					default:
		# code...
					break;
				}


				?>
				<td><?php echo $i == 0?" ":"$day"; ?></td>


				<?php for($j = 0  ; $j < 9 ;$j++){ 

					if($i == 0){
						echo "<td> $time </td>";
					}else{

						$date = new DateTime($day);
						$date->setTime($time,0,0);
						?>
						<td>
							<div class="checkbox">
								<?php if(isset($waktu_luang_data[$day][$j]['jam']) && $waktu_luang_data[$day][$j]['jam'] == $time ){
									
									?>

									<label><input name = "jadwal[<?php echo $jadwal_index; ?>][id_waktu]" type="checkbox" value="<?php echo $waktu_luang_data[$day][$j]['id'] ?>"
									<?php echo in_array( array('id_waktu'=> $waktu_luang_data[$day][$j]['id']), $current_waktu_luang,true)?"checked":"" ?> ></label>
									<?php } ?>
								</div>
							</td>
							<?php
						}
						$time++;
						$jadwal_index++;
						?>

						<?php } ?>


					</tr>

					<?php } ?>

				</table>
				<button type="submit" class="btn btn-default">SIMPAN</button>
			</form>