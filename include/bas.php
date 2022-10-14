<?php
ob_start();

session_start();

date_default_timezone_set("Europe/Istanbul");

$veritabani = new PDO("mysql:host=localhost;dbname=ogrnc_kyt_sistm", "root", "");

if (isset($_POST["giris"])) { /* Giriş isteği alınıyor */
    $admin = "mustafa"; /* admin */
    $sifre = "12345"; /* şifre */
    if ($_POST["admin"] == $admin && $_POST["sifre"] == $sifre) { /* bilgilerin doğruluk kontrolü */
        $_SESSION["admin"] = true;  /* oturum açılıyor */
        header("location:https://mustafa/");
    } else {
        $hata = true;
    }
}

if (isset($_GET["cikis"])) {
    session_destroy();
    header("location:https://mustafa/");
}

/* Veritabanına verileri post yapılmasına göre düzenli kayıt ediyoruz */

if (isset($_POST["kurs_ekle"])) {

    $kurs_isim = $_POST["isim"];
    $kurs_tarih =  date("d-m-Y") . " " . date("H:i");
    $kurs_ekle = $veritabani->prepare("INSERT INTO kurslar SET isim=:isim, tarih=:tarih ");
    $kurs_ekle->execute(
        array(
            "isim" => $kurs_isim,
            "tarih" => $kurs_tarih
        )
    );
    header("location:https://mustafa/kurs");
}

if (isset($_POST["ogrenci_ekle"])) {
    $ogrenci_no = rand(10, 1000);
    $ogrenci_isim = $_POST["isim"];
    $ogrenci_tel = $_POST["tel"];
    $ogrenci_sube =  mb_strtoupper($_POST["sube"], "UTF-8");
    $ogrenci_sinif = $_POST["sinif"];
    $ogrenci_dt = $_POST["dt"];
    $ogrenci_adres = $_POST["adres"];
    $ogrenci_cns = $_POST["cinsiyet"];
    $ogrenci_ekle = $veritabani->prepare("INSERT INTO ogrenciler SET _no=:_no, isim=:isim, tel=:tel, sube=:sube, sinif=:sinif, dt=:dt, adres=:adres, cinsiyet=:cinsiyet ");
    $ogrenci_ekle->execute(
        array(
            "_no" => $ogrenci_no,
            "isim" => $ogrenci_isim,
            "tel" => $ogrenci_tel,
            "sube" => $ogrenci_sube,
            "sinif" => $ogrenci_sinif,
            "dt" => $ogrenci_dt,
            "adres" => $ogrenci_adres,
            "cinsiyet" => $ogrenci_cns
        )
    );
    header("location:https://mustafa/ogrenci");
}

if (isset($_POST["ders_ekle"])) {
    $ders_isim = $_POST["isim"];
    $ders_kurs = $_POST["kurs"];
    $ders_ogretmen = $_POST["ogretmen"];
    $ders_sinif = $_POST["sinif"];
    $ders_ekle = $veritabani->prepare("INSERT INTO dersler SET isim=:isim, kurs=:kurs, ogretmen=:ogretmen, sinif=:sinif");
    $ders_ekle->execute(array(
        "isim" => $ders_isim,
        "kurs" => $ders_kurs,
        "ogretmen" => $ders_ogretmen,
        "sinif" => $ders_sinif
    ));
    header("location:https://mustafa/ders");
}


if (isset($_GET["sil"])) { /* GET Methodu ile yapılacak işlemi belirliyoruz */

    if (isset($_GET["kurs"])) { /* İkinci GET Methodu ile alan tespiti */
        $kurs_id = $_GET["kurs"]; /* İkinci GET Merhodu içinde bulunan id değerini seçiyoruz */
        $kurs_sil = $veritabani->prepare("DELETE FROM kurslar WHERE id=:id");
        $kurs_sil->execute(
            array(
                'id' => $kurs_id
            )
        );

        header("location:https://mustafa/kurs");
    }

    if (isset($_GET["ogrenci"])) {
        $ogrenci_id = $_GET["ogrenci"];
        $ogrenci_sil = $veritabani->prepare("DELETE FROM ogrenciler WHERE id=:id");
        $ogrenci_sil->execute(
            array(
                'id' => $ogrenci_id
            )
        );
        header("location:https://mustafa/ogrenci");
    }

    if (isset($_GET["ders"])) {
        $ders_id = $_GET["ders"];
        $ders_sil = $veritabani->prepare("DELETE FROM dersler WHERE id=:id");
        $ders_sil->execute(
            array(
                'id' => $ders_id
            )
        );
        header("location:https://mustafa/ders");
    }
}

if (isset($_GET["duzenle"])) {

    if (isset($_GET["ogrenci"])) {
        $ogrenci_id = $_GET["ogrenci"];

        if (isset($_POST["ogrenci_duzenle"])) {
            $dz_ogrenci_isim = $_POST["isim"];
            $dz_ogrenci_tel = $_POST["tel"];
            $dz_ogrenci_sube = mb_strtoupper($_POST["sube"], "UTF-8");
            $dz_ogrenci_sinif = $_POST["sinif"];
            $dz_ogrenci_dt = $_POST["dt"];
            $dz_ogrenci_adres = $_POST["adres"];
            $dz_ogrenci_cns = $_POST["cinsiyet"];
            $ogrenci_duzenle = $veritabani->prepare("UPDATE ogrenciler SET isim=:isim, tel=:tel, sube=:sube, sinif=:sinif, dt=:dt, adres=:adres, cinsiyet=:cns where  id=:id ");
            $ogrenci_duzenle->execute(array(
                "id" => $ogrenci_id,
                "isim" => $dz_ogrenci_isim,
                "tel" => $dz_ogrenci_tel,
                "sube" => $dz_ogrenci_sube,
                "sinif" => $dz_ogrenci_sinif,
                "dt" => $dz_ogrenci_dt,
                "adres" => $dz_ogrenci_adres,
                "cns" => $dz_ogrenci_cns
            ));
            header("location:https://mustafa/ogrenci/");
        }


        $ogrenci_kntr = $veritabani->prepare('SELECT *FROM ogrenciler WHERE id=:id');
        $ogrenci_kntr->execute(array(
            "id" => $ogrenci_id,
        ));
        $ogrenci_cek = $ogrenci_kntr->fetchAll(PDO::FETCH_OBJ);

        foreach ($ogrenci_cek as $ogrenci) {
            $ogrenci_no = $ogrenci->_no;
            $ogrenci_isim = $ogrenci->isim;
            $ogrenci_tel = $ogrenci->tel;
            $ogrenci_sube = $ogrenci->sube;
            $ogrenci_sinif = $ogrenci->sinif;
            $ogrenci_dt = $ogrenci->dt;
            $ogrenci_adres = $ogrenci->adres;
            $ogrenci_cns = $ogrenci->cinsiyet;
        };
?>
        <div class="pencere">
            <div class="ogrenci_form">
                <form action="" method="post">
                    <input type="text" name="isim" placeholder="Öğrenci İsmi" required value="<?php echo $ogrenci_isim; ?>" />
                    <input type="text" name="tel" placeholder="Telefon" required value="<?php echo $ogrenci_tel; ?>" />
                    <input type="text" name="sinif" placeholder="Sınıf" required value="<?php echo $ogrenci_sinif; ?>">
                    <input type="text" name="sube" placeholder="Şube" required value="<?php echo $ogrenci_sube; ?>">
                    <input type="text" name="dt" placeholder="Doğum Tarihi" required name="dt" value="<?php echo $ogrenci_dt; ?>">
                    <div class="d-flex align-items-center justify-content-center">
                        <label for="erkek" class="p-2">
                            <input type="radio" name="cinsiyet" id="erkek" value="Erkek" required <?php if ($ogrenci_cns == "Erkek") {
                                                                                                        echo "checked";
                                                                                                    } ?> /> Erkek
                        </label>
                        <label for="kız" class="p-2">
                            <input type="radio" name="cinsiyet" id="kız" value="Kız" required <?php if ($ogrenci_cns == "Kız") {
                                                                                                    echo "checked";
                                                                                                } ?> /> Kız
                        </label>
                    </div>
                    <textarea name="adres" cols="30" rows="10" required placeholder="adres"><?php echo $ogrenci_adres ?></textarea>
                    <button type="submit" name="ogrenci_duzenle" class="btn btn-primary">Öğrenci Düzenle</button>
                </form>
            </div>
        </div>
    <?php

    }
    if (isset($_GET["ders"])) {
        $ders_id = $_GET["ders"];
        if (isset($_POST["ders_duzenle"])) {
            $dz_ders_isim = $_POST["isim"];
            $dz_ders_kurs = $_POST["kurs"];
            $dz_ders_ogretmen = $_POST["ogretmen"];
            $dz_ders_sinif = $_POST["sinif"];

            $ders_duzenle = $veritabani->prepare("UPDATE dersler SET isim=:isim, kurs=:kurs, ogretmen=:ogretmen, sinif=:sinif where  id=:id ");
            $ders_duzenle->execute(array(
                "id" => $ders_id,
                "isim" => $dz_ders_isim,
                "kurs" => $dz_ders_kurs,
                "ogretmen" => $dz_ders_ogretmen,
                "sinif" => $dz_ders_sinif
            ));
            header("location:https://mustafa/ders/");
        }

        $ders_kntr = $veritabani->prepare('SELECT *FROM dersler WHERE id=:id');
        $ders_kntr->execute(array(
            "id" => $ders_id,
        ));
        $ders_cek = $ders_kntr->fetchAll(PDO::FETCH_OBJ);

        foreach ($ders_cek as $ders) {
            $ders_isim = $ders->isim;
            $ders_kurs = $ders->kurs;
            $ders_ogretmen = $ders->ogretmen;
            $ders_sinif = $ders->sinif;
        };
    ?>
        <div class="pencere">
            <div class="ders_form">
                <form action="" method="post" class="">
                    <input type="text" name="isim" placeholder="Ders İsmi" required value="<?php echo $ders_isim; ?>" />
                    <input type="text" name="kurs" placeholder="Kurs İsmi" required value="<?php echo $ders_kurs; ?>" />
                    <input type="text" name="ogretmen" placeholder="Öğretmen İsmi" required value="<?php echo $ders_ogretmen; ?>" />
                    <input type="text" name="sinif" placeholder="Sınıf" required value="<?php echo $ders_sinif; ?>" />
                    <button type="submit" name="ders_duzenle" class="btn btn-primary">Ders Düzenle</button>
                </form>
            </div>
        </div>
<?php
    }
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Öğrenci Kayıt Sistemi</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://mustafa/index.css">
</head>

<body>

    <?php

    if (empty($_SESSION["admin"])) {
    ?>
        <div class="pencere">
            <form action="" method="post" class="giris_form">
                <h3 class="text-center">Giriş</h3>
                <?php if (isset($hata)) {
                    echo "Kullanıcı adı veya şifre hatalı";
                } ?>
                <input type="text" placeholder="Kullanıcı Adı" required name="admin">
                <input type="password" placeholder="Şifre" required name="sifre">
                <button class="btn btn-primary" type="submit" name="giris">Giriş</button>
            </form>
        </div>
    <?php
    } else {
    ?>

        <button class="cikis">
            <a href="?cikis">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                </svg>
            </a></button>
        <div class="bas">
            <h3>Öğrenci Kayıt Sistemi - Mustafa Şimşek/Sosyal Yazar</h3>
        </div>
        <div class="ana_govde">
            <div class="menu">
                <button class="btn btn-primary"><a href="https://mustafa/kurs/">Kurs İşlemleri</a></button>


                <button class="btn btn-primary"><a href="https://mustafa/ogrenci/">Öğrenci İşlemleri</a></button>


                <button class="btn btn-primary"><a href="https://mustafa/ders/">Ders İşlemleri</a></button>

            </div>
            <div class="govde">
            <?php } ?>
