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
  <title>SimVideo - Acasa abonamente</title>
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
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php') ?>
      <?php  
                if(!isset($_GET['categorie'])){
                  $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE status = '1' ORDER BY id DESC";
                  $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                  $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
                  $text = "Noutati abonamente ";
                }
                if(isset($_GET['categorie']) && !isset($_GET['subcategorie'])){
                  $categorie = $_GET['categorie'];
                  $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE categorie = '$categorie' AND status = '1' ORDER BY id DESC";
                  $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                  $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);

                  $cat = $_GET['categorie'];
                  $sql_cat = "SELECT * FROM categorii WHERE id = '$cat'";
                  $result_cat = mysqli_query($db, $sql_cat);
                  $row_cat = $result_cat->fetch_assoc();

                  $text = "Noutati abonamente " . $row_cat['nume'];
                }
                if(isset($_GET['categorie']) && isset($_GET['subcategorie'])){
                  $categorie = $_GET['categorie'];
                  $subcategorie = $_GET['subcategorie'];
                  $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE categorie = '$categorie' AND subcategorie = '$subcategorie' AND status = '1' ORDER BY id DESC";
                  $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                  $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);

                  $cat = $_GET['categorie'];
                  $sql_cat = "SELECT * FROM categorii WHERE id = '$cat'";
                  $result_cat = mysqli_query($db, $sql_cat);
                  $row_cat = $result_cat->fetch_assoc();

                  $subcat = $_GET['subcategorie'];
                  $sql_subcat = "SELECT * FROM subcategorii WHERE id = '$subcat'";
                  $result_subcat = mysqli_query($db, $sql_subcat);
                  $row_subcat = $result_subcat->fetch_assoc();

                  $text = "Noutati abonamente " . $row_cat['nume'] . " -> " . $row_subcat['nume'];
                }
      ?>
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Acasa abonamente</h1> <a class="btn btn-info ml-3 text-white" data-toggle="modal" data-target="#edit-categorie">Filtrare</a>
          </div>
          <h2 class="section-title"><?php echo $text; ?></h2>
            <div class="row">
              <?php  
                $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE status = '1' ORDER BY id DESC";
                $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
                foreach($videoclipuri as $videoclip):
              ?>
              <?php  
                  $myid = $user['id'];
                  $id_creator = $videoclip['id_creator'];
                  $sql_abonat = "SELECT * FROM abonamente WHERE id_abonat = '$myid' AND id_creator = '$id_creator'";
                  $result_abonat = mysqli_query($db, $sql_abonat);
              if($result_abonat->num_rows > 0):
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
                    <div class="article-details">
                      <div class="article-category"><a><?php echo $videoclip['durata']; ?></a> <div class="bullet"></div> <a><?php echo $videoclip['vizualizari']; ?> vizualizari</a> <div class="bullet"></div> <a><?php echo $videoclip['data']; ?></a></div>
                      <div class="article-title">
                        <h2><a href="video.php?uniqid=<?php echo $videoclip['uniqid']; ?>"><?php echo $videoclip['titlu']; ?></a></h2>
                      </div>
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
              <?php endif ?>
              <?php endforeach ?>
            </div>
        </section>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit-categorie" tabindex="-1" role="dialog" aria-labelledby="edit-categorieLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filtrare dupa categorie</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="edit-video.php" class="mt-3">
            <input type="text" name="pagina" value="acasa-abonamente.php" class="d-none">
            <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Categorie</label>
                        <div class="col-sm-12 col-md-7">
                          <select class="form-control selectric" name="categorie" id="categorie" aria-label="Categorie" onchange="my_fun(this.value);" required>
                                    <option value="0">Selecteaza categorie</option>
                                    <?php  
                                        $sql_categorii = "SELECT * FROM categorii ORDER BY nume ASC";
                                        $result_categorii = mysqli_query($db, $sql_categorii);
                                        $categorii = mysqli_fetch_all($result_categorii, MYSQLI_ASSOC);
                                    foreach($categorii as $categorie):
                                    ?>
                                      <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['nume']; ?></option>
                                    <?php endforeach ?>
                                  </select>
                        </div>
                      </div>
              <div class="form-group row mb-4" >
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Subcategorie</label>
                        <div class="col-sm-12 col-md-7" id="select_subcategorie">
                          <select class="form-control selectric" name="categorie" id="categorie" aria-label="Categorie" onchange="my_fun(this.value);" required>
                          </select>
                        </div>
                      </div>
              <div class="text-center">
                <button class="btn btn-primary" type="submit" name="filtrare_index">Salveaza modificarile</button>
              </div>
          </form>
        </div>
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