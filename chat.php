<?php include('functions.php'); 
      if(isset($_GET['uniqid'])){
        $uniqid = $_GET['uniqid'];
        $sql_chat = "SELECT * FROM chaturi WHERE uniqid = '$uniqid'";
        $result_chat = mysqli_query($db, $sql_chat);
        if($result_chat->num_rows > 0){
          $chat = $result_chat->fetch_assoc();
        }else{
          header("Location: index.php");
        }
      }else{
        header("Location: index.php");
      }
      if (isset($_SESSION['simvideo_user']['email'])) {
        $id_chat = $chat['id'];
        $id_utilizator = $_SESSION['simvideo_user']['id'];
        $sql_uc = "SELECT * FROM utilizatori_chat WHERE id_chat = '$id_chat' AND id_utilizator = '$id_utilizator'";
        $result_uc = mysqli_query($db, $sql_uc);
        if($result_uc->num_rows == 0){
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
  <title>SimVideo - <?php echo $chat['nume']; ?></title>
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
      <?php include('navigation.php') ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $chat['nume']; ?></h1>
          </div>
            <?php if(isset($_GET['success'])): ?>
              <?php if($_GET['success'] == 'mesaj'): ?>
                <div class="alert alert-success">Mesajul a fost trimis cu succes.</div>
              <?php endif ?>
              <?php if($_GET['success'] == 'stergere'): ?>
                <div class="alert alert-success">Mesajul a fost sters cu succes.</div>
              <?php endif ?>
            <?php endif ?>
            <div class="row">
              <div class="col-12 col-md-9 col-lg-9">
                <div class="card">
                  <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                      <?php  
                          $sql_mesaje = "SELECT * FROM mesaje_chat WHERE id_chat = '$id_chat'";
                          $result_mesaje = mysqli_query($db, $sql_mesaje);
                          $mesaje = mysqli_fetch_all($result_mesaje, MYSQLI_ASSOC);
                      foreach($mesaje as $mesaj):
                      ?>
                      <li class="media">
                        <?php  
                          $id_comentator = $mesaj['id_utilizator'];
                          $sql_comentator = "SELECT * FROM utilizatori WHERE id = '$id_comentator'";
                          $result_comentator = mysqli_query($db, $sql_comentator);
                          $comentator = $result_comentator->fetch_assoc();    
                        ?>
                        <?php if(!empty($comentator['imagine'])): ?>
                        <img alt="image" class="mr-3 rounded-circle" width="70" src="utilizatori/<?php echo $comentator['imagine']; ?>">
                        <?php else: ?>
                        <img alt="image" class="mr-3 rounded-circle" width="70" src="assets/img/vizitator.png">
                        <?php endif ?>
                        <div class="media-body">
                          <div class="media-title mb-1"><?php echo $comentator['nume'] . " " . $comentator['prenume']; ?></div>
                          <div class="text-time"><?php echo $mesaj['data']; ?></div>
                          <div class="media-description text-muted"><?php echo $mesaj['mesaj']; ?></div>
                          <?php if(!empty($mesaj['imagine'])): ?>
                          <div class="row mt-2">
                            <div class="col-sm-6">
                              <img src="chaturi/<?php echo $chat['uniqid']; ?>/<?php echo $mesaj['imagine']; ?>" class="img-fluid">
                            </div>
                          </div>
                          <?php endif ?>
                          <?php if($id_comentator == $_SESSION['simvideo_user']['id']): ?>
                          <div class="media-links">
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#stergere<?php echo $mesaj['id']; ?>">Stergere</button>
                          </div>
                          <?php endif ?>
                        </div>
                      </li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-9 col-lg-9">
                <div class="card">
                  <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                        <?php if($_SESSION['simvideo_user']['id'] == $chat['id_utilizator']): ?>
                        <?php  
                            $id_user = $chat['id_utilizator'];
                            $sql_user = "SELECT * FROM utilizatori WHERE id = '$id_user'";
                            $result_user = mysqli_query($db, $sql_user);
                            $user = $result_user->fetch_assoc();
                        ?>
                        <li class="media">
                          <?php if(!empty($user['imagine'])): ?>
                          <img alt="image" class="mr-3 rounded-circle" width="70" src="utilizatori/<?php echo $user['imagine']; ?>">
                          <?php else: ?>
                          <img alt="image" src="assets/img/vizitator.png" width="70" class="mr-3 rounded-circle">
                          <?php endif ?>
                          <div class="media-body">
                            <div class="media-title mb-1"><?php echo $user['nume'] . " " .$user['prenume']; ?></div>
                            <form method="POST" action="chat.php" enctype="multipart/form-data">
                              <input type="text" name="id_chat" value="<?php echo $chat['id']; ?>" class="d-none">
                              <input type="text" name="uniqid_chat" value="<?php echo $uniqid; ?>" class="d-none">
                              <div class="form-group">
                                <textarea class="form-control" name="mesaj" style="height: 100px !important;" placeholder="Mesajul tau"></textarea>
                              </div>
                              <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Selectare imagine</label>
                                <input type="file" name="img" id="image-upload" />
                              </div>
                              <div class="text-right mt-0">
                                <button class="btn btn-primary" type="submit" name="adauga_mesaj">Trimite mesaj</button>
                              </div>
                            </form>
                          </div>
                        </li>
                        <?php endif ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
  <?php
  foreach($mesaje as $mesaj):
  ?>
  <div class="modal fade" id="stergere<?php echo $mesaj['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stergere mesaj</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="video.php">
          <input type="text" name="uniqid_chat" value="<?php echo $uniqid; ?>" class="d-none">
          <input type="text" name="id" value="<?php echo $mesaj['id']; ?>" class="d-none">
          <div class="modal-body text-center">
            <i class="fas fa-exclamation-circle text-danger" style="font-size: 50px;"></i>
            <p>Esti sigur ca vrei sa stergi mesajul <font class="text-primary"><?php echo $mesaj['mesaj']; ?></font>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>
            <button type="submit" class="btn btn-danger" name="stergere_mesaj">Da</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach ?>
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
  <script src="assets/js/page/features-post-create.js"></script>
  
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