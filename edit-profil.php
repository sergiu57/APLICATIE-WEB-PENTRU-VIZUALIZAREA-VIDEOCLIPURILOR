<?php include('functions.php'); 
      if(!isset($_SESSION['simvideo_user']['email'])){
        header("Location: index.php");
      }
      if($_SESSION['simvideo_user']['cont_minor'] == '1'){
        header("Location: index.php");
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Editare profil</title>
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
                <?php if($_GET['success'] == 'chat'): ?>
                  <div class="alert alert-success">Chat-ul a fost creat cu succes.</div>
                <?php endif ?>
                <?php if($_GET['success'] == 'stergere_chat'): ?>
                  <div class="alert alert-success">Chat-ul a fost sters cu succes.</div>
                <?php endif ?>
                <?php if($_GET['success'] == 'editare_chat'): ?>
                  <div class="alert alert-success">Chat-ul a fost editat cu succes.</div>
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
                    <?php if(!empty($user['imagine'])): ?>                   
                    <img alt="image" src="utilizatori/<?php echo $user['imagine']; ?>" class="rounded-circle profile-widget-picture">
                    <?php else: ?>
                    <img alt="image" src="assets/img/vizitator.png" class="rounded-circle profile-widget-picture">
                    <?php endif ?>
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Abonati</div>
                        <?php  
                            $id_user = $user['id'];
                            $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_user'";
                            $result_abonati = mysqli_query($db, $sql_abonati);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_abonati->num_rows; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Videoclipuri</div>
                        <?php  
                            $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE id_creator = '$id_user'";
                            $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_videoclipuri->num_rows; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Aprecieri</div>
                        <?php  
                            $sql_aprecieri = "SELECT * FROM aprecieri WHERE id_creator = '$id_user'";
                            $result_aprecieri = mysqli_query($db, $sql_aprecieri);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_aprecieri->num_rows; ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?php echo $user['nume'] . " " . $user['prenume']; ?></div>
                    <?php echo $user['descriere']; ?>
                  </div>
                </div>
                <div class="card">
                  <form method="post" action="edit-profil.php">
                    <div class="card-header">
                      <h4>Editare parola</h4>
                    </div>
                    <div class="card-body">
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
                      <button class="btn btn-primary" type="submit" name="edit_parola">Salveaza modificarile</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" action="edit-profil.php" enctype="multipart/form-data">
                    <div class="card-header">
                      <h4>Editare profil</h4>
                    </div>
                    <div class="card-body">
                        <div class="row"> 
                          <div class="col-md-12 mb-4">
                            <div id="image-preview" class="image-preview">
                              <label for="image-upload" id="image-label">Imagine profil</label>
                              <input type="file" name="img" id="image-upload" />
                            </div>
                          </div>                              
                          <div class="form-group col-md-6 col-12">
                            <label>Nume</label>
                            <input type="text" class="form-control" name="nume" value="<?php echo $user['nume']; ?>" required>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Prenume</label>
                            <input type="text" class="form-control" name="prenume" value="<?php echo $user['prenume']; ?>" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" readonly>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Telefon</label>
                            <input type="text" class="form-control" name="telefon" value="<?php echo $user['telefon']; ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-12">
                            <label>Despre mine</label>
                            <textarea class="form-control" name="descriere" style="height: 150px !important;"><?php echo $user['descriere']; ?></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Data nasterii</label>
                            <input type="date" class="form-control" name="data_nasterii" value="<?php echo $user['data_nasterii']; ?>">
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Tip cont</label>
                            <select class="form-control selectric" name="tip">
                              <option value="fara_restrictie" <?php if($user['tip'] == 'fara_restrictie'){ echo "selected"; } ?>>Fara restrictie</option>
                              <option value="4" <?php if($user['tip'] == '4'){ echo "selected"; } ?>>Minim 4 ani</option>
                              <option value="9" <?php if($user['tip'] == '9'){ echo "selected"; } ?>>Minim 9 ani</option>
                              <option value="14" <?php if($user['tip'] == '14'){ echo "selected"; } ?>>Minim 14 ani</option>
                              <option value="18" <?php if($user['tip'] == '18'){ echo "selected"; } ?>>Minim 18 ani</option>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right mt-0 pt-0">
                      <button class="btn btn-primary" name="edit_profil">Salveaza modificarile</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php 
                $user_id = $user['id'];
                $sql_chat = "SELECT * FROM chaturi WHERE id_utilizator = '$user_id'";
                $result_chat = mysqli_query($db, $sql_chat);
            ?>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Chat comunitate</h4>
                    <?php if($result_chat->num_rows == 0): ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#add-chat">Adauga chat</button>
                    <?php endif ?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped text-center align-items-center" id="table-2">
                        <thead>
                          <tr>
                            <th>Nume</th>
                            <th>Utilizatori</th>
                            <th>Accesare</th>
                            <th>Actiuni</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  
                              $row_chat = $result_chat->fetch_assoc();
                          if($result_chat->num_rows > 0):
                          ?>
                          <tr>
                            <td style="vertical-align: middle;"><?php echo $row_chat['nume']; ?></td>
                            <?php 
                                $id_chat = $row_chat['id'];
                                $sql_utilizatori = "SELECT * FROM utilizatori_chat WHERE id_chat = '$id_chat'";
                                $result_utilizatori = mysqli_query($db, $sql_utilizatori);
                            ?>
                            <td style="vertical-align: middle;"><?php echo $result_utilizatori->num_rows; ?></td>
                            <td style="vertical-align: middle;">
                                <form method="POST" action="edit-profil.php">
                                  <input type="text" name="id" value="<?php echo $row_chat['id']; ?>" class="d-none">
                                  <input type="text" name="uniqid" value="<?php echo $row_chat['uniqid']; ?>" class="d-none">
                                  <button type="submit" name="join_chat" class="btn btn-success btn-sm">Acceseaza</button>
                                </form>
                            </td>
                            <td style="vertical-align: middle;"><button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#stergere-chat">Sterge chat</button>
                                <button data-toggle="modal" data-target="#editare-chat" class="btn btn-sm btn-info ml-2">Editeaza</button>
                            </td>
                          </tr>
                          <?php endif ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <div class="modal fade" id="add-chat" tabindex="-1" role="dialog" aria-labelledby="add-chatLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adaugare chat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div>
                <form method="POST" action="edit-profil.php">
                  <div class="row">
                    <div class="form-group col-12">
                      <label for="frist_name">Nume</label>
                      <input id="frist_name" type="text" class="form-control" name="nume" autofocus required>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="creare_chat" class="btn btn-primary btn-lg btn-block">
                      Creare chat
                    </button>
                  </div>
                </form>
              </div>
        </div>
      </div>
    </div>
  </div>
  <?php if($result_chat->num_rows > 0): ?>
  <div class="modal fade" id="editare-chat" tabindex="-1" role="dialog" aria-labelledby="editare-chatLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editare chat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div>
                <form method="POST" action="edit-profil.php">
                  <input type="text" name="id" value="<?php echo $row_chat['id']; ?>" class="d-none">
                  <div class="row">
                    <div class="form-group col-12">
                      <label for="frist_name">Nume</label>
                      <input id="frist_name" type="text" value="<?php echo $row_chat['nume']; ?>" class="form-control" name="nume" autofocus required>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="editare_chat" class="btn btn-primary btn-lg btn-block">
                      Salveaza
                    </button>
                  </div>
                </form>
              </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif ?>
  <?php if($result_chat->num_rows > 0): ?>
  <div class="modal fade" id="stergere-chat" tabindex="-1" role="dialog" aria-labelledby="stergere-chatLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stergere chat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="edit-profil.php">
          <input type="text" name="uniqid" value="<?php echo $row_chat['uniqid']; ?>" class="d-none">
          <input type="text" name="id" value="<?php echo $row_chat['id']; ?>" class="d-none">
          <div class="modal-body text-center">
            <i class="fas fa-exclamation-circle text-danger" style="font-size: 50px;"></i>
            <p>Esti sigur ca vrei sa stergi chatul <font class="text-primary"><?php echo $row_chat['nume']; ?></font>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>
            <button type="submit" class="btn btn-danger" name="stergere_chat">Da</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endif ?>
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