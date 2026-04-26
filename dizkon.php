<?php
$nama = "Pensil";

$jumlah = 5;

$harga = 20000;

$potongan = 20/100;

$admin = 500;

$ttl= $jumlah * $harga;

$total = $ttl - ($ttl* $potongan) + $admin;

echo "Nama Barang : $nama <br>";

echo "Jumlah Beli : $jumlah <br>";

echo "Harga Barang : $harga <br>";

echo "Total Bayar : $total <br>";

?>