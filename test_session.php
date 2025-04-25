<?php

session_start();
$_SESSION['test'] = 'Sesión escrita correctamente';

echo 'Sesión creada. <a href="test_session_check.php">Verificar</a>';
