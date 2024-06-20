<?php include('functions.php') ?>
<?php if(!isset($_GET['result'])){
        header("Location: index.php");
      }else{
        $cautare = $_GET['result'];
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Rezultatele cautarii pentru <?php echo $cautare; ?></title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <?php 
    $cautare = $_GET['result'];
    $rezultate = array();
    $sql = "SELECT * FROM videoclipuri ORDER BY id DESC";
    $result = mysqli_query($db, $sql);
    $videoclipuri = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sem = 0;
    $kmax = 1;
    foreach ($videoclipuri as $videoclip){
        $id = $videoclip['id'];
        $k = 0;
        $string = $videoclip['titlu'];
        $words = explode(" ", $cautare);
        foreach($words as $word){
            $word = trim($word);
            if (preg_match("/\b$word\b/i", $string)){
                $k = $k + 1;
            }
        }
        if($k > 0){
            $item_array = array(
                'id'           =>  $id,
                'iap'       =>  $k
            );
            $rezultate[] = $item_array;
            $sem = 1;
            if($k > $kmax){
                $kmax = $k;
            }
        }
    }    
?>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php') ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Rezultatele cautarii</h1>
          </div>
            <?php $nr = 0; ?>
            <div class="row">
              <?php foreach($rezultate as $keys => $values): ?>
                <?php if($values['iap'] == $kmax): ?>
                <?php   
                  $id_vid = $values['id'];
                  $sql_v = "SELECT * FROM videoclipuri WHERE id = '$id_vid'";
                  $result_v = mysqli_query($db, $sql_v);
                  $videoclip = $result_v->fetch_assoc();
              ?>
              <?php $nr = $nr +1; ?>
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
                          <a href="profil.php?id=<?php echo $id_creator; ?>"><?php echo $creator['nume'] . " " . $creator['prenume']; ?></a>
                        </div>
                        <?php  
                          $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_creator'";
                          $result_abonati = mysqli_query($db, $sql_abonati);
                        ?>
                        <div class="text-job"><?php echo $result_abonati->num_rows; ?> Abonati</div>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
              <?php endif ?>
              <?php endforeach ?>
              <?php if($nr == 0): ?>
              <div class="alert alert-info w-100">Nu exista niciun rezultat pentru termenii cautati.</div>
              <?php endif ?>
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