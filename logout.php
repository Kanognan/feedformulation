<?php

session_start();
session_destroy(); // function that Destroys Session ลบsession
header("Location: index.php");

?>