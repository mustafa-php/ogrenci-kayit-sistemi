<?php
include "../include/bas.php";
if (isset($_SESSION["admin"])) {
    $ogrenci_kntr = $veritabani->prepare('SELECT *FROM ogrenciler order by id desc');
    $ogrenci_kntr->execute();
    $ogrenci_cek = $ogrenci_kntr->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="ogrenci_form">
        <form action="" method="post">
            <input type="text" name="isim" placeholder="Öğrenci İsmi" required />
            <input type="text" name="tel" placeholder="Telefon" required />
            <input type="text" name="sinif" placeholder="Sınıf" required>
            <input type="text" name="sube" placeholder="Şube" required>
            <input type="text" name="dt" placeholder="Doğum Tarihi" required>
            <div class="d-flex align-items-center justify-content-center" >
                <label for="erkek" class="p-2">
                    <input type="radio" name="cinsiyet" value="Erkek" required id="erkek" /> Erkek
                </label>
                <label for="kız" class="p-2">
                    <input type="radio" name="cinsiyet" value="Kız" required id="kız" /> Kız
                </label>
            </div>
            <textarea name="adres" cols="30" rows="10" placeholder="Adres" required></textarea>

            <button type="submit" name="ogrenci_ekle" class="btn btn-primary">Öğrenci Ekle</button>
        </form>
    </div>

    <div class="ogrenci_listesi">
        <div class="lis_bs">
            <div>Öğrenci No</div>
            <div>Öğrenci İsmi</div>
            <div>Sınıf/Şube</div>
            <div>Telefon</div>
            <div>Doğum Tarihi</div>
            <div>Adres</div>
            <div>Cinsiyet</div>
            <div>İşlemler</div>
        </div>
        <?php
        foreach ($ogrenci_cek as $ogrenci) {
        ?>
            <div class="lis_oge">
                <div><?php echo $ogrenci->_no; ?></div>
                <div><?php echo $ogrenci->isim; ?></div>
                <div><?php echo $ogrenci->sinif . "/" . $ogrenci->sube; ?></div>
                <div><?php echo $ogrenci->tel; ?></div>
                <div><?php echo $ogrenci->dt; ?></div>
                <div><?php echo $ogrenci->adres; ?></div>
                <div><?php echo $ogrenci->cinsiyet; ?></div>
                <div class="islem_btn">
                    <button class="btn btn-primary">
                    <a href="https://mustafa/ogrenci/?duzenle&ogrenci=<?php echo $ogrenci->id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                            </svg>
                        </a>
                    </button>
                    <button class="btn btn-danger">
                    <a href="https://mustafa/ogrenci/?sil&ogrenci=<?php echo $ogrenci->id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                        </a>
                    </button>
                </div>
            </div>
        <?php }; ?>
    </div>
<?php } ?>
</body>

</html>

<?php ob_flush(); ?>
