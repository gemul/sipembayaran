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
					Biaya Mahasiswa
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
					<form method='post' onsubmit="return false;" id="form-tanggungan">
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
						<div class='col-12'>
							<table class='table table-striped'>
								<tr>
									<td>SMT</td>
									<td>SPP</td>
									<td>UAS</td>
									<td>UTS</td>
								</tr>
								<?php
								for($i=1;$i<=10;$i++):
								?>
								<tr>
									<td><?=$i?></td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_SPP_<?=$i?>" name="tanggungan_SPP_<?=$i?>" ></td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_UAS_<?=$i?>" name="tanggungan_UAS_<?=$i?>" ></td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_UTS_<?=$i?>" name="tanggungan_UTS_<?=$i?>" ></td>
								</tr>
								<?php
								endfor;
								?>
								<tr>
									<td colspan="3">Herregistrasi</td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_HER" name="tanggungan_HER" ></td>
								</tr>
								<tr>
									<td colspan="3">OPSPEK</td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_OPSPEK" name="tanggungan_OPSPEK" ></td>
								</tr>
								<tr>
									<td colspan="3">Uang Gedung</td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_UG" name="tanggungan_UG" ></td>
								</tr>
								<tr>
									<td colspan="3">KKN</td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_KKN" name="tanggungan_KKN" ></td>
								</tr>
								<tr>
									<td colspan="3">Skripsi</td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_SKRIPSI" name="tanggungan_SKRIPSI" ></td>
								</tr>
								<tr>
									<td colspan="3">Wisuda</td>
									<td><input type='text' class='form-control divided inputan' autocomplete='off' disabled="disabled" id="tanggungan_WISUDA" name="tanggungan_WISUDA" ></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="form-group row">
						<label for="mahasiswa" class="offset-4 col-1 col-form-label">PIN</label> 
						<div class="col-2">
						<input type='password' class='form-control inputan' name="pin"  >
						</div>
						<div class="col-5">
						<button type="button" class="btn btn-primary" id="tombolSimpan" onclick="saveTanggungan()" >Simpan</button>
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
});

function saveTanggungan(){
	var src="<?php echo base_url('admin/tanggungan/save') ?>";
	var formData=$("#form-tanggungan").serialize();
	$.ajax({
		url:src,
		data:formData,
		dataType:"json",
		type:"POST",
		beforeSend:function(){
			$('.inputan').prop("disabled",true);
			$('#tombolSimpan').html("Menyimpan...").prop("disabled",true);
		},
		success:function(result){
			if(result.status=="salah"){
				alert("PIN Salah");
			}else if(result.status=="ok"){
				alert("Data berhasil disimpan");
			}
			$('#tombolSimpan').html("Simpan").prop("disabled",false);
			$('.inputan').prop("disabled",false);
		},
		error:function(result){
			$('.inputan').prop("disabled",false);
			$('#tombolSimpan').html("Simpan").prop("disabled",false);
		}
	});
}

function updateTanggungan(){
	var mahasiswa	= selectedMahasiswa;
	console.log("<?php echo base_url('admin/tanggungan/ajaxBiayaTanggungan') ?>");
	$.ajax({
		url:"<?php echo base_url('admin/tanggungan/ajaxBiayaTanggungan') ?>",
		data:{
			'mahasiswa':mahasiswa 
		},
		dataType:"json",
		type:"GET",
		beforeSend:function(){
			$('.inputan').val("Memuat...").prop("disabled",true);
		},
		success:function(result){
			$('.inputan').val("").prop("disabled",false);
			for(var i=1;i<=10;i++){
				if(result['tanggungan_SPP_'+i]!==undefined){
					$('#tanggungan_SPP_'+i).val(result['tanggungan_SPP_'+i]);
				}
				if(result['tanggungan_UAS_'+i]!==undefined){
					$('#tanggungan_UAS_'+i).val(result['tanggungan_UAS_'+i]);
				}
				if(result['tanggungan_UTS_'+i]!==undefined){
					$('#tanggungan_UTS_'+i).val(result['tanggungan_UTS_'+i]);
				}
			}
			if(result['tanggungan_HER']!==undefined){
				$("#tanggungan_HER").val(result['tanggungan_HER']);
			}
			if(result['tanggungan_OPSPEK']!==undefined){
				$("#tanggungan_OPSPEK").val(result['tanggungan_OPSPEK']);
			}
			if(result['tanggungan_UG']!==undefined){
				$("#tanggungan_UG").val(result['tanggungan_UG']);
			}
			if(result['tanggungan_KKN']!==undefined){
				$("#tanggungan_KKN").val(result['tanggungan_KKN']);
			}
			if(result['tanggungan_SKRIPSI']!==undefined){
				$("#tanggungan_SKRIPSI").val(result['tanggungan_SKRIPSI']);
			}
			if(result['tanggungan_WISUDA']!==undefined){
				$("#tanggungan_WISUDA").val(result['tanggungan_WISUDA']);
			}

		},
		error:function(result){
			$('.inputan').val("Data gagal dimuat").prop("disabled",true);
		}
	});

}
</script>
</body>
</html>