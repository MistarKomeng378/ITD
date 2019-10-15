<html>
<head>
<title>TRX Search</title>

</head>
<body>
<?php if($r_success!=0) { ?>       
<table border="1">
    <tr bgcolor="#F0F0F0">
        <td><b>trx_id</b></td>
        <td><b>Parrent ID</b></td>
        <td align="center"><b>client Code</b></td>
        <td><b>client Name</b></td>
        <td><b>crx_to</b></td>
        <td><b>type</b></td>
        <td><b>valuta date</b></td>
        <td><b>due date</b></td>
        <td><b>nominal</b></td>
        <td><b>rate</b></td>
    </tr>
<?php 
    $irow=1;
    foreach($r_sdata as $item1)
    {?>
    <tr bgcolor="<?php echo ($irow%2==0)?'#ffffff':'#F0F0F0';?>">
        <td align="left"><?php echo $item1["trx_id"];?></td>
        <td align="left"><?php echo $item1["trx_id_upper"];?></td>
        <td align="left"><?php echo $item1["trx_client_code"];?></td>
        <td align="left"><?php echo $item1["trx_client_name"];?></td>
        <td align="left"><?php echo $item1["trx_to"];?></td>
        <td align="left"><?php echo $item1["type_desc"];?></td>
        <td align="center"><?php echo date_format($item1["trx_valuta_date"],"m/d/Y");?></td>
        <td align="center"><?php echo date_format($item1["trx_due_date"],"m/d/Y");?></td>
        <td align="right"><?php echo $item1["trx_nominal"];?></td>
        <td align="right"><?php echo $item1["trx_rate"] . "%";?></td>
    </tr>
<?php $irow++;}?>
</table>
<?php } ?>
</body>
</html>
