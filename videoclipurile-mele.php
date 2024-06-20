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
  <title>SimVideo - Videoclipurile mele</title>
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
            <h1>Videoclipurile mele</h1>
          </div>
          <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#add-videoclip">Adauga videoclip</button>
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Lista videoclipuri</h4>
                  </div>
                  <?php if(isset($_GET['succes'])): ?>
                      <?php if($_GET['succes'] == 'stergere'): ?>
                        <div class="alert alert-success">Videoclipul a fost sters cu succes.</div>
                      <?php endif ?>
                    <?php endif ?>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped text-center align-items-center" id="table-2">
                        <thead>
                          <tr>
                            <th class="ps-0">Imagine</th>
                            <th>Titlu</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Vizualizari</th>
                            <th>Aprecieri</th>
                            <th>Comentarii</th>
                            <th>Actiune</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  
                              $user_id = $user['id'];
                              $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE id_creator = '$user_id'";
                              $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                              $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
                          foreach($videoclipuri as $videoclip):
                          ?>
                          <tr>
                            <?php if (!empty($videoclip['thumbnail'])): ?>
                              <td style="vertical-align: middle;"><img alt="image" src="videoclipuri/<?php echo $videoclip['uniqid'] ?>/<?php echo $videoclip['thumbnail']; ?>" width="100"></td>
                            <?php else: ?>
                              <td style="vertical-align: middle;"><img alt="image" src="videoclipuri/poster.jpg" width="100"></td>
                            <?php endif ?>
                            <td style="vertical-align: middle;"><a href="video.php?uniqid=<?php echo $videoclip['uniqid']; ?>" style="font-size: 15px;"><?php echo $videoclip['titlu']; ?></a></td>
                            <td style="vertical-align: middle;"><?php echo $videoclip['data']; ?></td>
                            <td style="vertical-align: middle;">
                              <?php if($videoclip['status'] == '1'): ?>
                              <div class="badge badge-success">Publicat</div>
                              <?php else: ?>
                              <div class="badge badge-secondary">Nepublicat</div>
                              <?php endif ?>
                            </td>
                            <td style="vertical-align: middle;"><?php echo $videoclip['vizualizari'] ?></td>
                            <?php  
                                $id_video = $videoclip['id'];
                                $sql_aprecieri = "SELECT * FROM aprecieri WHERE id_videoclip = '$id_video'";
                                $result_aprecieri = mysqli_query($db, $sql_aprecieri);
                            ?>
                            <td style="vertical-align: middle;"><?php echo $result_aprecieri->num_rows; ?></td>
                            <?php  
                                $sql_comentarii = "SELECT * FROM comentarii WHERE id_videoclip = '$id_video'";
                                $result_comentarii = mysqli_query($db, $sql_comentarii);
                            ?>
                            <td style="vertical-align: middle;"><?php echo $result_comentarii->num_rows; ?></td>
                            <td style="vertical-align: middle;"><button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#stergere<?php echo $id_video; ?>">Sterge video</button>
                                <a href="edit-video.php?uniqid=<?php echo $videoclip['uniqid']; ?>" class="btn btn-sm btn-info ml-2">Editeaza</a>
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
  <?php foreach($videoclipuri as $videoclip): ?>
  <div class="modal fade" id="stergere<?php echo $videoclip['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stergere videoclip</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="videoclipurile-mele.php">
          <input type="text" name="uniqid" value="<?php echo $videoclip['uniqid']; ?>" class="d-none">
          <input type="text" name="id" value="<?php echo $videoclip['id']; ?>" class="d-none">
          <div class="modal-body text-center">
            <i class="fas fa-exclamation-circle text-danger" style="font-size: 50px;"></i>
            <p>Esti sigur ca vrei sa stergi videoclipul <font class="text-primary"><?php echo $videoclip['titlu']; ?></font>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>
            <button type="submit" class="btn btn-danger" name="stergere_video">Da</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach ?>
  <div class="modal fade" id="add-videoclip" tabindex="-1" role="dialog" aria-labelledby="add-videoclipLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adaugare videoclip</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <input type="button" id="pickfiles" class="btn btn-success" value="Selecteaza videoclip"/>
          <div id="filelist" class="mt-2"></div>
          <div class="text-center d-flex justify-content-center">
            <a href="videoclipurile-mele.php" id="finish" class="btn btn-success mt-2" style="display: none;">Finalizare upload</a>
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