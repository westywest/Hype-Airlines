<?php
    include '../../connectDB.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM user_flights WHERE id='$id'";
    $datas = $conn->query($sql);

    if(mysqli_affected_rows($conn) > 0){
        header("Location:index.php");
    }else{
        $_SESSION['error'] = "Menghapus data gagal!";
    }
?>