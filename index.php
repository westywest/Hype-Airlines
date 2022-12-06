<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <title>HYPE AIRLINES</title>

    <style type="text/css">
      @import url('http://fonts.cdnfonts.com/css/gilroy-bold');
      body{
        background-color: #f9f9f9;
        font-family: 'Gilroy-Regular', sans-serif;
      }
      .navbar{
        background: #1b75bb;
      }
      .carousel-wrapper{
        height: 400px;
        background-color: #f9f9f9;
      }
      .form-select{
        width: 300px;
        height: 45px;
      }
      .fa-angles-down{
        color: #1b75bb;
      }
      .btn-search{
        background: #1B75BB;
        border: 0px;
        padding: 10px;
        border-radius: 20px;
        width: 100px;
        margin-left: 120px;
      }
      .btn-search-pick{
        background: #1B75BB;
        color: white;
        border: 0px;
        padding: 10px;
        border-radius: 20px;
        width: 120px;
        margin-left: 150px;
      }
      .panahBawah{
        margin-top: 15px;
        margin-bottom: 15px;
        padding-bottom: 40px;
      }
      .btn1{
        background: #1b75bb;
        color: #f9f9f9;
        border: 0px;
        padding: 10px;
        border-radius: 20px;
        width: 150px;
      }
      .btn2{
        background: #252525;
        color: #f9f9f9;
        border: 0px;
        padding: 10px;
        border-radius: 20px;
        width: 150px;
        margin-left: 10px;
      }
      .heading1{
        color: #1b75bb;
        font-family: 'Gilroy-Bold', sans-serif;
      }
      .heading3{
        color: #24a9e0;
        font-family: 'Gilroy-Bold', sans-serif;
      }
      footer{
        background-color: #1b75bb;
      }
    </style>
</head>
<body>
  <?php
    include 'connectDB.php';
    
    $sql = "SELECT flights.flight_no, flights.plane_id, planes.id, planes.code, planes.type, flights.departure_id, ref_departures.id, ref_departures.name as departures, ref_arrivals.id, flights.arrival_id, ref_arrivals.name as arrivals, flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, flights.price FROM flights 
            JOIN planes ON flights.plane_id = planes.id
            JOIN ref_departures ON flights.departure_id = ref_departures.id
            JOIN ref_arrivals ON flights.arrival_id = ref_arrivals.id";

    if(isset($_POST['filter_submit'])){
      if(($_POST['departure'] !== "")){
        $sql = "SELECT flights.flight_no, flights.plane_id, planes.id, planes.code, planes.type, flights.departure_id, ref_departures.id, ref_departures.name as departures, ref_arrivals.id, flights.arrival_id, ref_arrivals.name as arrivals, flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, flights.price FROM flights 
          JOIN planes ON flights.plane_id = planes.id
          JOIN ref_departures ON flights.departure_id = ref_departures.id
          JOIN ref_arrivals ON flights.arrival_id = ref_arrivals.id
          WHERE flights.departure_id = " .$_POST['departure'];
      }else if($_POST['arrival'] !== ""){
        $sql = "SELECT flights.flight_no, flights.plane_id, planes.id, planes.code, planes.type, flights.departure_id, ref_departures.id, ref_departures.name as departures, ref_arrivals.id, flights.arrival_id, ref_arrivals.name as arrivals, flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, flights.price FROM flights 
          JOIN planes ON flights.plane_id = planes.id
          JOIN ref_departures ON flights.departure_id = ref_departures.id
          JOIN ref_arrivals ON flights.arrival_id = ref_arrivals.id
          WHERE flights.arrival_id = " .$_POST['arrival'];
      }else if($_POST['date']){
        $tgl = $_POST['date'];
        $sql = "SELECT flights.flight_no, flights.plane_id, planes.id, planes.code, planes.type, flights.departure_id, ref_departures.id, ref_departures.name as departures, ref_arrivals.id, flights.arrival_id, ref_arrivals.name as arrivals, flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, flights.price FROM flights 
        JOIN planes ON flights.plane_id = planes.id
        JOIN ref_departures ON flights.departure_id = ref_departures.id
        JOIN ref_arrivals ON flights.arrival_id = ref_arrivals.id
        WHERE flights.date_departure = '$tgl'";
      }
    }

    $datas = $conn->query($sql);

    $departure_sql = "SELECT * FROM ref_departures";
    $departures = $conn->query($departure_sql);

    $arrival_sql = "SELECT * FROM ref_arrivals";
    $arrivals = $conn->query($arrival_sql);

  ?>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container container-fluid">
          <a class="navbar-brand" href="#"><img src="assets/img/logo-white.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="me-auto"></div>
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" style="color: #f9f9f9;" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color: #f9f9f9;" href="#">History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color: #f9f9f9;" href="/StudyCase/admin/index.php">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" style="color: #f9f9f9;">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
      <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" style="padding-top: 40px;">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-wrapper d-flex align-items-center">
              <div class="container">
                <div class="row">
                  <div class="col-8">
                    <h1 class="heading1">Dapatkan Diskon Spesial!</h1>
                    <h3 class="heading3">Beli tiket pesawat Airbus</h3>
                    <p>Pergi keliling Indonesia dengan maskapai Airbus, sudah pasti lebih untung! <b>Beli tiket Airbus di HYPE AIRLINES, ada diskon spesial hingga Rp.500.000,00!</b> Promo ini hanya berlaku untuk pembelian di website HYPE AIRLINES, ya!</p>
                    <button class="btn1">Selengkapnya</button>
                    <button class="btn2">Bagikan</button>
                  </div>
                  <div class="col-4">
                    <div class="m-auto" style="width: 200px; height: 200px;"><img src="assets/img/travel.png" alt=""></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-wrapper d-flex align-items-center">
              <div class="container">
                <div class="row">
                  <div class="col-8">
                    <h1 class="heading1">Diskon Tiket Pesawat dengan HYPEBGT!</h1>
                    <h3 class="heading3">Terbang ke semua rute Diskon hingga 10%</h3>
                    <p>Terbang makin seru pakai <b>diskon HYPEBGT! Dapatkan diskon hingga 10% untuk pembelian tiket pesawat domestik dan internasional ke semua rute pilihanmu.</b> Nikmati<b> promonya mulai pukul 04.00-07.00 WIB.</b> Jangan sampai ketinggalan ya!</p>
                    <button class="btn1">Selengkapnya</button>
                    <button class="btn2">Bagikan</button>
                  </div>
                  <div class="col-4">
                    <div class="m-auto" style="width: 200px; height: 200px;"><img src="assets/img/world.png" alt=""></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-wrapper d-flex align-items-center">
              <div class="container">
                <div class="row">
                  <div class="col-8">
                    <h1 class="heading1">Promo Pesawat Domestik</h1>
                    <h3 class="heading3">Tiket pesawat domestik Diskon hingga 300Rb</h3>
                    <p>Nikmati <b>diskon hingga Rp. 300.000,00 untuk penerbangan ke semua rute domestik. Syarat dan ketentuan berlaku ya!</b></p>
                    <button class="btn1">Selengkapnya</button>
                    <button class="btn2">Bagikan</button>
                  </div>
                  <div class="col-4">
                    <div class="m-auto" style="width: 200px; height: 200px;"><img src="assets/img/domestik.png" alt=""></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panahBawah">
        <i class="fa-solid fa-angles-down text-center d-block fa-3x"></i>
      </div>
      <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="row">
          <div class="col-3">
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="departure">
              <option value="">Dari</option>
              <?php foreach($departures as $departure): ?>
                <option value="<?php echo($departure['id']); ?>" <?php echo isset($_POST['departure']) && $_POST['departure'] == $departure['id'] ? "selected" : ""; ?>><?php echo($departure['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-3">
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="arrival">
            <option value="">Ke</option>
              <?php foreach($arrivals as $arrival): ?>
                <option value="<?php echo($arrival['id']); ?>" <?php echo isset($_POST['arrival']) && $_POST['arrival'] == $arrival['id'] ? "selected" : ""; ?>><?php echo($arrival['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-3">
            <input type="date" class="form-control" id="date" name="date" placeholder="Tanggal" required style="height: 45px;">
          </div>
          <div class="col-3">
            <button class="btn-search" name="filter_submit">
              <a class="nav-link" style="color: white;">
                <i class="fa fa-search" aria-hidden="true"></i>
              </a>
            </button>
          </div>
        </form>
      </div>
      <?php foreach($datas as $data):?>
        <?php
          $date_departure = date_create($data['date_departure']);
          $date_arrival = date_create($data['date_arrival']);
          $time_departure = date_create($data['time_departure']);
          $time_arrival = date_create($data['time_arrival']);
        ?>
        <div class="pb-5">
          <div class="bg-white p-4 rounded-4">
            <div class="row">
              <div class="col-2 text-center">
                <img class="mb-3" style="max-height: 60px;" src="assets/img/logo2.png" alt="Hype Airlines Logo">
                <p class="mb-0">Hype Airlines <br>(<?php echo $data['type']; ?> | <?php echo $data['code']; ?>)</p>
              </div>
              <div class="col-6 text-center">
                <p>Penerbangan <?php echo $data['flight_no']; ?></p>
              <div class="row d-flex align-item-center">
                <div class="col">
                  <h3 class="mb-0"><strong><?php echo $data['departures']; ?></strong></h3>
                  <p class="mb-0"><?php echo date_format($date_departure, "d M Y"); ?> (<?php echo date_format($time_departure, "H:i"); ?>)</p>
                </div>
                <div class="col">
                  <i class="fa-solid fa-angles-right" style="font-size: 30px;"></i>
                </div>
                <div class="col">
                  <h3 class="mb-0"><strong><?php echo $data['arrivals']; ?></strong></h3>
                  <p class="mb-0"><?php echo date_format($date_arrival, "d M Y"); ?> (<?php echo date_format($time_arrival, "H:i"); ?>)</p>
                </div>
              </div>
            </div>
            <div class="col-4 text-end">
              <h2 style="color: #1B75BB;">
              <Strong>IDR <?php echo number_format($data['price'], 0, ",", "."); ?>,-</Strong>
              <span style="font-size: 20px; color: black;">/pax</span>
              </h2>
              <button type="button" class="rounded-pill btn-primary button-blue px-5 mt-2" style="background: #1B75BB; color: white; border: 0px; padding: 10px">PILIH</button>
            </div>
            </div>
          </div>
        </div>
        <?php endforeach;?>
    </div>
      
    
    <footer class="py-5">
      <div class="container">
        <div class="row row-cols-4 " style="color: white;">
          <div class="col d-flex justify-content-start" style="padding-bottom: 10px;"><img src="assets/img/logo-white.png" alt=""></div>
          <div class="col"> </div>
          <div class="col-6">
            <ul class="nav justify-content-end">
              <li class="nav-item"><a href="#" class="nav-link px-2" style="color: white;">Home</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2" style="color: white;">FAQs</a></li>
              <li class="nav-item"><a href="#" class="nav-link px-2" style="color: white;">About</a></li>
            </ul>
          </div>
          <div class="col col-md-2">
            <ul class="nav flex-column justify-content-start">
              <li></li>
              <li class="nav-item mb-2"><p>081326051517</p></li>
              <li class="nav-item mb-2"><p>Purwokerto, Indonesia</p></li>
            </ul>
            </div>
          </div>
        </div>
      </div>
      <p class="text-center" style="color: white;">© 2022 HYPE AIRLINES. All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
</body>
</html>