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
					<table id="tabel-mahasiswa" class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>NIM</th>
								<th>Nama</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
						<tfoot>
							<tr>
								<th>NIM</th>
								<th>Nama</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
		<script type='text/javascript'>
			$(document).ready(function() {
				$('#tabel-mahasiswa').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax": {
						"url": '<?php echo base_url('admin/mahasiswa/list_mahasiswa'); ?>',
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