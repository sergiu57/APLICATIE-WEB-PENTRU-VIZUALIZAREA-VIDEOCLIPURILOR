<?php
    session_start();
	$db = mysqli_connect('localhost', 'root', '', 'simvideo');

	if(isset($_POST['signup'])){
        signup();
    }
    function signup(){
        global $db;
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];
        $parola_i = $_POST['parola_i'];
        $parola_r = $_POST['parola_r'];
        date_default_timezone_set('Europe/Bucharest');
        $data_actuala = date("Y-m-d", strtotime('now'));
        $data_nasterii = $_POST['data_nasterii'];
        $datetime1 = date_create($data_nasterii);
        $datetime2 = date_create($data_actuala);
        $interval = date_diff($datetime1, $datetime2);
        $nr_ani = $interval->format('%y');
        if($nr_ani < 18){
            header("Location: signup.php?error=data_nasterii");
            exit();
        }
        $sqls = "SELECT * FROM utilizatori WHERE email = '$email'";
        $results = mysqli_query($db, $sqls);
        if($results->num_rows > 0){
            header("Location: signup.php?error=email");
            exit();
        }
        if($parola_i != $parola_r){
            header("Location: signup.php?error=pass");
            exit();
        }
        $parola_f = password_hash($parola_i, PASSWORD_DEFAULT);
        $tip = "fara_restrictie";
        $sql = "INSERT INTO utilizatori (nume, prenume, email, telefon, parola, data_nasterii, tip) VALUES ('$nume', '$prenume', '$email', '$telefon', '$parola_f', '$data_nasterii', '$tip')";
        mysqli_query($db, $sql);
        header("Location: login.php?success=cont");
        ecit();
    }

    if(isset($_POST['login'])){
        login();
    }
    function login(){
        global $db;
        $email = $_POST['email'];
        $parola_cont = $_POST['parola_cont'];

        $sql = "SELECT * FROM utilizatori where email = '$email'";
        $result = mysqli_query($db, $sql);
        if($result->num_rows > 0){
            $row_c = $result->fetch_assoc();
            $parola_c = $row_c['parola'];
            if(password_verify($parola_cont, $parola_c) != 1){
                header("Location: login.php?error=pass");
            }else{
                $user_login = $row_c;
                $_SESSION['simvideo_user'] = $user_login;
                header('location: index.php');
            }
        }else{
            header("Location: login.php?error=cont");
        }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['simvideo_user']);
        header("location: index.php");
    }

    if(isset($_POST['edit_parola'])){
        edit_parola();
    }

    function edit_parola(){
        global $db;
        $email = $_SESSION['simvideo_user']['email'];
        $parola_i = $_POST['parola_i'];
        $parola_r = $_POST['parola_r'];
        if($parola_i != $parola_r){
            header("Location: edit-profil.php?error=pass");
        }else{
            $parola_f = password_hash($parola_i, PASSWORD_DEFAULT);
            $sql1 = "UPDATE utilizatori SET parola = '$parola_f' WHERE email = '$email'";
            mysqli_query($db, $sql1);
            header("Location: edit-profil.php?success=pass");
            exit();
        }
    }


    if(isset($_POST['edit_profil'])){
		edit_profil();
	}
	function edit_profil(){
		global $db;
		$nume = $_POST['nume'];
		$prenume = $_POST['prenume'];
		$telefon = $_POST['telefon'];
		$email = $_POST['email'];
        $descriere = $_POST['descriere'];
		$data_nasterii = $_POST['data_nasterii'];
        $tip = $_POST['tip'];
		if(file_exists($_FILES['img']['tmp_name'])){
			$sql0 = "SELECT * FROM utilizatori WHERE email = '$email'";
			$result0 = mysqli_query($db, $sql0);
			$row0 = $result0->fetch_assoc();
			$folder_f = "utilizatori";
			$fisier_v = $folder_f . "/" . $row0['imagine'];
            unlink($fisier_v);
	        $imagine_ut = basename($_FILES['img']['name']);
	        $extensie = end(explode(".", $imagine_ut));
	        $img_name = uniqid();
	        $imagine_final = $img_name .".".$extensie;
	        $imagine_up = $folder_f . "/" . $imagine_final;
	        move_uploaded_file($_FILES['img']['tmp_name'], $imagine_up);
	        $sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', telefon = '$telefon', imagine = '$imagine_final', descriere = '$descriere', data_nasterii = '$data_nasterii', tip = '$tip' WHERE email = '$email'";
	        mysqli_query($db, $sql);
	    }else{
	    	$sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', telefon = '$telefon', descriere = '$descriere', data_nasterii = '$data_nasterii', tip = '$tip' WHERE email = '$email'";
	        mysqli_query($db, $sql);
	    }
		header("Location: edit-profil.php?success=profil");
		exit();
	}

    if(isset($_POST['signup_minor'])){
        signup_minor();
    }
    function signup_minor(){
        global $db;
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $email = $_POST['email'];
        $parola_i = $_POST['parola_i'];
        $parola_r = $_POST['parola_r'];
        $varsta = $_POST['varsta'];
        $id_parinte = $_SESSION['simvideo_user']['id'];
        $sqls = "SELECT * FROM utilizatori WHERE email = '$email'";
        $results = mysqli_query($db, $sqls);
        if($results->num_rows > 0){
            header("Location: conturi-minori.php?error=email");
            exit();
        }
        if($parola_i != $parola_r){
            header("Location: conturi-minori.php?error=pass");
            exit();
        }
        $parola_f = password_hash($parola_i, PASSWORD_DEFAULT);
        $cont_minor = 1;
        $sql = "INSERT INTO utilizatori (nume, prenume, email, parola, cont_minor, varsta, asociere) VALUES ('$nume', '$prenume', '$email', '$parola_f', '$cont_minor', '$varsta', '$id_parinte')";
        mysqli_query($db, $sql);
        header("Location: conturi-minori.php?success=cont");
        ecit();
    }

    if(isset($_POST['edit_parola_minor'])){
        edit_parola_minor();
    }

    function edit_parola_minor(){
        global $db;
        $email = $_SESSION['simvideo_user']['email'];
        $parola_i = $_POST['parola_i'];
        $parola_r = $_POST['parola_r'];
        if($parola_i != $parola_r){
            header("Location: edit-minor.php?error=pass");
        }else{
            $parola_f = password_hash($parola_i, PASSWORD_DEFAULT);
            $sql1 = "UPDATE utilizatori SET parola = '$parola_f' WHERE email = '$email'";
            mysqli_query($db, $sql1);
            header("Location: edit-minor.php?success=pass");
            exit();
        }
    }

    if(isset($_POST['edit_profil_minor'])){
        edit_profil_minor();
    }
    function edit_profil_minor(){
        global $db;
        $id_minor = $_POST['id_minor'];
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $email = $_POST['email'];
        $varsta = $_POST['varsta'];
        if(file_exists($_FILES['img']['tmp_name'])){
            $sql0 = "SELECT * FROM utilizatori WHERE email = '$email'";
            $result0 = mysqli_query($db, $sql0);
            $row0 = $result0->fetch_assoc();
            $folder_f = "utilizatori";
            $fisier_v = $folder_f . "/" . $row0['imagine'];
            unlink($fisier_v);
            $imagine_ut = basename($_FILES['img']['name']);
            $extensie = end(explode(".", $imagine_ut));
            $img_name = uniqid();
            $imagine_final = $img_name .".".$extensie;
            $imagine_up = $folder_f . "/" . $imagine_final;
            move_uploaded_file($_FILES['img']['tmp_name'], $imagine_up);
            $sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', varsta = '$varsta', imagine = '$imagine_final' WHERE email = '$email'";
            mysqli_query($db, $sql);
        }else{
            $sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', varsta = '$varsta' WHERE email = '$email'";
            mysqli_query($db, $sql);
        }
        header("Location: edit-minor.php?id_minor=$id_minor&success=profil");
        exit();
    }

    if(isset($_POST['adaugare_blacklist_profil'])){
        adaugare_blacklist_profil();
    }
    function adaugare_blacklist_profil(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $id_minor = $_POST['id_minor'];

        $sql = "INSERT INTO blacklist_profile (id_utilizator, id_creator) VALUES ('$id_minor', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: adaugare-profil-blacklist.php?id_minor=$id_minor&success=adaugare");
        exit();
    }

    if(isset($_POST['eliminare_blacklist_profil'])){
        eliminare_blacklist_profil();
    }
    function eliminare_blacklist_profil(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $id_minor = $_POST['id_minor'];

        $sql = "DELETE FROM blacklist_profile WHERE id_creator = '$id_creator' AND id_utilizator = '$id_minor'";
        mysqli_query($db, $sql);

        header("Location: blacklist-profile.php?id_minor=$id_minor&success=eliminare");
        exit();
    }

    if(isset($_POST['adaugare_blacklist_videoclip'])){
        adaugare_blacklist_videoclip();
    }
    function adaugare_blacklist_videoclip(){
        global $db;
        $id_videoclip = $_POST['id_videoclip'];
        $id_minor = $_POST['id_minor'];

        $sql = "INSERT INTO blacklist_videoclipuri (id_utilizator, id_videoclip) VALUES ('$id_minor', '$id_videoclip')";
        mysqli_query($db, $sql);

        header("Location: adaugare-videoclip-blacklist.php?id_minor=$id_minor&success=adaugare");
        exit();
    }

    if(isset($_POST['eliminare_blacklist_videoclip'])){
        eliminare_blacklist_videoclip();
    }
    function eliminare_blacklist_videoclip(){
        global $db;
        $id_videoclip = $_POST['id_videoclip'];
        $id_minor = $_POST['id_minor'];

        $sql = "DELETE FROM blacklist_videoclipuri WHERE id_videoclip = '$id_videoclip' AND id_utilizator = '$id_minor'";
        mysqli_query($db, $sql);

        header("Location: blacklist-videoclipuri.php?id_minor=$id_minor&success=eliminare");
        exit();
    }

    if(isset($_POST['stergere_minor'])){
        stergere_minor();
    }
    function stergere_minor(){
        global $db;
        $imagine = $_POST['imagine'];
        $id = $_POST['id'];

        $sql1 = "DELETE FROM utilizatori WHERE id = '$id'";
        mysqli_query($db, $sql1);

        $sql2 = "DELETE FROM abonamente WHERE id_abonat = '$id'";
        mysqli_query($db, $sql2);

        $sql3 = "DELETE FROM blacklist_profile WHERE id_utilizator = '$id'";
        mysqli_query($db, $sql3);

        $sql4 = "DELETE FROM blacklist_videoclipuri WHERE id_utilizator = '$id'";
        mysqli_query($db, $sql4);

        $sql5 = "DELETE FROM vizionate WHERE id_utilizator = '$id'";
        mysqli_query($db, $sql5);

        $img = "utilizatori/" . $imagine;
        unlink($img);

        header("Location: conturi-minori.php?success=stergere");
        exit();
    }

    if(isset($_POST['edit_video'])){
        edit_video();
    }
    function edit_video(){
        global $db;
        $uniqid = $_POST['uniqid'];
        $titlu = $_POST['titlu'];
        $descriere = $_POST['descriere'];
        $status = $_POST['status'];
        $tip = $_POST['tip'];
        if(file_exists($_FILES['img']['tmp_name'])){
            $sql0 = "SELECT * FROM videoclipuri WHERE uniqid = '$uniqid'";
            $result0 = mysqli_query($db, $sql0);
            $row0 = $result0->fetch_assoc();
            $folder_f = "videoclipuri/". $uniqid;
            $fisier_v = $folder_f . "/" . $row0['thumbnail'];
            unlink($fisier_v);
            $imagine_ut = basename($_FILES['img']['name']);
            $extensie = end(explode(".", $imagine_ut));
            $img_name = uniqid();
            $imagine_final = $img_name .".".$extensie;
            $imagine_up = $folder_f . "/" . $imagine_final;
            move_uploaded_file($_FILES['img']['tmp_name'], $imagine_up);
            $sql = "UPDATE videoclipuri SET titlu = '$titlu', descriere = '$descriere', thumbnail = '$imagine_final', status = '$status', tip = '$tip' WHERE uniqid = '$uniqid'";
            mysqli_query($db, $sql);
        }else{
            $sql = "UPDATE videoclipuri SET titlu = '$titlu', descriere = '$descriere', status = '$status', tip = '$tip' WHERE uniqid = '$uniqid'";
            mysqli_query($db, $sql);
        }
        header("Location: edit-video.php?uniqid=$uniqid&success=edit");
        exit();
    }

    if(isset($_POST['edit_categorie'])){
        edit_categorie();
    }
    function edit_categorie(){
        global $db;
        $uniqid = $_POST['uniqid'];
        $categorie = $_POST['categorie'];
        $subcategorie = $_POST['subcategorie'];
        $sql = "UPDATE videoclipuri SET categorie = '$categorie', subcategorie = '$subcategorie' WHERE uniqid = '$uniqid'";
        mysqli_query($db, $sql);
        header("Location: edit-video.php?uniqid=$uniqid&success=edit");
        exit();
    }

    if(isset($_POST['stergere_video'])){
        stergere_video();
    }
    function stergere_video(){
        global $db;
        $uniqid = $_POST['uniqid'];
        $id = $_POST['id'];

        $sql = "DELETE FROM aprecieri WHERE id_videoclip = '$id'";
        mysqli_query($db, $sql);

        $sql1 = "DELETE FROM comentarii WHERE id_videoclip = '$id'";
        mysqli_query($db, $sql1);

        $sql2 = "DELETE FROM videoclipuri WHERE id = '$id'";
        mysqli_query($db, $sql2);

        $folder = "videoclipuri/" . $uniqid;
        array_map('unlink', glob("$folder/*.*"));
        rmdir($folder);

        header("Location: videoclipurile-mele.php?success=stergere");
        exit();
    }

    if(isset($_POST['dezabonare_abonamente'])){
        dezabonare_abonamente();
    }
    function dezabonare_abonamente(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];

        $sql = "DELETE FROM abonamente WHERE id_creator = '$id_creator' AND id_abonat = '$myid'";
        mysqli_query($db, $sql);

        header("Location: abonamente.php?success=dezabonare");
        exit();
    }

    if(isset($_POST['abonare_profil'])){
        abonare_profil();
    }
    function abonare_profil(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];

        $sql = "INSERT INTO abonamente (id_abonat, id_creator) VALUES ('$myid', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: profil.php?id=$id_creator");
        exit();
    }

    if(isset($_POST['dezabonare_profil'])){
        dezabonare_profil();
    }
    function dezabonare_profil(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];

        $sql = "DELETE FROM abonamente WHERE id_creator = '$id_creator' AND id_abonat = '$myid'";
        mysqli_query($db, $sql);

        header("Location: profil.php?id=$id_creator");
        exit();
    }

    if(isset($_POST['abonare_video'])){
        abonare_video();
    }
    function abonare_video(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "INSERT INTO abonamente (id_abonat, id_creator) VALUES ('$myid', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&success=abonare");
        exit();
    }

    if(isset($_POST['dezabonare_video'])){
        dezabonare_video();
    }
    function dezabonare_video(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "DELETE FROM abonamente WHERE id_creator = '$id_creator' AND id_abonat = '$myid'";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&success=dezabonare");
        exit();
    }

    if(isset($_POST['apreciere_video'])){
        apreciere_video();
    }
    function apreciere_video(){
        global $db;
        $id_video = $_POST['id_video'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];
        $id_creator = $_POST['id_creator'];

        $sql = "INSERT INTO aprecieri (id_videoclip, id_utilizator, id_creator) VALUES ('$id_video', '$myid', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&success=apreciere");
        exit();
    }

    if(isset($_POST['dezapreciere_video'])){
        dezapreciere_video();
    }
    function dezapreciere_video(){
        global $db;
        $id_video = $_POST['id_video'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "DELETE FROM aprecieri WHERE id_videoclip = '$id_video' AND id_utilizator = '$myid'";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&success=dezapreciere");
        exit();
    }

    if(isset($_POST['adauga_comentariu'])){
        adauga_comentariu();
    }
    function adauga_comentariu(){
        global $db;
        $id_video = $_POST['id_video'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];
        $id_creator = $_POST['id_creator'];
        $comentariu = $_POST['comentariu'];
        date_default_timezone_set('Europe/Bucharest');
        $data = date("d-m-Y H:i", strtotime('now'));
        if(file_exists($_FILES['img']['tmp_name'])){
            $folder_f = "videoclipuri/" . $uniqid_video;
            $imagine_ut = basename($_FILES['img']['name']);
            $extensie = end(explode(".", $imagine_ut));
            $img_name = uniqid();
            $imagine_final = $img_name .".".$extensie;
            $imagine_up = $folder_f . "/" . $imagine_final;
            move_uploaded_file($_FILES['img']['tmp_name'], $imagine_up);
            $sql = "INSERT INTO comentarii (id_videoclip, id_creator, id_comentator, comentariu, imagine, data) VALUES ('$id_video', '$id_creator', '$myid', '$comentariu', '$imagine_final', '$data')";
        mysqli_query($db, $sql);
        }else{
            $sql = "INSERT INTO comentarii (id_videoclip, id_creator, id_comentator, comentariu, data) VALUES ('$id_video', '$id_creator', '$myid', '$comentariu', '$data')";
        mysqli_query($db, $sql);
        }

        header("Location: video.php?uniqid=$uniqid_video&success=comentariu");
        exit();
    }

    if(isset($_POST['stergere_comentariu'])){
        stergere_comentariu();
    }
    function stergere_comentariu(){
        global $db;
        $id = $_POST['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql1 = "SELECT * FROM comentarii WHERE id = '$id'";
        $result1 = mysqli_query($db, $sql1);
        $row1 = $result1->fetch_assoc();

        if(!empty($row1['imagine'])){
            $fisier = "videoclipuri/" . $uniqid_video . "/" . $row1['imagine'];
            unlink($fisier);
        }

        $sql = "DELETE FROM comentarii WHERE id = '$id'";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&success=stergere_comentariu");
        exit();
    }

    if(isset($_POST['filtrare_index'])){
        filtrare_index();
    }
    function filtrare_index(){
        global $db;
        $pagina = $_POST['pagina'];
        $categorie = $_POST['categorie'];
        $subcategorie = $_POST['subcategorie'];

        if($subcategorie == "toate"){
            header("Location: $pagina?categorie=$categorie");
            exit();
        }else{
            header("Location: $pagina?categorie=$categorie&subcategorie=$subcategorie");
            exit();
        }
    }

    if(isset($_POST['creare_chat'])){
        creare_chat();
    }
    function creare_chat(){
        global $db;
        $nume = $_POST['nume'];
        $id_utilizator = $_SESSION['simvideo_user']['id'];
        $uniqid = uniqid();
        $filePath = "chaturi/" . $uniqid;
        mkdir($filePath, 0777);
        $sql = "INSERT INTO chaturi (uniqid, id_utilizator, nume) VALUES ('$uniqid', '$id_utilizator', '$nume')";
        mysqli_query($db, $sql);
        header("Location: edit-profil.php?success=chat");
        exit();
    }

    if(isset($_POST['editare_chat'])){
        editare_chat();
    }
    function editare_chat(){
        global $db;
        $id = $_POST['id'];
        $nume = $_POST['nume'];

        $sql = "UPDATE chaturi SET nume = '$nume' WHERE id = '$id'";
        mysqli_query($db, $sql);

        header("Location: edit-profil.php?success=editare_chat");
        exit();
    }

    if(isset($_POST['stergere_chat'])){
        stergere_chat();
    }
    function stergere_chat(){
        global $db;
        $uniqid = $_POST['uniqid'];
        $id = $_POST['id'];

        $sql = "DELETE FROM chaturi WHERE id = '$id'";
        mysqli_query($db, $sql);

        $sql1 = "DELETE FROM utilizatori_chat WHERE id_chat = '$id'";
        mysqli_query($db, $sql1);

        $sql2 = "DELETE FROM mesaje_chat WHERE id_chat = '$id'";
        mysqli_query($db, $sql2);

        $folder = "chaturi/" . $uniqid;
        array_map('unlink', glob("$folder/*.*"));
        rmdir($folder);

        header("Location: edit-profil.php?success=stergere_chat");
        exit();
    }

    if(isset($_POST['join_chat'])){
        join_chat();
    }
    function join_chat(){
        global $db;
        $id = $_POST['id'];
        $uniqid = $_POST['uniqid'];
        $id_utilizator = $_SESSION['simvideo_user']['id'];

        $sql = "SELECT * FROM utilizatori_chat WHERE id_chat = '$id' AND id_utilizator = '$id_utilizator'";
        $result = mysqli_query($db, $sql);

        if($result->num_rows > 0){
            header("Location: chat.php?uniqid=$uniqid");
            exit();
        }else{
           $sql1 = "INSERT INTO utilizatori_chat (id_chat, id_utilizator) VALUES ('$id', '$id_utilizator')";
           mysqli_query($db, $sql1); 
        }

        header("Location: chat.php?uniqid=$uniqid");
        exit();
    }

    if(isset($_POST['adauga_mesaj'])){
        adauga_mesaj();
    }
    function adauga_mesaj(){
        global $db;
        $id_chat = $_POST['id_chat'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_chat = $_POST['uniqid_chat'];
        $mesaj = $_POST['mesaj'];
        date_default_timezone_set('Europe/Bucharest');
        $data = date("d-m-Y H:i", strtotime('now'));
        if(file_exists($_FILES['img']['tmp_name'])){
            $folder_f = "chaturi/" . $uniqid_chat;
            $imagine_ut = basename($_FILES['img']['name']);
            $extensie = end(explode(".", $imagine_ut));
            $img_name = uniqid();
            $imagine_final = $img_name .".".$extensie;
            $imagine_up = $folder_f . "/" . $imagine_final;
            move_uploaded_file($_FILES['img']['tmp_name'], $imagine_up);
            $sql = "INSERT INTO mesaje_chat (id_chat, id_utilizator, mesaj, imagine, data) VALUES ('$id_chat', '$myid', '$mesaj', '$imagine_final', '$data')";
        mysqli_query($db, $sql);
        }else{
            $sql = "INSERT INTO mesaje_chat (id_chat, id_utilizator, mesaj, data) VALUES ('$id_chat', '$myid', '$mesaj', '$data')";
        mysqli_query($db, $sql);
        }

        header("Location: chat.php?uniqid=$uniqid_chat&success=mesaj");
        exit();
    }

    if(isset($_POST['stergere_mesaj'])){
        stergere_mesaj();
    }
    function stergere_mesaj(){
        global $db;
        $id = $_POST['id'];
        $uniqid_chat = $_POST['uniqid_chat'];

        $sql1 = "SELECT * FROM mesaje_chat WHERE id = '$id'";
        $result1 = mysqli_query($db, $sql1);
        $row1 = $result1->fetch_assoc();

        if(!empty($row1['imagine'])){
            $fisier = "chaturi/" . $uniqid_chat . "/" . $row1['imagine'];
            unlink($fisier);
        }

        $sql = "DELETE FROM mesaje_chat WHERE id = '$id'";
        mysqli_query($db, $sql);

        header("Location: chat.php?uniqid=$uniqid_chat&success=stergere");
        exit();
    }