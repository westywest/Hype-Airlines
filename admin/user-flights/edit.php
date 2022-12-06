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
        $id = $_GET['id'];
        $sql = "SELECT user_flights.id, user_flights.no_ticket, users.id as users_id, users.name, flights.id as flights_id, flights.flight_no, flights.departure_id, ref_departures.id as dep_id, ref_departures.name as departure, ref_arrivals.id as arr_id, flights.arrival_id, ref_arrivals.name as arrival, flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, user_flights.seat, user_flights.class, user_flights.gate FROM user_flights 
        JOIN users ON users.id = user_flights.user_id 
        JOIN flights ON flights.id = user_flights.flight_id 
        JOIN ref_departures ON ref_departures.id = flights.departure_id 
        JOIN ref_arrivals ON ref_arrivals.id = flights.arrival_id WHERE user_flights.id = '$id';";
        $datas = $conn->query($sql);

        while($data = mysqli_fetch_array($datas)){
            $no_ticket = $data['no_ticket'];
            $name = $data['name'];
            $flight_no = $data['flight_no'];
            $departure = $data['departure'];
            $arrival = $data['arrival'];
            $date_departure = $data['date_departure'];
            $date_arrival = $data['date_arrival'];
            $time_departure = $data['time_departure'];
            $time_arrival = $data['time_arrival'];
            $seat = $data['seat'];
            $class = $data['class'];
            $gate = $data['gate'];
        }
        
        if(isset($_POST['submit'])){
            $no_ticket = $_POST['no_ticket'];
            $user_id = $_POST['user_id'];
            $flight_id = $_POST['flight_id'];
            $seat = $_POST['seat'];
            $class = $_POST['class'];
            $gate = $_POST['gate'];
            include '../../connectDB.php';

            $sql = "UPDATE user_flights SET
            no_ticket = '$no_ticket',
            seat = '$seat',
            class = '$class',
            gate = '$gate' WHERE id = $id;";
            
            $datas = $conn->query($sql);
            
            if(mysqli_affected_rows($conn) > 0){
                header("Location:index.php");
            }else{
                $_SESSION['error'] = "Mengupdate data gagal!";
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
                            <a class="nav-link" aria-current="page" href="/StudyCase/admin/flights">
                                <i class="fa-solid fa-plane-departure px-2"></i>
                                <span>Penerbangan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">
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
                        <li class="breadcrumb-item"><a href="index.php">Tiket</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mengubah Data Pemesanan</li>
                    </ol>
                </nav>
                <h1 class="h2">Mengubah Data Pemesanan</h1>
                <p>Anda sedang mengedit data Pemesanan. Jangan lupa klik <b>tombol save</b> untuk menyimpan perubahan.</p>
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$id ?>" method="post">
                            <div class="mb-3">
                                <label for="no_ticket" class="form-label">No Tiket</label>
                                <input type="text" class="form-control" id="no_ticket" placeholder="no_ticket" name="no_ticket" required value="<?php echo $no_ticket; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select class="form-select" aria-label="Default select example" name="user_id" disabled>
                                    <?php
                                        echo "<option value=$user_id>$name</option>";
                                        $query = mysqli_query($conn, "SELECT * FROM users") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[name] </option>";
                                        }
                                    ?>
                                </select>                           
                            </div>
                            <div class="mb-3">
                                <label for="flight_id" class="form-label">Pesawat</label>
                                <select class="form-select" aria-label="Default select example" name="flight_id" disabled>
                                    <?php
                                        echo "<option value=$flight_id>$departure ($date_departure $time_departure) - $arrival ($date_arrival $time_arrival)</option>";
                                        $query = mysqli_query($conn, "SELECT * FROM flights") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[departure] ("."$data[date_departure] "."$data[time_departure]) - "."$data[arrival] ("."$data[date_arrival] "."$data[time_arrival]) </option>";
                                        }
                                    ?>
                                </select>                           
                            </div>
                            <div class="mb-3">
                                <label for="seat" class="form-label">Seat</label>
                                <input type="text" class="form-control" id="seat" placeholder="seat" name="seat" required value="<?php echo $seat; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Class</label>
                                <input type="text" class="form-control" id="class" placeholder="class" required name="class" value="<?php echo $class; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gate" class="form-label">Gate</label>
                                <input type="text" class="form-control" id="gate" placeholder="gate" required name="gate" value="<?php echo $gate; ?>">
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