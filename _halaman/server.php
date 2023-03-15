<script type="text/javascript">
		$(document).ready(function(){
            setInterval(function(){
				// Lampu Sungai Urip Sumiarjo
                $("#sensor1").load('_halaman/arduino/ceksensor1.php');
                $("#sensor2").load('_halaman/arduino/ceksensor2.php');
            },1000);
        });
</script>
<?php
$title = "Server";
$judul = $title;
?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Jalan</th>
			<th>Sensor Arus</th>
			<th>Sensor Lampu 2&3</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$getdata=$db->ObjectBuilder()->get('sensor');
			?>
					<tr>
						<td>1</td>
						<td>Jl. Urip Sumiarjo</td>
						<td><span id="sensor1"></span></td>
						<td><span id="sensor2"></span></td>
						<!-- <td>
						<!-- <input name="relayInput" type="checkbox" <?php if($row->relay == 1) echo "checked"; ?> onchange='ubahStatus(this.checked)'>
						<label><span id="status"><?php 
						// if($row->relay == 1) echo "ON"; else echo "OFF"
						?></span>
						</label>
						</td> --> 
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
			<?php
			?>
	</tbody>
</table>