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
			<div class="card">
				<div class="card-header">
					Mahasiswa
				</div>
				<div class="card-body">
					<table id="tabel-pembayaran" class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>NIM</th>
								<th>Mahasiswa</th>
								<th>Jenis</th>
								<th>Semester</th>
								<th>Nominal</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
						<tfoot>
							<tr>
								<th>Tanggal</th>
								<th>NIM</th>
								<th>Mahasiswa</th>
								<th>Jenis</th>
								<th>Semester</th>
								<th>Nominal</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
		<script type='text/javascript'>
			$(document).ready(function() {
				$('#tabel-pembayaran').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax": {
						"url": '<?php echo base_url('admin/transaksi/list_pembayaran'); ?>',
						"type": "POST"
					},
				} );
			} );
		</script>
		<!-- Sticky Footer -->
		<?php $this->load->view("admin/_parts/footer.php") ?>

	</div>
	<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->


<?php $this->load->view("admin/_parts/scrolltop.php") ?>
<?php $this->load->view("admin/_parts/modal.php") ?>
<?php $this->load->view("admin/_parts/js.php") ?>
    
</body>
</html>