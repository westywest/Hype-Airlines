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
        include '../../connectDB.php';
        if(isset($_POST['submit'])){

            mysqli_query($conn, "INSERT INTO flights set
            flight_no = '$_POST[flight_no]',
            plane_id = '$_POST[plane_id]',
            departure_id = '$_POST[departure_id]',
            arrival_id = '$_POST[arrival_id]',
            date_departure = '$_POST[date_departure]',
            date_arrival = '$_POST[date_arrival]',
            time_departure = '$_POST[time_departure]',
            time_arrival = '$_POST[time_arrival]',
            price= '$_POST[price]'") or die(mysqli_error($conn));

            if(mysqli_affected_rows($conn) > 0){
                header("Location:index.php");
            }else{
                $_SESSION['error'] = "Menambah data gagal!";
            }
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
                            <a class="nav-link" aria-current="page" href="/StudyCase/admin/planes">
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
                        <li class="breadcrumb-item"><a href="index.php">Penerbangan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Membuat Data Penerbangan</li>
                    </ol>
                </nav>
                <h1 class="h2">Membuat Data Penerbangan</h1>
                <p>Anda sedang menambah data penerbangan baru.</p>

                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="mb-3">
                                <label for="flight_no" class="form-label">No Penerbangan</label>
                                <input type="text" class="form-control" id="flight_no" name="flight_no" placeholder="No Penerbangan" required>
                            </div>
                            <div class="mb-3">
                                <label for="plane_id" class="form-label">Pesawat</label>
                                <select class="form-select" aria-label="Default select example" name="plane_id">
                                    <option>Pilih Pesawat</option>
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * FROM planes") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[code] - "."$data[type] </option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="departure_id" class="form-label">Keberangkatan</label>
                                <select class="form-select" aria-label="Default select example" name="departure_id" id="">
                                    <option>Keberangkatan</option>
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * FROM ref_departures") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[name]</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="date_departure" class="form-label">Tanggal Keberangkatan</label>
                                <input type="date" class="form-control" id="date_departure" name="date_departure" placeholder="Tanggal Keberangkatan" required>
                            </div>
                            <div class="mb-3">
                                <label for="time_departure" class="form-label">Waktu Keberangkatan</label>
                                <input type="time" class="form-control" id="time_departure" name="time_departure" placeholder="Waktu Keberangkatan" required>
                            </div>
                            <div class="mb-3">
                                <label for="arrival_id" class="form-label">Kedatangan</label>
                                <select class="form-select" aria-label="Default select example" name="arrival_id" id="">
                                    <option>Kedatangan</option>
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * FROM ref_arrivals") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[name]</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date_arrival" class="form-label">Tanggal Kedatangan</label>
                                <input type="date" class="form-control" id="date_arrival" name="date_arrival" placeholder="Tanggal Kedatangan" required>
                            </div>
                            <div class="mb-3">
                                <label for="time_arrival" class="form-label">Waktu Kedatangan</label>
                                <input type="time" class="form-control" id="time_arrival" name="time_arrival" placeholder="Waktu Kedatangan" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Harga" required>
                            </div>
                            <p style="color:red; font-size: 12px;"><?php if(isset($_SESSION['error'])){ echo($_SESSION['error']);} ?></p>
                            <button class="btn btn-primary my-3" type="submit" name="submit" style="color: white;">Save</button>
                        </form>
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

    <?php
        unset($_SESSION['error']);
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.min.js" integrity="sha512-9rxMbTkN9JcgG5euudGbdIbhFZ7KGyAuVomdQDI9qXfPply9BJh0iqA7E/moLCatH2JD4xBGHwV6ezBkCpnjRQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>