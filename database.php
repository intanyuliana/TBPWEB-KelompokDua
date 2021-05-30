<?php

$db = new mysqli('localhost', 'root', '', 'tbpweb');

if ($db->connect_errno > 0) {
    die('Gagal koneksi ke database');
}
