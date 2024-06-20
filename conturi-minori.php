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
  <title>SimVideo - Conturi minori</title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.full.min.js"></script>
    <script>
window.addEventListener("load", () => {
  var filelist = document.getElementById("filelist");

  var uploader = new plupload.Uploader({
    runtimes: "html5",
    browse_button: "pickfiles",
    url: "video_function.php",
    chunk_size: "10mb",
    filters: {
      max_file_size: "20000mb",
      mime_types: [{title: "Video files", extensions: "mp4, avi, mov, webm, wmv, m4v, mpg, flv"}]
    },
    init: {
      PostInit: () => { filelist.innerHTML = ""; },
      FilesAdded: (up, files) => {
        plupload.each(files, (file) => {
          let row = document.createElement("div");
          row.id = file.id;
          row.innerHTML = `${file.name} (${plupload.formatSize(file.size)}) <strong></strong>`;
          filelist.appendChild(row);
        });
        uploader.start();
      },
      UploadProgress: (up, file) => {
        document.querySelector('#pickfiles').style.display = "none";
        document.querySelector(`#${file.id} strong`).innerHTML = `${file.percent}%`;
        if(`${file.percent}` == '100'){
          document.querySelector('#finish').style.display = "block";
        }
      },
      Error: (up, err) => { console.error(err); }
    }
  });
  uploader.init();
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php') ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Conturi minori</h1>
          </div>
          <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#add-cont">Adauga cont</button>
          <?php if(isset($_GET['success'])): ?>
                      <?php if($_GET['success'] == 'stergere'): ?>
                        <div class="alert alert-success">Videoclipul a fost sters cu succes.</div>
                      <?php endif ?>
                      <?php if($_GET['success'] == 'cont'): ?>
                        <div class="alert alert-success">Contul de minor a fost creat cu succes.</div>
                      <?php endif ?>
                    <?php endif ?>
                  <?php if(isset($_GET['error'])): ?>
                    <?php if($_GET['error'] == 'email'): ?>
                      <div class="alert alert-danger">Acest email este deja inregistrat</div>
                    <?php endif ?>
                    <?php if($_GET['error'] == 'pass'): ?>
                      <div class="alert alert-danger">Parolele introduse nu coincid</div>
                    <?php endif ?>
                  <?php endif ?>
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Lista conturi de minori</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped text-center align-items-center" id="table-2">
                        <thead>
                          <tr>
                            <th class="ps-0">Imagine</th>
                            <th>Nume</th>
                            <th>Prenume</th>
                            <th>Email</th>
                            <th>Varsta</th>
                            <th>Blacklist</th>
                            <th>Vizionate</th>
                            <th>Actiuni</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  
                              $user_id = $user['id'];
                              $sql_minori = "SELECT * FROM utilizatori WHERE asociere = '$user_id'";
                              $result_minori = mysqli_query($db, $sql_minori);
                              $minori = mysqli_fetch_all($result_minori, MYSQLI_ASSOC);
                          foreach($minori as $minor):
                          ?>
                          <tr>
                            <?php if (!empty($minor['imagine'])): ?>
                              <td style="vertical-align: middle;"><img alt="image" src="utilizatori/<?php echo $minor['imagine']; ?>" width="70"></td>
                            <?php else: ?>
                              <td style="vertical-align: middle;"><img alt="image" src="assets/img/vizitator.png" width="70"></td>
                            <?php endif ?>
                            <td style="vertical-align: middle;"><?php echo $minor['nume']; ?></td>
                            <td style="vertical-align: middle;"><?php echo $minor['prenume']; ?></td>
                            <td style="vertical-align: middle;"><?php echo $minor['email']; ?></td>
                            <td style="vertical-align: middle;"><?php echo $minor['varsta']; ?> ani</td>
                            <td style="vertical-align: middle;"><a href="blacklist-profile.php?id_minor=<?php echo $minor['id']; ?>" class="btn btn-sm btn-dark ml-2">Blacklist profile</a>
                              <a href="blacklist-videoclipuri.php?id_minor=<?php echo $minor['id']; ?>" class="btn btn-sm btn-dark ml-2 mt-2">Blacklist videoclipuri</a>
                            </td>
                            <td style="vertical-align: middle;"><a href="vizionate-minor.php?id_minor=<?php echo $minor['id']; ?>" class="btn btn-sm btn-primary">Videoclipuri vizionate</a>
                            </td>
                            <td style="vertical-align: middle;"><button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#stergere<?php echo $minor['id']; ?>">Sterge cont</button>
                                <a href="edit-minor.php?id_minor=<?php echo $minor['id']; ?>" class="btn btn-sm btn-info ml-2 mt-2">Editeaza</a>
                            </td>
                          </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
  <?php foreach($minori as $minor): ?>
  <div class="modal fade" id="stergere<?php echo $minor['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stergere cont</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="conturi-minori.php">
          <input type="text" name="imagine" value="<?php echo $minor['imagine']; ?>" class="d-none">
          <input type="text" name="id" value="<?php echo $minor['id']; ?>" class="d-none">
          <div class="modal-body text-center">
            <i class="fas fa-exclamation-circle text-danger" style="font-size: 50px;"></i>
            <p>Esti sigur ca vrei sa stergi contul <font class="text-primary"><?php echo $minor['nume'] . " " . $minor['prenume']; ?></font>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>
            <button type="submit" class="btn btn-danger" name="stergere_minor">Da</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach ?>
  <div class="modal fade" id="add-cont" tabindex="-1" role="dialog" aria-labelledby="add-videoclipLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adaugare cont minor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div>
                <form method="POST" action="signup.php">
                  <div class="row">
                    <div class="form-group col-sm-6">
                      <label for="frist_name">Nume</label>
                      <input id="frist_name" type="text" class="form-control" name="nume" autofocus required>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="last_name">Prenume</label>
                      <input id="last_name" type="text" class="form-control" name="prenume" autofocus required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-sm-12">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" autofocus required>
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
                      <label for="data_nasterii" class="d-block">Varsta</label>
                      <select class="form-control selectric" name="varsta">
                              <option value="1">1 an</option>
                              <option value="2">2 ani</option>
                              <option value="3">3 ani</option>
                              <option value="4">4 ani</option>
                              <option value="5">5 ani</option>
                              <option value="6">6 ani</option>
                              <option value="7">7 ani</option>
                              <option value="8">8 ani</option>
                              <option value="9">9 ani</option>
                              <option value="10">10 ani</option>
                              <option value="11">11 ani</option>
                              <option value="12">12 ani</option>
                              <option value="13">13 ani</option>
                              <option value="14">14 ani</option>
                              <option value="15">15 ani</option>
                              <option value="16">16 ani</option>
                              <option value="17">17 ani</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="signup_minor" class="btn btn-primary btn-lg btn-block">
                      Creare cont
                    </button>
                  </div>
                </form>
              </div>
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
  
  <!-- JS Libraies -->
  <script src="assets/modules/datatables/datatables.min.js"></script>
  <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
  <script src="assets/modules/jquery-ui/jquery-ui.min.js"></script>

  <script src="assets/js/page/modules-datatables.js"></script>
  
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>