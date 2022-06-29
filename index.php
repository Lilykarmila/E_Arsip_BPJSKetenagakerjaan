<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>E-Arsip BPJS KETENAGAKERJAAN KENDARI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Dion Montolalu" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="admin/icoon.png">
  <!-- font-awesome icons -->
  <link href="admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <script src="admin/assets/plugins/jquery-1.10.2.js"></script>
  <script src="admin/assets/plugins/bootstrap/bootstrap.js"></script>
  <!-- Sweet Alert -->
  <link rel="stylesheet" type="text/css" href="admin/sweetalert/dist/sweetalert.css">
  <script type="text/javascript" src="admin/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    $(function() {
      $(document).on('click', '.edit-record', function(e) {
        e.preventDefault();
        $("#myModal").modal('show');
        $.post('hasil.php', {
            id: $(this).attr('data-id')
          },
          function(html) {
            $(".modal-body").html(html);
          }
        );
      });
    });
  </script>
</head>

<body>

  <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #00b33c; ">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#" style="color:white; float: left; border-right:2px solid #bbb;"> <b>BPJS KETENAGAKERJAAN</b></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li style="float: left; border-right:2px solid #bbb;"><a href="index.php" style="color:white;"><strong><i class="fa fa-users nav_icon"> SEARCH </i> </strong><span class="sr-only">(current)</span></a></li>
          <li style="float: left; border-right:2px solid #bbb;"><a href="#" data-toggle="modal" data-target="#myModal2" style="color:white;"><strong><i class="fa fa-info-circle nav_icon"> INFO </i></strong></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="login.php" target="_blank"> <strong>LOGIN</strong></a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav><br><br><br><br>
  <?php
  //        includekan fungsi paginasi
  include 'admin/kjn.php';
  include 'pagination1.php';

  if (isset($_REQUEST['keyword']) && $_REQUEST['keyword'] <> "") {
    //        jika ada kata kunci pencarian (artinya form pencarian disubmit dan tidak kosong)
    //        pakai ini
    $keyword = $_REQUEST['keyword'];
    $reload = "index.php?pagination=true&keyword=$keyword";
    $sql =  "SELECT * FROM jaminan
                      WHERE kode_transaksi_voucher LIKE '%$keyword%'
                      OR no_kpj_dan_nama_tenaga_kerja LIKE '%$keyword%'
                      ORDER BY no_kpj_dan_nama_tenaga_kerja";
    $result = mysqli_query($conn, $sql);
  } else {
    //            jika tidak ada pencarian pakai ini
    $reload = "index.php?pagination=true";
    $sql =  "SELECT * FROM jaminan";
    $result = mysqli_query($conn, $sql);
  }

  //pagination config start
  $rpp = 10; // jumlah record per halaman
  $page = intval($_GET["page"]);
  if ($page <= 0) $page = 1;
  $tcount = mysqli_num_rows($result);
  if ($tcount == "") {
    echo '<script>
          swal({
              title: "Tidak ada Data",
              text: "Data tidak terdaftar !",
              type: "warning",
            },
            function(){
              window.location.href = "index.php";
            });
          </script>';
  } else {
    $tpages = ($tcount) ? ceil($tcount / $rpp) : 1; // total pages, last page number
    $count = 0;
    $i = ($page - 1) * $rpp;
    $no_urut = ($page - 1) * $rpp;
    //pagination config end
  ?>
    <div class="container">
      <div class="row">
        <div class="col-md-17">
          <center>
            <img src="logoo.png" width="40%"></img><br><br><br><br>
          </center>
          <form method="post" action="index.php">
            <div class="input-group input-group-lg">
              <input type="text" name="keyword" class="form-control" placeholder="Cari Berkas Arsip atau nama" value="<?php echo $_REQUEST['keyword']; ?>" autocomplete="off">
              <span class="input-group-btn">
                <button class="btn btn-success" type="submit">Cari Data</button>
              </span>
            </div>
          </form>
          <br><br>
          <div style="width:100%; overflow-x:scroll;">
            <table class="table table-bordered" style="border-color:#1976D2;">
              <thead>
                <tr style="background-color:#00b33c; color:white;">
                  <th>
                    <center>No.</center>
                  </th>
                  <th>
                    <center>Kode Klasifikasi</center>
                  </th>
                  <th>
                    <center>Nomor penetapan<center>
                  </th>
                  <th>
                    <center>Kode Transaksi Voucher</center>
                  </th>
                  <th>
                    <center>No KPj dan Nama TKJ</center>
                  </th>
                  <th>
                    <center>Nama Perusahaan</center>
                  </th>
                  <th>
                    <center>Jumlah Bayar</center>
                  </th>
                  <th>
                    <center>Nama Penerima</center>
                  </th>
                  <th>
                    <center>Jumlah Berkas</center>
                  </th>
                  <th>
                    <center>Tingkat Perkembangan</center>
                  </th>
                  <th>
                    <center>Keterangan</center>
                  </th>
                  <th>
                    <center>Nomor Boks</center>
                  </th>
                  <th>
                    <center>Nomor Rak</center>
                  </th>
                  <th>
                    <center>Kategori Berkas</center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                while (($count < $rpp) && ($i < $tcount)) {
                  mysqli_data_seek($result, $i);
                  $data = mysqli_fetch_array($result);
                  $id_terdakwa = $data['id_terdakwa'];
                ?>
                  <tr>
                    <td width="80px">
                      <center><b><?php echo ++$no_urut; ?></b></center>
                    </td>
                    <td>
                      <center><?php echo $data['kode_klasifikasi']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['nomor_Penetapan']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['kode_transaksi_voucher']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['no_kpj_dan_nama_tenaga_kerja']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['nama_perusahaan']; ?></center>
                    </td>

                    <td>
                      <center><?php echo $data['jumlah_bayar']; ?></center>
                    </td>


                    <td>
                      <center><?php echo $data['atas_nama']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['jumlah_berkas']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['tingkat_perkembangan']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['keterangan']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['nomor_boks']; ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['nomor_rak'] ?></center>
                    </td>
                    <td>
                      <center><?php echo $data['kategori'] ?></center>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal2" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color:#00b33c;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <center>
                              <h4 class="modal-title"><b style="color:white;"><i class="fa fa-info-circle nav_icon,;;l;ll;"> </i> INFO</b></h4>
                            </center>
                          </div>
                          <div class="modal-body2">
                            <center>
                              Silahkan inputkan nama tenaga kerja
                              </p>
                            </center>
                          </div>
                          <div class="modal-footer" style="background-color:#00b33c;">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">EXIT</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header" style="background-color:#00b33c;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b style="color:white;">
                                <center>DATA TERDAKWA</center>
                              </b></h4>
                          </div>
                          <div class="modal-body">
                          </div>
                          <div class="modal-footer" style="background-color:#00b33c;">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">EXIT</button>
                          </div>
                        </div>
                      </div>
                    </div>


                  </tr>
                <?php
                  $i++;
                  $count++;
                }
                ?>
              </tbody>
            </table>
          </div>
        <?php echo paginate_one($reload, $page, $tpages);
      } ?>
        </div> <!-- End class="col-md-12"-->
      </div> <!-- End class="row"-->
    </div> <!-- End class="container"-->

</body>

<!-- Mirrored from www.w3schools.com/bootstrap/tryit.asp?filename=trybs_navbar_dropdown&stacked=h by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Mar 2016 11:04:58 GMT -->

</html>