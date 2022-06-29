<?php

include_once('libraryphpexcel/excel_reader2.php');
include_once('admin/kjn.php');

$upload_dir = 'uploaded';

$target = basename($_FILES['fileExcel']['name']);

chmod('uploaded', 0777);
$path = move_uploaded_file($_FILES['fileExcel']['tmp_name'], $upload_dir . '/' . $target);

//permission agar file excel bisa terbaca
chmod('uploaded/' . $target, 0777);

//mengambil isi dari file excel
$data = new Spreadsheet_Excel_Reader($upload_dir . '/' . $target, false);
//hitung jumlah baris yang ada dalam file kita
$jumlah_baris = $data->rowcount($sheet_index = 0);
$success = 8;

// var_dump($jumlah_baris);
// die;

$dInsert = array();
for ($i = 8; $i <= $jumlah_baris; $i++) {

    // echo $i . '<br>';

    $kode_klasifikasi             = $data->val($i, 2);
    $nomor_Penetapan              = $data->val($i, 3);
    $kode_transaksi_voucher       = $data->val($i, 4);
    $no_kpj_dan_nama_tenaga_kerja = $data->val($i, 5);
    $nama_perusahaan              = $data->val($i, 6);
    $pph_21                       = $data->val($i, 7);
    $jumlah_bayar                 = $data->val($i, 8);
    $no_rekening_penerima         = $data->val($i, 9);
    $bank                         = $data->val($i, 10);
    $atas_nama                    = $data->val($i, 11);
    $jumlah_berkas                = $data->val($i, 12);
    $tingkat_perkembangan         = $data->val($i, 13);
    $keterangan                   = $data->val($i, 14);
    $nomor_boks                   = $data->val($i, 15);
    $nomor_rak                    = $_POST['NomorRak'];
    $kategori                     = $_POST['kategori'];

    if ($kode_klasifikasi != "" && $no_kpj_dan_nama_tenaga_kerja != ""); {
        mysqli_query($conn, "INSERT INTO jaminan VALUES ('','$kode_klasifikasi','$nomor_Penetapan','$kode_transaksi_voucher',
        '$no_kpj_dan_nama_tenaga_kerja','$nama_perusahaan','$pph_21',
        '$jumlah_bayar','$no_rekening_penerima','$bank','$atas_nama',
        '$jumlah_berkas','$tingkat_perkembangan','$keterangan','$nomor_boks', '$nomor_rak', '$kategori' )");

        $success++;
    }
    // unlink($_FILES['fileExcel']['name']);
    // if ($success > 0) {
    //     header("location:admin/add_arsip.php?upload=success");
    // } else {
    //     header("location:admin/add_arsip.php?upload=failed");
    // }
}

if ($success >= $jumlah_baris) {
    header("location:admin/add_arsip.php?upload=success");
} else {
    header("location:admin/add_arsip.php?upload=failed");
}

// header("location:index.php?upload=success");
