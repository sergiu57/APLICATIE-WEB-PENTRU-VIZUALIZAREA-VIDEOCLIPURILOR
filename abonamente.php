<?php include('functions.php'); 
      if(!isset($_SESSION['simvideo_user']['email'])){
        header("Location: index.php");
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Abonamentele mele</title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php'); ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Abonamente</h1>
          </div>
          <?php if(isset($_GET['success'])): ?>
            <?php if($_GET['success'] == 'dezabonare'): ?>
              <div class="alert alert-success">Te-ai dezabonat cu succes.</div>
            <?php endif ?>
          <?php endif ?>
          <div class="row">
            <?php  
              $myid = $user['id'];
              $sql_abonamente = "SELECT * FROM abonamente WHERE id_abonat = '$myid' ORDER BY id DESC";
              $result_abonamente = mysqli_query($db, $sql_abonamente);
              $abonamente = mysqli_fetch_all($result_abonamente, MYSQLI_ASSOC);
            foreach($abonamente as $abonament):
            ?>
            <?php  
                $id_creator = $abonament['id_creator'];
                $sql_creator = "SELECT * FROM utilizatori WHERE id = '$id_creator'";
                $result_creator = mysqli_query($db, $sql_creator);
                $creator = $result_creator->fetch_assoc();
            ?>
            <?php

                  $sem_afisare = 1;
                  if(!isset($_SESSION['simvideo_user']['email'])){
                    if($creator['tip'] != "fara_restrictie"){
                      $sem_afisare = 0;
                    }
                  }
                  if(isset($_SESSION['simvideo_user']['email'])){
                    $id_user = $_SESSION['simvideo_user']['id'];
                    if($_SESSION['simvideo_user']['cont_minor'] == '1'){
                      $sql_minor = "SELECT * FROM utilizatori WHERE id = '$id_user'";
                      $result_minor = mysqli_query($db, $sql_minor);
                      $row_minor = $result_minor->fetch_assoc();
                      if($creator['tip'] != "fara_restrictie"){
                        if($row_minor['varsta'] < $creator['tip']){
                          $sem_afisare = 0;
                        }
                      }
                      $sql_blp = "SELECT * FROM blacklist_profile WHERE id_creator = '$id_creator' AND id_utilizator = '$id_user'";
                      $result_blp = mysqli_query($db, $sql_blp);
                      if($result_blp->num_rows > 0){
                        $sem_afisare = 0;
                      }
                    }
                  }
              ?>
              <?php if($sem_afisare == 1): ?>
            <div class="col-md-2 col-6">
              <div class="user-item card pt-3 pb-3">
                <?php if(!empty($creator['imagine'])): ?> 
                <img alt="image" src="utilizatori/<?php echo $creator['imagine']; ?>" class="img-fluid">
                <?php else: ?>
                <img alt="image" src="assets/img/vizitator.png" class="img-fluid">
                <?php endif ?>
                <div class="user-details">
                  <div class="user-name"><a href="profil.php?id=<?php echo $id_creator; ?>"><?php echo $creator['nume'] . " " . $creator['prenume']; ?></a></div>
                  <?php  
                    $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_creator'";
                    $result_abonati = mysqli_query($db, $sql_abonati);
                  ?>
                  <div class="text-job text-muted"><?php echo $result_abonati->num_rows; ?> Abonati</div>
                  <div class="user-cta">
                    <form method="POST" action="abonamente.php">
                      <input type="text" name="id_creator" value="<?php echo $id_creator; ?>" class="d-none">
                      <button class="btn btn-danger" type="submit" name="dezabonare_abonamente">Dezabonare</button>
                    </form>
                  </div>
                </div>  
              </div>
            </div>
            <?php endif ?>
            <?php endforeach ?>
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
  
  <script src="assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
  <script src="assets/modules/chart.min.js"></script>
  <script src="assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="assets/modules/summernote/summernote-bs4.js"></script>
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <script src="assets/js/page/index-0.js"></script>
  <script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="assets/js/page/components-user.js"></script>
  
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>