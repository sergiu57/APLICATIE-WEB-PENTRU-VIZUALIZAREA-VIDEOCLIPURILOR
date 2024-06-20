<?php include('functions.php'); 
      if(isset($_SESSION['simvideo_user']['email'])){
        if($_SESSION['simvideo_user']['cont_minor'] == '0'){
          if(isset($_GET['id_minor'])){
            $id_parinte = $_SESSION['simvideo_user']['id'];
            $id_minor = $_GET['id_minor'];
            $sql_minor = "SELECT * FROM utilizatori WHERE id = '$id_minor' AND asociere = '$id_parinte'";
            $result_minor = mysqli_query($db, $sql_minor);
            if($result_minor->num_rows > 0){
              $minor = $result_minor->fetch_assoc();
            }else{
              header("Location: conturi-minori.php");
            }
          }else{
            header("Location: conturi-minori.php");
          }
        }else{
          header("Location: index.php");
        }
      }else{
        header("Location: index.php");
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Editare profil minor</title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php') ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Setari profil</h1>
          </div>
          <div class="section-body">
            <h2 class="section-title">Salut, <?php echo $user['prenume']; ?>!</h2>  
            <?php if(isset($_GET['success'])): ?>
                <?php if($_GET['success'] == 'pass'): ?>
                  <div class="alert alert-success">Parola ta a fost modificata cu succes.</div>
                <?php endif ?>
                <?php if($_GET['success'] == 'profil'): ?>
                  <div class="alert alert-success">Informatiile profilului au fost modificate cu succes.</div>
                <?php endif ?>
              <?php endif ?>
              <?php if(isset($_GET['error'])): ?>
                <?php if($_GET['error'] == 'pass'): ?>
                  <div class="alert alert-danger">Parolele introduse nu coincid.</div>
                <?php endif ?>
              <?php endif ?>
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">  
                    <?php if(!empty($minor['imagine'])): ?>                   
                    <img alt="image" src="utilizatori/<?php echo $minor['imagine']; ?>" class="rounded-circle profile-widget-picture">
                    <?php else: ?>
                    <img alt="image" src="assets/img/vizitator.png" class="rounded-circle profile-widget-picture">
                    <?php endif ?>
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Abonari</div>
                        <?php  
                            $id_user = $user['id'];
                            $sql_abonati = "SELECT * FROM abonamente WHERE id_abonat = '$id_minor'";
                            $result_abonati = mysqli_query($db, $sql_abonati);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_abonati->num_rows; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Vizionari</div>
                        <?php  
                            $sql_videoclipuri = "SELECT * FROM vizionate WHERE id_utilizator = '$id_minor'";
                            $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_videoclipuri->num_rows; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Aprecieri</div>
                        <?php  
                            $sql_aprecieri = "SELECT * FROM aprecieri WHERE id_utilizator = '$id_minor'";
                            $result_aprecieri = mysqli_query($db, $sql_aprecieri);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_aprecieri->num_rows; ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?php echo $minor['nume'] . " " . $minor['prenume']; ?></div>
                  </div>
                </div>
                <div class="card">
                  <form method="post" action="edit-minor.php">
                    <div class="card-header">
                      <h4>Editare parola</h4>
                    </div>
                    <div class="card-body">
                      <input type="text" class="d-none" name="email" value="<?php echo $minor['email']; ?>">
                        <div class="row">     
                          <div class="form-group col-md-12 col-12">
                            <label>Parola noua</label>
                            <input type="password" class="form-control" name="parola_i" required>
                          </div>
                          <div class="form-group col-md-12 col-12">
                            <label>Parola noua</label>
                            <input type="password" class="form-control" name="parola_r" required>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right mt-0 pt-0">
                      <button class="btn btn-primary" type="submit" name="edit_parola_minor">Salveaza modificarile</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" action="edit-minor.php" enctype="multipart/form-data">
                    <div class="card-header">
                      <h4>Editare profil</h4>
                    </div>
                    <div class="card-body">
                        <input type="text" class="d-none" name="id_minor" value="<?php echo $id_minor; ?>" required>
                        <div class="row"> 
                          <div class="col-md-12 mb-4">
                            <div id="image-preview" class="image-preview">
                              <label for="image-upload" id="image-label">Imagine profil</label>
                              <input type="file" name="img" id="image-upload" />
                            </div>
                          </div>                              
                          <div class="form-group col-md-6 col-12">
                            <label>Nume</label>
                            <input type="text" class="form-control" name="nume" value="<?php echo $minor['nume']; ?>" required>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Prenume</label>
                            <input type="text" class="form-control" name="prenume" value="<?php echo $minor['prenume']; ?>" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $minor['email']; ?>" readonly>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Varsta</label>
                            <select class="form-control selectric" name="varsta">
                              <option value="1" <?php if($minor['varsta'] == '1'){ echo "selected"; } ?>>1 an</option>
                              <option value="2" <?php if($minor['varsta'] == '2'){ echo "selected"; } ?>>2 ani</option>
                              <option value="3" <?php if($minor['varsta'] == '3'){ echo "selected"; } ?>>3 ani</option>
                              <option value="4" <?php if($minor['varsta'] == '4'){ echo "selected"; } ?>>4 ani</option>
                              <option value="5" <?php if($minor['varsta'] == '5'){ echo "selected"; } ?>>5 ani</option>
                              <option value="6" <?php if($minor['varsta'] == '6'){ echo "selected"; } ?>>6 ani</option>
                              <option value="7" <?php if($minor['varsta'] == '7'){ echo "selected"; } ?>>7 ani</option>
                              <option value="8" <?php if($minor['varsta'] == '8'){ echo "selected"; } ?>>8 ani</option>
                              <option value="9" <?php if($minor['varsta'] == '9'){ echo "selected"; } ?>>9 ani</option>
                              <option value="10" <?php if($minor['varsta'] == '10'){ echo "selected"; } ?>>10 ani</option>
                              <option value="11" <?php if($minor['varsta'] == '11'){ echo "selected"; } ?>>11 ani</option>
                              <option value="12" <?php if($minor['varsta'] == '12'){ echo "selected"; } ?>>12 ani</option>
                              <option value="13" <?php if($minor['varsta'] == '13'){ echo "selected"; } ?>>13 ani</option>
                              <option value="14" <?php if($minor['varsta'] == '14'){ echo "selected"; } ?>>14 ani</option>
                              <option value="15" <?php if($minor['varsta'] == '15'){ echo "selected"; } ?>>15 ani</option>
                              <option value="16" <?php if($minor['varsta'] == '16'){ echo "selected"; } ?>>16 ani</option>
                              <option value="17" <?php if($minor['varsta'] == '17'){ echo "selected"; } ?>>17 ani</option>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right mt-0 pt-0">
                      <button class="btn btn-primary" name="edit_profil_minor">Salveaza modificarile</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>

  <script src="assets/js/page/index-0.js"></script>
  <script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="assets/js/page/components-user.js"></script>
  <script src="assets/js/page/features-post-create.js"></script>
  
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>