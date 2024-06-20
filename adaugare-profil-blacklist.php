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
  <title>SimVideo - Adaugare profil in blacklist</title>
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
            <h1>Adaugare profil in blacklist</h1>
          </div>
          <a href="blacklist-profile.php?id_minor=<?php echo $id_minor; ?>" class="btn btn-primary mb-4">Inapoi la blacklist</a>
          <?php if(isset($_GET['success'])): ?>
            <?php if($_GET['success'] == 'adaugare'): ?>
              <div class="alert alert-success">Profilul a fost adaugat cu succes in blacklist.</div>
            <?php endif ?>
          <?php endif ?>
          <div class="row">
            <?php  
              $sql_creatori = "SELECT * FROM utilizatori WHERE cont_minor = '0' ORDER BY id ASC";
              $result_creatori = mysqli_query($db, $sql_creatori);
              $creatori = mysqli_fetch_all($result_creatori, MYSQLI_ASSOC);
            foreach($creatori as $creator):
            ?>
            <?php  
                $id_creator = $creator['id'];
                $sql_blacklist = "SELECT * FROM blacklist_profile WHERE id_utilizator = '$id_minor' AND id_creator = '$id_creator' ORDER BY id DESC";
                $result_blacklist = mysqli_query($db, $sql_blacklist);
            if($result_blacklist->num_rows == 0):
            ?>
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
                      <form method="POST" action="blacklist-profile.php">
                        <input type="text" name="id_minor" value="<?php echo $id_minor; ?>" class="d-none">
                        <input type="text" name="id_creator" value="<?php echo $id_creator; ?>" class="d-none">
                        <button class="btn btn-dark" type="submit" name="adaugare_blacklist_profil">Adaugare</button>
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