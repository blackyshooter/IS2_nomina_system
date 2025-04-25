<?php

session_start();

if (isset($_SESSION['test'])) {
    echo 'Sesión activa: ' . $_SESSION['test'];
} else {
    echo 'Sesión perdida';
}
