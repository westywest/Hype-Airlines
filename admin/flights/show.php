<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.min.css" integrity="sha512-V0+DPzYyLzIiMiWCg3nNdY+NyIiK9bED/T1xNBj08CaIUyK3sXRpB26OUCIzujMevxY9TRJFHQIxTwgzb0jVLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/style.css">
    <title>HYPE AIRLINES</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['status']) != "login"){
            header("location:/StudyCase/admin");
        }
        include_once '../../connectDB.php';

        $id = $_GET['id'];
        $sql = "SELECT flights.id, flights.flight_no, flights.plane_id, planes.id, planes.code, planes.type, flights.departure_id, ref_departures.id as dep_id, ref_departures.name as departure, ref_arrivals.id as arr_id, flights.arrival_id, ref_arrivals.name as arrival, flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, flights.price FROM flights 
        JOIN planes ON flights.plane_id = planes.id
        JOIN ref_departures ON flights.departure_id = ref_departures.id
        JOIN ref_arrivals ON flights.arrival_id = ref_arrivals.id WHERE flights.id='$id'";
        $datas = $conn->query($sql);

        while($data = mysqli_fetch_array($datas)){
            $flight_no = $data['flight_no'];
            $code = $data['code'];
            $type = $data['type'];
            $departure = $data['departure'];
            $date_departure = $data['date_departure'];
            $time_departure = $data['time_departure'];
            $arrival = $data['arrival'];
            $date_arrival = $data['date_arrival'];
            $time_arrival = $data['time_arrival'];
            $price = $data['price'];
        }
    ?>

<nav class="navbar navbar-light bg-light p-3">
        <div class="container-fluid d-flex col-12 col-md-3 col-lg-2 mb-lg-0 flex-wrap flex-md-nowrap justify-conteen-bentween">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="col-12 col-md-4 col-lg-2">
            <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
        </div>
        <div class="col-12 col-md-5 col-lg-8 d-flex align-item-center justify-content-md-end mt-3 mt-md-0">
            <div class="dropdown">
               <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Selamat Datang, <?php echo($_SESSION['username']) ?>
               </a>
               
               <ul class="dropdown-menu">
                <li>
                    <form id="logout_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <button class="dropdown-item" type="submit" name="submit">Logout</button>
                    </form>
                </li>
               </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/StudyCase/admin/dashboard.php">
                                <i class="fa-solid fa-home px-2"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/StudyCase/admin/users">
                                <i class="fa-solid fa-user px-2"></i>
                                <span>Pengguna</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">
                                <i class="fa-solid fa-plane px-2"></i>
                                <span>Pesawat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">
                                <i class="fa-solid fa-plane-departure px-2"></i>
                                <span>Penerbangan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/StudyCase/admin/user-flights">
                                <i class="fa-solid fa-ticket px-2"></i>
                                <span>Tiket</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Daftar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Melihat Data Penerbangan</li>
                    </ol>
                </nav>
                <h1 class="h2">Melihat Pengguna</h1>
                <p>Anda sedang melihat data penerbangan.</p>

                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="flight_no" class="form-label">No Penerbangan</label>
                            <input type="text" class="form-control" id="flight_no" placeholder="flight_no" required value="<?php echo $flight_no ?>" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" placeholder="Code" required value="<?php echo $code ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" id="type" placeholder="name@example.com" required value="<?php echo $type ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="departure" class="form-label">Keberangkatan</label>
                            <input type="text" class="form-control" id="departure" placeholder="departure" required value="<?php echo $departure ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="date_departure" class="form-label">Tanggal Keberangkatan</label>
                            <input type="text" class="form-control" id="date_departure" placeholder="date_departure" required value="<?php echo $date_departure ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="time_departure" class="form-label">Waktu Keberangkatan</label>
                            <input type="text" class="form-control" id="time_departure" placeholder="time_departure" required value="<?php echo $time_departure ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="arrival" class="form-label">Kedatangan</label>
                            <input type="text" class="form-control" id="arrival" placeholder="arrival" required value="<?php echo $arrival ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="date_arrival" class="form-label">Tanggal Kedatangan</label>
                            <input type="text" class="form-control" id="date_arrival" placeholder="date_arrival" required value="<?php echo $date_arrival ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="time_arrival" class="form-label">Waktu Kedatangan</label>
                            <input type="text" class="form-control" id="time_arrival" placeholder="time_arrival" required value="<?php echo $time_arrival ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="time_arrival" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="time_arrival" placeholder="time_arrival" required value="<?php echo $price ?>" disabled>
                        </div>
                    </div>
                </div>

                <footer class="pt-5 d-flex justify-content-between">
                    <span>Copyright © 2022 <a href="#">Hype Airlines</a></span>
                    <ul class="nav m-0">
                        <li class="nav-item">
                            <a class="nav-link text-secondary"href="#">Hubungi Kami</a>
                        </li>
                    </ul>
                </footer>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.min.js" integrity="sha512-9rxMbTkN9JcgG5euudGbdIbhFZ7KGyAuVomdQDI9qXfPply9BJh0iqA7E/moLCatH2JD4xBGHwV6ezBkCpnjRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
