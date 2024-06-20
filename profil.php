<?php include('functions.php'); 
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql_profil = "SELECT * FROM utilizatori WHERE id = '$id'";
        $result_profil = mysqli_query($db, $sql_profil);
        if($result_profil->num_rows > 0){
          $profil = $result_profil->fetch_assoc();
        }else{
          header("Location: index.php");
        }
      }else{
        header("Location: index.php");
      }
?>
<?php
                  $id_creator = $profil['id'];
                  $sem_afisare = 1;
                  if(!isset($_SESSION['simvideo_user']['email'])){
                    if($profil['tip'] != "fara_restrictie"){
                      $sem_afisare = 0;
                    }
                  }
                  if(isset($_SESSION['simvideo_user']['email'])){
                    $id_user = $_SESSION['simvideo_user']['id'];
                    if($_SESSION['simvideo_user']['cont_minor'] == '1'){
                      $sql_minor = "SELECT * FROM utilizatori WHERE id = '$id_user'";
                      $result_minor = mysqli_query($db, $sql_minor);
                      $row_minor = $result_minor->fetch_assoc();
                      if($profil['tip'] != "fara_restrictie"){
                        if($row_minor['varsta'] < $profil['tip']){
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
              <?php if($sem_afisare == 0) 
                    header("Location: index.php");
              ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - <?php echo $profil['nume'] . " " . $profil['prenume']; ?></title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">

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
            <h1>Profil <?php echo $profil['nume'] . " " . $profil['prenume']; ?></h1>
          </div>
            <div class="row">
              <div class="col-12 col-sm-12 col-lg-12">
                <div class="card author-box card-primary">
                  <div class="card-body">
                    <div class="author-box-left">
                      <?php if(!empty($profil['imagine'])): ?> 
                      <img alt="image" src="utilizatori/<?php echo $profil['imagine']; ?>" class="rounded-circle author-box-picture">
                      <?php else: ?>
                      <img alt="image" src="assets/img/vizitator.png" class="rounded-circle author-box-picture">
                      <?php endif ?>
                      <div class="clearfix"></div>
                      <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
                      <form method="POST" action="profil.php">
                        <input type="text" name="id_creator" value="<?php echo $id; ?>" class="d-none">
                        <?php  
                            $myid = $user['id'];
                            $id_creator = $profil['id'];
                            $sql_abonat = "SELECT * FROM abonamente WHERE id_abonat = '$myid' AND id_creator = '$id_creator'";
                            $result_abonat = mysqli_query($db, $sql_abonat);
                        if($result_abonat->num_rows > 0):
                        ?>
                        <button class="btn btn-danger mt-3" name="dezabonare_profil">Dezabonare</button>
                        <?php else: ?>
                        <button class="btn btn-primary mt-3" name="abonare_profil">Abonare</button>
                        <?php endif ?>
                      </form>
                      <?php endif ?>
                      <?php 
                                $user_id = $profil['id'];
                                $sql_chat = "SELECT * FROM chaturi WHERE id_utilizator = '$user_id'";
                                $result_chat = mysqli_query($db, $sql_chat);
                            if($result_chat->num_rows > 0 && isset($_SESSION['simvideo_user']['email'])):
                            ?>
                              <?php if($_SESSION['simvideo_user']['cont_minor'] == '0'): ?>
                              <form method="POST" action="video.php">
                                <?php  
                                  $row_chat = $result_chat->fetch_assoc();
                                ?>
                                <input type="text" name="id" value="<?php echo $row_chat['id']; ?>" class="d-none">
                                <input type="text" name="uniqid" value="<?php echo $row_chat['uniqid']; ?>" class="d-none">
                                <button type="submit" name="join_chat" class="btn btn-success btn-sm mt-3">Chat comunitate</button>
                              </form>
                              <?php endif ?>
                            <?php endif ?>
                    </div>
                    <div class="author-box-details">
                      <div class="author-box-name">
                        <a class="text-primary"><?php echo $profil['nume'] . " " . $profil['prenume']; ?></a>
                      </div>
                      <?php  
                        $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id'";
                        $result_abonati = mysqli_query($db, $sql_abonati);
                      ?>
                      <div class="author-box-job"><?php echo $result_abonati->num_rows; ?> Abonati</div>
                      <div class="author-box-description">
                        <p><?php echo $profil['descriere']; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php  
                $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE id_creator = '$id' AND status = '1' ORDER BY id DESC";
                $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
            ?>
            <h2 class="section-title">Videoclipuri (<?php echo $result_videoclipuri->num_rows; ?>)</h2>
            <div class="row">
              <?php
                $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
                foreach($videoclipuri as $videoclip):
              ?>
              <?php  

                  $id_videoclip = $videoclip['id'];
                  $id_creator = $videoclip['id_creator'];
                  $sql_creator = "SELECT * FROM utilizatori WHERE id = '$id_creator'";
                  $result_creator = mysqli_query($db, $sql_creator);
                  $creator = $result_creator->fetch_assoc();

                  $sem_afisare = 1;
                  if(!isset($_SESSION['simvideo_user']['email'])){
                    if($videoclip['tip'] != "fara_restrictie"){
                      $sem_afisare = 0;
                    }
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
                      if($videoclip['tip'] != "fara_restrictie"){
                        if($row_minor['varsta'] < $videoclip['tip']){
                          $sem_afisare = 0;
                        }
                      }
                      if($creator['tip'] != "fara_restrictie"){
                        if($row_minor['varsta'] < $creator['tip']){
                          $sem_afisare = 0;
                        }
                      }
                      $sql_blv = "SELECT * FROM blacklist_videoclipuri WHERE id_videoclip = '$id_videoclip' AND id_utilizator = '$id_user'";
                      $result_blv = mysqli_query($db, $sql_blv);
                      if($result_blv->num_rows > 0){
                        $sem_afisare = 0;
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
                  <div class="article-details pb-2">
                    <div class="article-category"><a><?php echo $videoclip['durata']; ?></a> <div class="bullet"></div> <a><?php echo $videoclip['vizualizari']; ?> vizualizari</a> <div class="bullet"></div> <a><?php echo $videoclip['data']; ?></a></div>
                    <div class="article-title">
                      <h2><a href="video.php?uniqid=<?php echo $videoclip['uniqid']; ?>"><?php echo $videoclip['titlu']; ?></a></h2>
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