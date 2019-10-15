<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Instruksi Transaksi Deposito</title>  
    <style type="text/css">
body {
 background-color: #ffffff;
 margin: 10px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 11pt;
 color: #000000;
 margin:0;
 padding:0;                                             
}                                                          
.big1 { 
    font-size: 14pt;
    text-transform: capitalize;
}
.big2 { 
    font-size: 18pt;
    text-transform: capitalize;
}
.small{
    font-size: 8pt;
}
.box{             
    border: 1px solid #7C3C10 ;
    padding: 2px 8px;
    margin-bottom: 5px;;
}
.box_blank{             
    padding: 0px;
    margin-bottom: 5px;;
}
    </style>
</head>
<body>
<table width="100%" border="1" cellspacing="1" cellpadding="2">
    <tr>
        <td><b>IN/OUT</b></td>  
        <td><b>Bilyet No</b></td>
        <td><b>Kepada</b></td>
        <td><b>Telp</b></td>
        <td><b>Bank Name</b></td>
        <td><b>Acc Name</b></td>
        <td><b>Acc No</b></td> 
        <td><b>Client Name</b></td>
        <td><b>Type</b></td>
        <td><b>Nominal</b></td>
        <td><b>Valuta Date</b></td>
        <td><b>Due Date</b></td>
        <td><b>Tgl IN</b></td>
        <td><b>Tgl OUT</b></td>
    </tr>             
<?php foreach ($r_sdata as $item1): ?>     
    <tr>
        <td><?php echo ($item1["trx_bilyet_flag_no"]=="" || $item1["trx_bilyet_flag_no"]=="NONE"?"&nbsp;":$item1["trx_bilyet_flag_no"]); ?></td>
        <td><?php echo ($item1["trx_bilyet_flag_no"]=="IN"?$item1["no_in"]:$item1["trx_bilyet_flag_no"]=="OUT"?$item1["no_out"]:"&nbsp;"); ?></td>
        <td><?php echo $item1["trx_to"];?></td>
        <td><?php echo $item1["trx_telp"];?></td>
        <td><?php echo $item1["trx_bank_name"];?></td>
        <td><?php echo $item1["trx_acc_name"];?></td>       
        <td><?php echo $item1["trx_acc_no"];?></td>
        <td><?php echo $item1["trx_client_name"];?></td>
        <td><?php echo $item1["type_desc"];?></td>
        <td align="right"><?php echo $item1["trx_nominal"];?></td>      
        <td><?php echo $item1["trx_valuta_date_s"];?></td> 
        <td><?php echo $item1["trx_due_date_s"];?></td> 
        <td><?php echo ($item1["trx_bilyet_flag_no"]=="IN"?$item1["dt_in_s"]:$item1["dt_out_s"]); ?></td>
        <td><?php echo ($item1["trx_bilyet_flag_no"]=="OUT"?$item1["no_out"]:"&nbsp;"); ?></td>
    </tr>             
<?php endforeach; ?>    
</table>                            
</body>
</html>
