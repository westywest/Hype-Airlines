<?php
    ob_start();
    include 'connectDB.php';

    $sql = "SELECT flights.flight_no, flights.plane_id, planes.id, planes.code, planes.type, flights.departure_id, 
            ref_departures.id, ref_departures.name as departures, ref_arrivals.id, flights.arrival_id, ref_arrivals.name as arrivals, 
            flights.date_departure, flights.date_arrival, flights.time_departure, flights.time_arrival, flights.price FROM flights 
            JOIN planes ON flights.plane_id = planes.id
            JOIN ref_departures ON flights.departure_id = ref_departures.id
            JOIN ref_arrivals ON flights.arrival_id = ref_arrivals.id";

    $datas = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    </style>
</head>
<body>
    <h2 class="text-center">Jadwal Penerbangan</h2>
    <table border="1" cellspacing="0" cellpadding="1"> 
        <thead>
            <tr>
                <th scope="col">Nomor Penerbangan</th>
                <th scope="col">Pesawat</th>
                <th scope="col">Keberangkatan</th>
                <th scope="col">DateTime Dep.</th>
                <th scope="col">Kedatangan</th>
                <th scope="col">DateTime Arr.</th>
                <th scope="col">Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($datas as $data):?>
                <?php
                $date_departure = date_create($data['date_departure']);
                $date_arrival = date_create($data['date_arrival']);
                $time_departure = date_create($data['time_departure']);
                $time_arrival = date_create($data['time_arrival']);
                ?>
                <tr>
                    <td><?php echo $data['flight_no']; ?></td>
                    <td><?php echo $data['type']; ?> | <?php echo $data['code']; ?></td>
                    <td><?php echo $data['departures']; ?></td>
                    <td><?php echo date_format($date_departure, "d M Y"); ?>(<?php echo date_format($time_departure, "H:i"); ?>)</td>
                    <td><?php echo $data['arrivals']; ?></td>
                    <td><?php echo date_format($date_arrival, "d M Y"); ?> (<?php echo date_format($time_arrival, "H:i"); ?>)</td>
                    <td>IDR <?php echo number_format($data['price'], 0, ",", "."); ?>,-</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
        require './mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(
            ['mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_top' => 25,
            'margin_bottom' => 25,
            'margin_left' => 25,
            'margin_right' => 25]
        );
        $html = ob_get_contents();

        ob_end_clean();
        $mpdf->WriteHTML(utf8_encode($html));
        
        $content = $mpdf->Output("cetak.pdf", "D");
    ?>
</body>
</html>
