<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <style type="text/css">
        .card{
            background: #ebf2fa;
        }
        .btn{
            background-color: #0e1c36;
            color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php
        session_start(); //untuk menyimpan data saat login

        if(isset($_SESSION['status']) && $_SESSION['status'] === "login"){ //jika sudah pernah login maka diarahkan ke dashboard, dan proses dibawahnya tidak dijalankan
            header("location:/StudyCase/admin/dashboard.php");
            die();
        }
        include '../connectDB.php';

        if(isset($_POST['username']) && $_POST['password']){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM admins WHERE username='$username' and password='$password'";
            $data = $conn->query($sql);

            $check = mysqli_num_rows($data);

            if(isset($_POST['submit'])){
                if($check != 0){
                    $_SESSION['username'] = $username;
                    $_SESSION['status'] = "login";
                    header("location:/StudyCase/admin/dashboard.php");
                    die();
                }else{
                    $_SESSION['error'] = "Gagal login, silahkan cek kembali username dan password anda!";
                }
            }
        }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Login Form</h2>
                <div class="text-center mb-5 text-dark">Hype Airlines</div>
                <div class="card my-5">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="card-body cardbody-color p-lg-5">
                        <div class="text-center">
                            <img src="../assets/img/logo2.png" class="img-fluid profile-image-pic my-3"
                                width="200px" alt="profile">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="username" id="username" aria_describribedby="emailHelp" require placeholder="Username">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="password" aria_describribedby="emailHelp" placeholder="Password" require>
                        </div>
                        <p style="color: red; font-size: 12px;"><?php if(isset($_SESSION['error'])){ echo($_SESSION['error']);} ?>
                        </p>
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-color px-5 mb-5 w-100">Login</button>
                        </div>
                        <div id="emailHelp" class="form-text text-center mb-4 text-dark">
                            Not Registered?
                            <a href="#" class="text-dark fw-bold">Create an Account</a>
                            <br><br>
                            <a href="#" class="text-dark fw-bold">Back to Home</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        unset($_SESSION['error']);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
</body>
</html>
