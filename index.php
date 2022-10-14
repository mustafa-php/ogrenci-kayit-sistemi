<?php

include "include/bas.php";
if (isset($_SESSION["admin"])) {
  header("location:https://mustafa/kurs");
}

ob_flush();
