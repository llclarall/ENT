
<?php
session_start();
$_SESSION=array();
session_destroy();
header("Location: affiche_utilisateurs.php");
?>