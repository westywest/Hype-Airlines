    <?php
    $servername = "localhost";
    $database = "hype_airlines";
    $username = "root";
    $password = "";

    //berfungsi mengkonekan
    $conn = mysqli_connect($servername, $username, $password, $database);

    //cek apakah sudah terhubung denga database atau belum
    if(!$conn){
        die("Koneksi gagal: " . mysql_connect_error());
    }
    ?>