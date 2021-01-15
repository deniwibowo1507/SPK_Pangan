<?php
$dbhost = 'localhost'; 
$dbuser = 'my_root';
$dbpass = 'my_pass';
$dbname = 'spk_pangan';

$connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if ($connect->connect_error) {
   // jika terjadi error, matikan proses dengan die() atau exit();
   die('Maaf koneksi gagal: '. $connect->connect_error);
}