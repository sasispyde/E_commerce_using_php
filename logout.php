<?php

	session_start();

	session_unset();

	session_destroy();

	// header("Location:index.php");

	if ($_GET['err'])
    {
	header('Location: index.php?er="e"');
    }
    else
    {
	header('Location: index.php?msg="m');
    }
?>