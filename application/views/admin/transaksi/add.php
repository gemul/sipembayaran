<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view("admin/_parts/head.php") ?>
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
					<form>
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
								<div class="input-group-append">
									<button class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="Jenis" class="col-4 col-form-label">Jenis</label> 
						<div class="col-8">
						<select id="Jenis" name="Jenis" required="required" class="custom-select">
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
						<label for="nominal" class="col-4 col-form-label">Nominal</label> 
						<div class="col-8">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<i class="fa fa-money-bill"></i>
								</div> 
							</div> 
							<input id="nominal" name="nominal" placeholder="Masukkan nominal" type="text" class="form-control divided" required="required">
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
						<textarea id="keterangan" name="keterangan" cols="40" rows="5" class="form-control"></textarea>
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

<link rel="stylesheet" href="<?php echo base_url('css/flatpickr.min.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('css/select2.min.css') ?>">
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
$(document).ready(function(){
	$('#waktu').flatpickr({
		defaultDate:"today",
		altInput: true,
		altFormat: "j F Y",
		dateFormat: "Y-m-d",
	});
    $('#mahasiswa').select2();
});
</script>
</body>
</html>