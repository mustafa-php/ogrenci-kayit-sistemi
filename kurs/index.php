<?php
include "../include/bas.php";
if (isset($_SESSION["admin"])) {
    $kurs_kntr = $veritabani->prepare('SELECT * FROM kurslar order by id desc');
    $kurs_kntr->execute();
    $kurs_cek = $kurs_kntr->fetchAll(PDO::FETCH_OBJ);
?>
    <div class="kurs_ekle">
        <form action="" method="post" class="text-end">
            <input type="text" name="isim" placeholder="Kurs İsmi" required />
            <button type="submit" name="kurs_ekle" class="btn btn-primary">Kurs Ekle</button>
        </form>
    </div>

    <div class="kurs_listesi">
        <div class="lis_bs">
            <div>Kurs No</div>
            <div>Kurs İsmi</div>
            <div>Oluşturulma Tarihi</div>
            <div>İşlemler</div>
        </div>
        <?php

        foreach ($kurs_cek as $kurs) {
        ?>
            <div class="lis_oge">
                <div><?php echo $kurs->id ?></div>
                <div><?php echo $kurs->isim ?></div>
                <div><?php echo $kurs->tarih ?></div>
                <div class="islem_btn">
                    <button class="btn btn-danger">
                        <a href="https://mustafa/ders/?sil&kurs=<?php echo $kurs->id; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                        </a>
                    </button>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
</body>

</html>

<?php ob_flush(); ?>
