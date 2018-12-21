<!DOCTYPE html>
<html lang="en">

  <head>
	<?php $this->load->view("admin/_parts/head.php") ?>
  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login Aplikasi Pencatatan Pembayaran</div>
        <div class="card-body">
          <form action="<?php echo base_url('login/aksi_login'); ?>" method="post">
            <div class="form-group">
              <div class="form-label-group">
                <input type="username" id="username" class="form-control" placeholder="Username" required="required" autofocus="autofocus" name="username">
                <label for="username">Username</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" name="password">
                <label for="inputPassword">Password</label>
              </div>
			</div>
			<?php
				if($status=='error'):
			?>
			<div class="alert alert-danger"><?=$error?></div>
			<?php
				endif;
			?>
            <button class="btn btn-primary btn-block" href="index.html" type="submit">Login</button>
          </form>
        </div>
      </div>
    </div>
	<?php $this->load->view("admin/_parts/js.php") ?>


  </body>

</html>
