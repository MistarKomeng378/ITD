<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deposiito Jatuh Tempo</title>

    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td { 
            border: 1px solid black; 
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Tgl Valuta</th>
            <th>Tgl Jth Tempo</th>
            <th>Kepada</th>
            <th>Code</th>
            <th>Nama Klien</th>
            <th>Nominal</th>
            <th>Tipe Trx</th>
            <th>Bunga</th>
            <th>Pembayaran Bunga</th>
            <th>Dibuat Oleh</th>
            <th>Tgl Buat</th>
        </tr>
        <?php
        $no = 1;
        foreach ($r_sdata as $key => $value) {
            ?>

            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $value['trx_id']; ?></td>
                <td><?php echo $value['trx_valuta_date_s']; ?></td>
                <td><?php echo $value['trx_due_date_s']; ?></td>
                <td><?php echo $value['trx_client_code']; ?></td>
                <td><?php echo $value['trx_to']; ?></td>
                <td><?php echo $value['trx_client_name']; ?></td>
                <td><?php echo $value['trx_nominal']; ?></td>
                <td><?php echo $value['type_desc']; ?></td>
                <td><?php echo $value['trx_rate']; ?> %</td>
                <td><?php echo $value['payment_desc']; ?></td>
                <td><?php echo $value['trx_create_dt_s']; ?></td>
                <td><?php echo $value['trx_create_by']; ?></td>
            </tr>

        <?php
        }
        ?>
    </table>
</body>

</html>