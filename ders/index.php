<?php
include "../include/bas.php";
if (isset($_SESSION["admin"])) {
    $ders_kntr = $veritabani->prepare('SELECT * FROM dersler order by id desc');
    $ders_kntr->execute();
    $ders_cek = $ders_kntr->fetchAll(PDO::FETCH_OBJ);
?>

    <div class="ders_form">
        <form action="" method="post">
            <input type="text" name="isim" placeholder="Ders İsmi" required />
            <input type="text" name="kurs" placeholder="Kurs İsmi" required />
            <input type="text" name="ogretmen" placeholder="Öğretmen İsmi" required />
            <input type="text" name="sinif" placeholder="Sınıf" required />
            <button type="submit" name="ders_ekle" class="btn btn-primary">Ders Ekle</button>
        </form>
    </div>

    <div class="ders_listesi">
        <div class="lis_bs">
            <div>Ders İsmi</div>
            <div>Kurs İsmi</div>
            <div>Öğretmen İsmi</div>
            <div>Sınıf</div>
            <div>İşlemler</div>
        </div>
        <?php

        foreach ($ders_cek as $ders) {
        ?>
            <div class="lis_oge">
                <div><?php echo $ders->isim; ?></div>
                <div><?php echo $ders->kurs; ?></div>
                <div><?php echo $ders->ogretmen; ?></div>
                <div><?php echo $ders->sinif; ?></div>
                <div class="islem_btn">
                    <button class="btn btn-primary">
                        <a href="https://mustafa/ders/?duzenle&ders=<?php echo $ders->id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                            </svg>
                        </a>
                    </button>
                    <button class="btn btn-danger">
                        <a href="https://mustafa/ders/?sil&ders=<?php echo $ders->id; ?>">
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
