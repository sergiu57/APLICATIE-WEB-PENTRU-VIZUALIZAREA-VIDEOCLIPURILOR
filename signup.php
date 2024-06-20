<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Creare cont</title>

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="assets/img/logo-min.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Creare cont</h4></div>
              <?php if(isset($_GET['error'])): ?>
                <?php if($_GET['error'] == 'email'): ?>
                  <div class="alert alert-danger">Acest email este deja inregistrat</div>
                <?php endif ?>
                <?php if($_GET['error'] == 'pass'): ?>
                  <div class="alert alert-danger">Parolele introduse nu coincid</div>
                <?php endif ?>
                <?php if($_GET['error'] == 'data_nasterii'): ?>
                  <div class="alert alert-danger">Pentru a accesa aceasta platforma varsta minima este de 18 ani.</div>
                <?php endif ?>
              <?php endif ?>
              <div class="card-body">
                <form method="POST" action="signup.php">
                  <div class="row">
                    <div class="form-group col-sm-6">
                      <label for="frist_name">Nume</label>
                      <input id="frist_name" type="text" class="form-control" name="nume" autofocus required>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="last_name">Prenume</label>
                      <input id="last_name" type="text" class="form-control" name="prenume">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-sm-6">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" autofocus required>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="telefon">Telefon</label>
                      <input id="telefon" type="text" class="form-control" name="telefon" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-sm-6">
                      <label for="password" class="d-block">Parola</label>
                      <input id="password" type="password" class="form-control" name="parola_i" required>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="password2" class="d-block">Repeta parola</label>
                      <input id="password2" type="password" class="form-control" name="parola_r" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12">
                      <label for="data_nasterii" class="d-block">Data nasterii</label>
                      <input id="data_nasterii" type="date" class="form-control" name="data_nasterii" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="signup" class="btn btn-primary btn-lg btn-block">
                      Creare cont
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-3 mb-5 text-muted text-center">
              Ai deja un cont? <a href="login.php">Conectare</a>
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
  <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/auth-register.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>