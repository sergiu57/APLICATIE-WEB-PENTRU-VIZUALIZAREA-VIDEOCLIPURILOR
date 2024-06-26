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
  <title>SimVideo - Adaugare videoclip in blacklist</title>
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
            <h1>Adaugare videoclip in blacklist</h1>
          </div>
          <a href="blacklist-videoclipuri.php?id_minor=<?php echo $id_minor; ?>" class="btn btn-primary mb-4">Inapoi la blacklist</a>
          <?php if(isset($_GET['success'])): ?>
            <?php if($_GET['success'] == 'adaugare'): ?>
              <div class="alert alert-success">Videoclipul a fost adaugat cu succes in blacklist.</div>
            <?php endif ?>
          <?php endif ?>
          <div class="row">
            <?php  
              $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE status = '1' ORDER BY id ASC";
              $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
              $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
            foreach($videoclipuri as $videoclip):
            ?>
            <?php  
                $id_videoclip = $videoclip['id'];
                $sql_blacklist = "SELECT * FROM blacklist_videoclipuri WHERE id_utilizator = '$id_minor' AND id_videoclip = '$id_videoclip' ORDER BY id DESC";
                $result_blacklist = mysqli_query($db, $sql_blacklist);

                $id_creator = $videoclip['id_creator'];
                $sql_blacklistp = "SELECT * FROM blacklist_profile WHERE id_utilizator = '$id_minor' AND id_creator = '$id_creator' ORDER BY id DESC";
                $result_blacklistp = mysqli_query($db, $sql_blacklistp);
            if($result_blacklist->num_rows == 0 && $result_blacklistp->num_rows == 0):
            ?>
              <div class="col-12 col-md-4 col-lg-4">
                <article class="article article-style-c">
                  <div class="article-header">
                    <?php if (!empty($videoclip['thumbnail'])): ?>
                      <div class="article-image" data-background="videoclipuri/<?php echo $videoclip['uniqid'] ?>/<?php echo $videoclip['thumbnail']; ?>">
                    <?php else: ?>
                      <div class="article-image" data-background="videoclipuri/poster.jpg">
                    <?php endif ?>
                    </div>
                  </div>
                  <div class="article-details">
                    <div class="article-category"><a><?php echo $videoclip['durata']; ?></a> <div class="bullet"></div> <a><?php echo $videoclip['vizualizari']; ?> vizualizari</a> <div class="bullet"></div> <a><?php echo $videoclip['data']; ?></a></div>
                    <div class="article-title">
                      <h2><a href="video.php?uniqid=<?php echo $videoclip['uniqid']; ?>"><?php echo $videoclip['titlu']; ?></a></h2>
                    </div>
                    <?php  
                      $id_creator = $videoclip['id_creator'];
                      $sql_creator = "SELECT * FROM utilizatori WHERE id = '$id_creator'";
                      $result_creator = mysqli_query($db, $sql_creator);
                      $creator = $result_creator->fetch_assoc();
                    ?>
                    <div class="article-user">
                      <?php if(!empty($creator['imagine'])): ?> 
                      <img alt="image" src="utilizatori/<?php echo $creator['imagine']; ?>">
                      <?php else: ?>
                      <img alt="image" src="assets/img/vizitator.png">
                      <?php endif ?>
                      <div class="article-user-details">
                        <div class="user-detail-name">
                          <a href="profil.php?nume=<?php echo $creator['nume'] . " " . $creator['prenume']; ?>&id=<?php echo $id_creator; ?>"><?php echo $creator['nume'] . " " . $creator['prenume']; ?></a>
                        </div>
                        <?php  
                          $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_creator'";
                          $result_abonati = mysqli_query($db, $sql_abonati);
                        ?>
                        <div class="text-job"><?php echo $result_abonati->num_rows; ?> Abonati</div>
                      </div>
                      <div class="user-cta text-center mt-3">
                        <form method="POST" action="adaugare-videoclip-blacklist.php">
                          <input type="text" name="id_minor" value="<?php echo $id_minor; ?>" class="d-none">
                          <input type="text" name="id_videoclip" value="<?php echo $id_videoclip; ?>" class="d-none">
                          <button class="btn btn-dark" type="submit" name="adaugare_blacklist_videoclip">Adaugare</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </article>
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