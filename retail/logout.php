<?php
session_start();
session_unset();
session_destroy();
header('Location: http://smartretailpos.pe.hu/retail/');
exit();
?>
