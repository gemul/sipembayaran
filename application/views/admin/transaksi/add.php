<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view("admin/_parts/head.php") ?>

	<link rel="stylesheet" href="<?php echo base_url('css/flatpickr.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/select2.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/select2-bootstrap4.min.css') ?>">
</head>
<body id="page-top">

<?php $this->load->view("admin/_parts/navbar.php") ?>

<div id="wrapper">

	<?php $this->load->view("admin/_parts/sidebar.php") ?>

	<div id="content-wrapper">

		<div class="container-fluid">

		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					Pembayaran
				</div>
				<div class="card-body">
					<?php
						if(isset($status)){
							if($status=='ok'){
								echo "<div class='alert alert-success'>".$message."</div>";
							}else{
								echo "<div class='alert alert-danger'>".$message."</div>";
							}
						}
					?>
					<form method='post' action="<?php echo base_url('admin/transaksi/save') ?>">
					<div class="form-group row">
						<label for="mahasiswa" class="col-4 col-form-label">Mahasiswa</label> 
						<div class="col-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="fa fa-id-card"></i>
									</span>
								</div> 
								<select id="mahasiswa" name="mahasiswa" placeholder="Masukkan nim atau nama untuk mencari" required="required" class="form-control"> 
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="jenis" class="col-4 col-form-label">Jenis</label> 
						<div class="col-8">
						<select id="jenis" name="jenis" required="required" class="custom-select">
							<?php
							foreach($arrJenis as $itemJenis):
							?>
							<option value="<?=$itemJenis->jns_kode?>"><?=$itemJenis->jns_kode?> (<?=$itemJenis->jns_deskripsi?>)</option>
							<?php
							endforeach;
							?>
						</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="semester" class="col-4 col-form-label">Semester</label> 
						<div class="col-8">
						<select id="semester" name="semester" class="custom-select" required="required">
							<?php
							for($i=1;$i<=8;$i++):
							?>
							<option value="<?=$i?>"><?=$i?></option>
							<?php
							endfor;
							?>
						</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="biaya" class="col-4 col-form-label">Biaya</label> 
						<div class="col-8">
							<span id="biaya">Pilih mahasiswa</span>
						</div>
					</div>
					<div class="form-group row">
						<label for="terbayar" class="col-4 col-form-label">Terbayar</label> 
						<div class="col-8">
							<span id="terbayar">Pilih mahasiswa</span>
						</div>
					</div>
					<div class="form-group row">
						<label for="tanggungan" class="col-4 col-form-label">Sisa tanggungan</label> 
						<div class="col-8">
							<span id="tanggungan">Pilih mahasiswa</span>
							<span id="tanggungan_baru"></span>
						</div>
					</div>
					<div class="form-group row">
						<label for="nominal" class="col-4 col-form-label">Nominal</label> 
						<div class="col-8">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<i class="fa fa-money-bill"></i>
								</div> 
							</div> 
							<input id="nominal" name="nominal" placeholder="Masukkan nominal" type="text" class="form-control divided" required="required" autocomplete="off">
						</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="waktu" class="col-4 col-form-label">Tanggal pembayaran</label> 
						<div class="col-8">
							<div class="input-group" >
								<div class="input-group-prepend">
									<div class="input-group-text">
										<i class="fa fa-calendar"></i>
									</div> 
								</div> 
								<input type="text" readonly="" name="waktu" id="waktu" class="form-control date" required="required" > 
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="keterangan" class="col-4 col-form-label">Keterangan</label> 
						<div class="col-8">
						<textarea id="keterangan" name="keterangan" cols="40" rows="3" class="form-control"></textarea>
						</div>
					</div> 
					<div class="form-group row">
						<div class="offset-4 col-8">
						<button name="submit" type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
					</form>
				</div>
			</div>
			<script>
			
			</script>
		</div>
		<!-- /.container-fluid -->

		<!-- Sticky Footer -->
		<?php $this->load->view("admin/_parts/footer.php") ?>

	</div>
	<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->


<?php $this->load->view("admin/_parts/scrolltop.php") ?>
<?php $this->load->view("admin/_parts/modal.php") ?>
<?php $this->load->view("admin/_parts/js.php") ?>

<script src="<?php echo base_url('js/moment.min.js') ?>"></script>
<script src="<?php echo base_url('js/number-divider.min.js') ?>"></script>
<script src="<?php echo base_url('js/flatpickr.js') ?>"></script>
<script src="<?php echo base_url('js/select2.min.js') ?>"></script>
<script type='text/javascript'>
$('.divided').divide({
  delimiter: '.',
  divideThousand: true, // 1,000..9,999
  delimiterRegExp: /[\.\,\s]/g
});

var selectedMahasiswa=0;
var tanggungan=0;
$(document).ready(function(){
	$('#waktu').flatpickr({
		defaultDate:"today",
		altInput: true,
		altFormat: "j F Y",
		dateFormat: "Y-m-d",
	});
    $('#mahasiswa').select2({
		theme:'bootstrap4',
		ajax: {
			delay: 250,
			url: '<?php echo base_url('admin/transaksi/mahasiswa_select') ?>',
			dataType: 'json',
			data: function (params) {
				var query = {
					search: params.term,
					type: 'public',
					page: params.page || 1
				}

				// Query parameters will be ?search=[term]&type=public
				return query;
			},
			processResults: function (data) {
				return data;
				// return {
				// 	results: data.text
				// };
			},
			// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
		}
	});
	$('#mahasiswa').on('select2:select', function (e) {
		// console.log($(this).val());
		selectedMahasiswa = $(this).val();
		updateTanggungan();
	});
	$('#jenis').on('change',function(e){
		updateTanggungan();
	});
	$('#semester').on('change',function(e){
		updateTanggungan();
	});
	$('#nominal').on('keyup',function(e){
		let nominal=$(this).val();
		if(tanggungan!=0 && nominal!=0){
			$('#tanggungan_baru').html("--&gt;"+(tanggungan-nominal).toLocaleString('id'));
		}else{
			$('#tanggungan_baru').html("");
		}
	});
});

function updateTanggungan(){
	var mahasiswa	= selectedMahasiswa;
	var jenis		= $('#jenis').val();
	var semester	= $('#semester').val();
	console.log("<?php echo base_url('admin/transaksi/ajaxTanggungan') ?>");
	$.ajax({
		url:"<?php echo base_url('admin/transaksi/ajaxTanggungan') ?>",
		data:{
			'mahasiswa':mahasiswa,
			'jenis':jenis,
			'semester':semester
		},
		dataType:"json",
		type:"GET",
		beforeSend:function(){
			$('#biaya').html("Menghitung Tanggungan Biaya...");
			$('#terbayar').html("Menghitung Tanggungan Biaya...");
			$('#tanggungan').html("Menghitung Tanggungan Biaya...");
			$('#tanggungan_baru').html("");
		},
		success:function(result){
			$('#biaya').html(result.textBiaya);
			$('#terbayar').html(result.textTerbayar);
			$('#tanggungan').html(result.textTanggungan);
			tanggungan=result.tanggungan;
			let nominal=$('#nominal').val();
			if(tanggungan!=0 && nominal!=0){
				$('#tanggungan_baru').html("--&gt;"+(tanggungan-nominal).toLocaleString('id'));
			}
		},
		error:function(result){
			$('#biaya').html("Terjadi kesalahan saat menghitung tanggungan biaya");
			$('#terbayar').html("Terjadi kesalahan saat menghitung tanggungan biaya");
			$('#tanggungan').html("Terjadi kesalahan saat menghitung tanggungan biaya");
		}
	});

}
</script>
</body>
</html>