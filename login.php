<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Conectare</title>

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/logo-min.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Conectare</h4></div>
              <?php if(isset($_GET['success'])): ?>
                <?php if($_GET['success'] == 'cont'): ?>
                  <div class="alert alert-success">Contul tau a fost creat cu succes. Conecteaza-te!</div>
                <?php endif ?>
              <?php endif ?>
              <?php if(isset($_GET['error'])): ?>
                <?php if($_GET['error'] == 'cont'): ?>
                  <div class="alert alert-danger">Acest cont nu exista</div>
                <?php endif ?>
                <?php if($_GET['error'] == 'pass'): ?>
                  <div class="alert alert-danger">Parola este incorecta</div>
                <?php endif ?>
              <?php endif ?>
              <div class="card-body">
                <form method="POST" action="login.php">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>

                  <div class="form-group">
                    <label for="password" class="control-label">Parola</label>
                    <input id="password" type="password" class="form-control" name="parola_cont" tabindex="2" required>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Conectare
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="mt-3 mb-5 text-muted text-center">
              Nu ai un cont? <a href="creare-cont.php">Creeaza unul</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>