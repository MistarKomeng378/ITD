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
        .str{ mso-number-format:\@; }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Parent ID</th>
            <th>NFS</th>
            <th>Status</th>
            <th>TGL Valuta</th>
            <th>TGL Jth Tempo</th>
            <th>Kepada</th>
            <th>Nama Klien</th>
            <th>Tipe Trx</th>
            <th>Nominal</th>
            <th>Bunga</th>
            <th>Pembayaran Bunga</th>
            <th>Dibuat Oleh</th>
            <th>TGL Buat</th>
        </tr>
        <?php
            $no = 1;
            foreach ($data as $key => $value) {
        ?>
        
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $value['trx_id']; ?></td>
                <td><?php echo $value['trx_id_upper']; ?></td>
                <td><?php echo $value['nfs_td']== '1' ? 'PTP' : ''; ?></td>
                <td><?php echo $value['status_desc']; ?></td>
                <td><?php echo $value['trx_valuta_date']->format('Y-m-d'); ?></td>
                <td><?php echo $value['trx_due_date']->format('Y-m-d'); ?></td>
                <td><?php echo $value['trx_to']; ?></td>
                <td><?php echo $value['trx_client_name']; ?></td>
                <td><?php echo $value['type_desc']; ?></td>
                <td><?php echo $value['trx_nominal']; ?></td>
                <td><?php echo $value['trx_rate']; ?>%</td>
                <td><?php echo $value['payment_desc']; ?></td>
                <td><?php echo $value['trx_create_by']; ?></td>
                <td><?php echo $value['trx_create_dt']->format('Y-m-d'); ?></td>
            </tr>

        <?php
            }
        ?>
    </table>
</body>

</html>