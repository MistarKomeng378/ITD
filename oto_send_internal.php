<?php
define("BASEPATH",'itd');
include('application/config/database.php');
$connectionInfo = array( "UID"=>$db['dbjasgir']['username'],
                         "PWD"=>$db['dbjasgir']['password'],
                         "Database"=>$db['dbjasgir']['database']);
                         
$conn = sqlsrv_connect( $db['dbjasgir']['hostname'], $connectionInfo);

if( $conn === false )
{
     echo "Unable to connect1.</br>";
     die( print_r( sqlsrv_errors(), true));
} 

$tsql = "exec dbo.notif_get_mail_info";
$stmt = sqlsrv_query( $conn, $tsql);

$row_mail = sqlsrv_fetch_array($stmt);
sqlsrv_free_stmt( $stmt); 
sqlsrv_close( $conn);     

$today=date('m/d/Y');
//$today='3/5/2016';

$connectionInfo = array( "UID"=>$db['default']['username'],
                         "PWD"=>$db['default']['password'],
                         "Database"=>$db['default']['database']);
                         
$conn = sqlsrv_connect( $db['default']['hostname'], $connectionInfo);
                         


if( $conn === false )
{
     echo "Unable to connect2.</br>";
     die( print_r( sqlsrv_errors(), true));
} 

$tsql = "select * from itd_mail_internal";
$stmt = sqlsrv_query( $conn, $tsql);

$row_mailint = sqlsrv_fetch_array($stmt);
sqlsrv_free_stmt( $stmt); 

$tsql = "exec dbo.list_trx_due_mail_all '{$today}'";
$stmt = sqlsrv_query( $conn, $tsql);



$datahtml="
<table bgcolor=\"#585858\">
    <tr bgcolor=\"#E0E0E0\">
        <td><b>No</b></td>
        <td><b>Code</b></td>
        <td><b>Name</b></td>
        <td><b>Bank Name</b></td>
        <td align=\"right\"><b>Nominal</b></td>
        <td align=\"right\"><b>Rate</b></td>
        <td><b>Valuta Date</b></td>
        <td><b>Due Date</b></td>
        <td><b>Type</b></td>
    </tr>";
$gcode='!*@&*!@&*!@&';
$nrow=1;
$ada=false;
while($row_data = sqlsrv_fetch_array($stmt)) 
{
    $ada=true;
    if($gcode!=$row_data['group_code'])
    {
        $datahtml.="<tr bgcolor=\"#F0F0F0\">
        <td colspan=\"9\">{$row_data['group_name']}</td>
    </tr>";
        $gcode=$row_data['group_code'];
    }
    $datahtml.="<tr bgcolor=\"#ffffff\">
    <td>" . $nrow++ . "</td>
    <td>{$row_data['trx_client_code']}</td>
    <td>{$row_data['trx_client_name']}</td>
    <td>{$row_data['trx_to']}</td>
    <td align=\"right\">" . number_format($row_data['trx_nominal'],2,'.',',') . "</td>
    <td align=\"right\">" . number_format($row_data['trx_rate'],2,'.',',') . "</td>
    <td>" . date_format($row_data['trx_valuta_date'],'M d, Y') . "</td>
    <td>" . date_format($row_data['trx_due_date'],'M d, Y') . "</td>
    <td>{$row_data['type_desc']}</td>
</tr>";
    
}
$datahtml.="</table>";


sqlsrv_free_stmt( $stmt); 
sqlsrv_close( $conn);



//print_r($row_mail);
//print_r($rmail);   
require_once('PHPMailer_v5.1/class.phpmailer.php');     

if($ada)
{
    
    $mail = new PHPMailer(); // defaults to using php "mail()"
    
    $mail->IsSMTP();
    $mail->SMTPAuth = true;  
    $mail->Host = $row_mail['mail_host'];
    $mail->Port = 25;
    $mail->Username = $row_mail['mail_username'];
    $mail->Password   = $row_mail['mail_password'];
    $mail->SMTPDebug =1;
    $mail->From = $row_mail['mail_from'];
    $mail->FromName = $row_mail['mail_fromname'];
    $mail->AddReplyTo($row_mail['mail_from'],$row_mail['mail_fromname']);
    $mail->SetFrom($row_mail['mail_from'],$row_mail['mail_fromname']);
    $mail->Subject    ="Internal TD Maturity Reminder (" . date_format(date_create($today),'F d, Y') . ")";
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    
    $str_mail= str_replace(";",",",$row_mailint['mail']);
    $mailto = explode(',', $str_mail);
    foreach($mailto as $mailaddr)
    {
        if(trim($mailaddr)!='')
            $mail->AddAddress($mailaddr);
    }
    
    $str_mail= str_replace(";",",",$row_mailint['mail_cc']);
    $mailcc = explode(',', $str_mail);
    
    foreach($mailcc as $mailaddr)
    {
        if(trim($mailaddr)!='')
        {
            $mail->AddCC($mailaddr);
        }
    }
    
    $body = "<body>Dear All,<br /><br />
        Berikut data TD yang jatuh tempo pada hari ini ". date_format(date_create($today),'d F Y') .", yang belum ada instruksi dari nasabah atau belum dientry ke ITD. 
        {$datahtml}<br /><u>Agar segera dicek instruksinya atau kontak ke nasabah.</u><br /><br />Regards,<br/>ITD System
    </body>";
    echo $body;
    
    $mail->MsgHTML($body);
    
   if($mail->Send()) {
       echo "mail_send";
   }
}
    
    //$tsql = "sp_mail_date_update '{$today}'";
    //$stmt = sqlsrv_query( $conn, $tsql);

/**/
?>