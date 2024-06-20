<?php include('functions.php'); 
      if(isset($_SESSION['simvideo_user']['email'])){
        if(isset($_GET['uniqid'])){
          $id_creator = $_SESSION['simvideo_user']['id'];
          $uniqid = $_GET['uniqid'];
          $sql_video = "SELECT * FROM videoclipuri WHERE uniqid = '$uniqid' AND id_creator = '$id_creator'";
          $result_video = mysqli_query($db, $sql_video);
          if($result_video->num_rows > 0){
            $video = $result_video->fetch_assoc();
          }else{
            header("Location: videoclipurile-mele.php");
          }
        }else{
          header("Location: videoclipurile-mele.php");
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
  <title>Simvideo - Editare <?php echo $video['titlu']; ?></title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.full.min.js"></script>
    <script>
window.addEventListener("load", () => {
  var filelist = document.getElementById("filelist");

  var uploader = new plupload.Uploader({
    runtimes: "html5",
    browse_button: "pickfiles",
    url: "inlocuire_video_function.php?uniqid=<?php echo $uniqid; ?>",
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
<script>
      function my_fun(str){
        if(window.XMLHttpRequest){
          xmlhttp = new XMLHttpRequest();
        }else{
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
            document.getElementById("select_subcategorie").innerHTML = this.responseText;
          }
        }
          xmlhttp.open("GET", "select-subcategorie.php?value="+str, true);
          xmlhttp.send();
      }
    </script>
</head>

<body>
    <script>

$(document).ready(function(){
      $("#video").on(
        "timeupdate", 
        function(event){
          onTrackedVideoFrame(this.currentTime, this.duration);
        });
    });

    function onTrackedVideoFrame(currentTime, duration){
        $.ajax({
            type : "POST",
             url : "duration-function.php?uniqid=<?php echo $uniqid; ?>", 
            data :  {video_duration: duration}, 
            success : function(r)
             {
             }
          });
    }
</script>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php') ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Videoclip #<?php echo $uniqid; ?></h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Editare videoclip</h4>
                  </div>
                  <div class="card-body">
                    <?php if(isset($_GET['success'])): ?>
                      <?php if($_GET['success'] == 'edit'): ?>
                        <div class="alert alert-success">Videoclipul a fost editat cu succes.</div>
                      <?php endif ?>
                    <?php endif ?>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Videoclip</label>
                      <div class="col-sm-12 col-md-7">
                        <video controls class="video w-100" id="video">
                          <source src="videoclipuri/<?php echo $uniqid; ?>/<?php echo $video['video']; ?>" type="video/mp4"></source>
                        </video>
                        <input type="button" id="pickfiles" class="btn btn-success mt-3" value="Inlocuire videoclip"/>
                        <div id="filelist" class="mt-2"></div>
                        <div class="text-center d-flex justify-content-center">
                          <a href="edit-video.php?uniqid=<?php echo $uniqid; ?>" id="finish" class="btn btn-success mt-2" style="display: none;">Finalizare upload</a>
                        </div>
                      </div>
                    </div>
                    <form method="POST" action="edit-video.php" enctype="multipart/form-data">
                      <input type="text" name="uniqid" value="<?php echo $video['uniqid']; ?>" class="d-none">
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Titlu</label>
                        <div class="col-sm-12 col-md-7">
                          <input type="text" name="titlu" value="<?php echo $video['titlu']; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Descriere</label>
                        <div class="col-sm-12 col-md-7 form-group">
                          <textarea class="form-control" name="descriere" style="height: 150px !important"><?php echo $video['descriere']; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                        <div class="col-sm-12 col-md-5">
                          <?php if (!empty($video['thumbnail'])): ?>
                          <img src="videoclipuri/<?php echo $video['uniqid'] ?>/<?php echo $video['thumbnail']; ?>" style="width: 100%;">
                          <?php else: ?>
                          <img src="videoclipuri/poster.jpg" style="width: 100%;">
                          <?php endif ?>
                        </div>
                        <div class="col-sm-12 col-md-4">
                          <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Inlocuire thumbnail</label>
                            <input type="file" name="img" id="image-upload" />
                          </div>
                        </div>
                      </div>
                      <div class="row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Categorie</label>
                        <div class="col-sm-12 col-md-7">
                          <?php  
                              $cat = $video['categorie'];
                              $sql_cat = "SELECT * FROM categorii WHERE id = '$cat'";
                              $result_cat = mysqli_query($db, $sql_cat);
                              $row_cat = $result_cat->fetch_assoc();

                              $subcat = $video['subcategorie'];
                              $sql_subcat = "SELECT * FROM subcategorii WHERE id = '$subcat'";
                              $result_subcat = mysqli_query($db, $sql_subcat);
                              $row_subcat = $result_subcat->fetch_assoc();
                          ?>
                          <?php echo $row_cat['nume']; ?> -> <?php echo $row_subcat['nume']; ?> <br>
                          <a class="btn btn-primary mt-2 text-white" data-toggle="modal" data-target="#edit-categorie">Editare</a>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                        <div class="col-sm-12 col-md-7">
                          <select class="form-control selectric" name="status">
                            <option value="1" <?php if($video['status'] == '1'){ echo "selected"; } ?>>Publicat</option>
                            <option value="0" <?php if($video['status'] == '0'){ echo "selected"; } ?>>Nepublicat</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tip Videoclip</label>
                        <div class="col-sm-12 col-md-7">
                          <select class="form-control selectric" name="tip">
                            <option value="fara_restrictie" <?php if($video['tip'] == 'fara_restrictie'){ echo "selected"; } ?>>Fara restrictie</option>
                            <option value="4" <?php if($video['tip'] == '4'){ echo "selected"; } ?>>Minim 4 ani</option>
                            <option value="9" <?php if($video['tip'] == '9'){ echo "selected"; } ?>>Minim 9 ani</option>
                            <option value="14" <?php if($video['tip'] == '14'){ echo "selected"; } ?>>Minim 14 ani</option>
                            <option value="18" <?php if($video['tip'] == '18'){ echo "selected"; } ?>>Minim 18 ani</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                          <button class="btn btn-primary" type="submit" name="edit_video">Salveaza modificarile</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit-categorie" tabindex="-1" role="dialog" aria-labelledby="edit-categorieLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editare categorie</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="edit-video.php" class="mt-3">
            <input type="text" name="uniqid" value="<?php echo $video['uniqid']; ?>" class="d-none">
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
                <button class="btn btn-primary" type="submit" name="edit_categorie">Salveaza modificarile</button>
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
  
  <!-- JS Libraies -->
  
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
  <script src="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="assets/js/page/features-post-create.js"></script>
  
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>