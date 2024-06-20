<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto" action="cautare.php" method="GET">
          <ul class="navbar-nav mr-3">
            <li><a href="index.php" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="index.php" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="text" name="result" <?php if(isset($_GET['result'])){echo "value='" . $_GET['result'] . "'";} ?> placeholder="Cauta videoclip" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
            <?php  
            $email = $_SESSION['simvideo_user']['email'];
            $sql_user = "SELECT * FROM utilizatori where email = '$email' ";
            $result_user = mysqli_query($db, $sql_user);
            $user = $result_user->fetch_assoc();
            ?>
            <?php if(!empty($user['imagine'])): ?>
            <img alt="image" src="utilizatori/<?php echo $user['imagine']; ?>" class="rounded-circle mr-1">
            <?php else: ?>
            <img alt="image" src="assets/img/vizitator.png" class="rounded-circle mr-1">
            <?php endif ?>
            <div class="d-sm-none d-lg-inline-block"><?php echo $user['prenume']; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <?php if($_SESSION['simvideo_user']['cont_minor'] == '0'): ?>
              <a href="profilul-meu.php?id=<?php echo $user['id']; ?>" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              <a href="edit-profil.php" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Setari profil
              </a>
              <?php endif ?>
              <div class="dropdown-divider"></div>
              <a href="index.php?logout=1" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Deconectare
              </a>
            </div>
            <?php else: ?>
            <img alt="image" src="assets/img/vizitator.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Vizitator</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="login.php" class="dropdown-item has-icon">
                <i class="fas fa-sign-in-alt"></i> Conectare
              </a>
              <a href="signup.php" class="dropdown-item has-icon">
                <i class="fas fa-user-plus"></i> Creare cont
              </a>
            </div>
            <?php endif ?>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.php"><img src="assets/img/logo.png" class="w-75"></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php"><img src="assets/img/logo-min.png" class="w-75"></a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">General</li>
            <li><a class="nav-link" href="index.php"><i class="fas fa-home"></i> <span>Acasa</span></a></li>
            <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
             <li><a class="nav-link" href="acasa-abonamente.php"><i class="fas fa-home"></i> <span>Acasa abonamente</span></a></li>
            <li><a class="nav-link" href="videoclipuri-apreciate.php"><i class="fas fa-thumbs-up"></i> <span>Videoclipuri apreciate</span></a></li>
            <li><a class="nav-link" href="vizionate.php"><i class="far fa-eye"></i> <span>Videoclipuri vizionate</span></a></li>
            <li><a class="nav-link" href="abonamente.php"><i class="fas fa-check-square"></i> <span>Abonamente</span></a></li>
            <?php endif ?>
            <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
            <li class="menu-header">Cont</li>
            <?php if($_SESSION['simvideo_user']['cont_minor'] == '0'): ?>
            <li><a class="nav-link" href="profilul-meu.php"><i class="fas fa-user"></i> <span>Profil</span></a></li>
            <li><a class="nav-link" href="edit-profil.php"><i class="fas fa-user-cog"></i> <span>Editare profil</span></a></li>
            <li><a class="nav-link" href="conturi-minori.php"><i class="fas fa-child"></i> <span>Conturi minori</span></a></li>
            <li><a class="nav-link" href="videoclipurile-mele.php"><i class="fas fa-film"></i> <span>Videoclipurile mele</span></a></li>
            <?php endif ?>
            <li><a class="nav-link" href="index.php?logout=1"><i class="fas fa-sign-out-alt"></i> <span>Deconectare</span></a></li>
            <?php else: ?>
            <li class="menu-header">Cont</li>
            <li><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> <span>Conectare</span></a></li>
            <li><a class="nav-link" href="signup.php"><i class="fas fa-user-plus"></i> <span>Creare cont</span></a></li>
            <?php endif ?>
          </ul>
        </aside>
      </div>