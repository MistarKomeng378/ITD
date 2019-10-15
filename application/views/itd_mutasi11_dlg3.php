<?php if($lvl>-5) { ?>
<?php if($unit!=2) { ?> 
<form action="<?php echo $url ?>index.php/mutasi_dlg/act_3" target="_rekap" id="frm_mutasi11_3" method="post">
Tanggal : <input type="text" id="i_mutasi11_dlg3_dt"  name="dt" style="width:80px;" />
<br />
Nomor item yang akan ditampilkan:
<br /><i>Dari nomor 3 &amp; coma "," sebgai delimeternya ex: a3,7,10 atau -6,9,10
<br />blank for all items
<br />+ item yang akan ditampilkan, contoh : a10,60,30 (menampilkan baris ke 10,60,30)
<br />- item yang akan dihilangkan, contoh -30,40,10 (menghilangkan baris ke 30,40,10)</i> :
<input type="text" id="i_mutasi11_dlg3_no"  name="no" style="width:300px;" />
<input type="hidden" id="i_mutasi11_dlg3_c_code" name="c_code" />
<input type="hidden" id="i_mutasi11_dlg3_acc_no" name="acc_no" />
</form>
<?php } ?>
<?php } ?>