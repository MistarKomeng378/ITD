<?php if($lvl>-5) { ?>
    <table width="100%">
        <tr>
            <td width="30%">Trx ID</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgTrxSearch_id"  name="dlgTrxSearch_id" style="width:80px;" /></td>
        </tr>
        <tr>
            <td width="30%">To (Bank Name)</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgTrxSearch_to"  name="dlgTrxSearch_to" style="width:180px;" /></td>
        </tr>
        <tr>
            <td>Client Code</td>
            <td>:</td>
            <td><input type="text" id="dlgTrxSearch_client_code"  name="dlgTrxSearch_client_code" style="width:80px;" /></td>
        </tr> 
        <tr>
            <td>Client Name</td>
            <td>:</td>
            <td><input type="text" id="dlgTrxSearch_client_name"  name="dlgTrxSearch_client_name" style="width:180px;" /></td>
        </tr>
        <tr>
            <td>Type</td>
            <td>:</td>
            <td>
            <select id="dlgTrxSearch_type">
                <option value="0">ALL</option>
                <option value="1">Penempatan</option>
                <option value="2">Perpanjangan</option>
                <option value="3">Pencairan</option>
                <option value="4">Break</option>
            </select>
            </td>
        </tr> 
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td>
            <select id="dlgTrxSearch_nominal_type">
                <option value="0">ALL</option>
                <option value="1">=</option>
                <option value="2">&lt;</option>
                <option value="3">&lt;=</option>
                <option value="4">&gt;</option>
                <option value="5">&gt;=</option>
            </select>
            <input type="text" id="dlgTrxSearch_nominal"  name="dlgTrxSearch_nominal" style="width:120px;text-align:right;" />
            </td>
        </tr> 
        <tr>
            <td>Tanggal Valuta</td>
            <td>:</td>
            <td>                                 
            <input type="text" id="dlgTrxSearch_sdate" style="width:80px;text-align:center;" /> s/d
            <input type="text" id="dlgTrxSearch_edate" style="width:80px;text-align:center;" />
            </td>
        </tr>
         <tr>
            <td>Status</td>
            <td>:</td>
            <td>
                <select name="status" id="dlgTrxSearch_status">
                    <option value="0">All</option>
                    <option value="1">Submitted</option>
                    <option value="2">Approved</option>
                </select>
            </td>
        </tr>
    </table>  
    <form action="<?php echo $url;?>index.php/itd/search_trx_approved_save" method="post" target="_blank" id="dlgTrxSearch_frm">
        <input type="hidden" name="trx_to" id="dlgTrxSearch_to1" />
        <input type="hidden" name="trx_ccode" id="dlgTrxSearch_client_code1" />
        <input type="hidden" name="trx_cname" id="dlgTrxSearch_client_name1" />
        <input type="hidden" name="trx_stype" id="dlgTrxSearch_type1" />
        <input type="hidden" name="trx_ntype" id="dlgTrxSearch_nominal_type1" />
        <input type="hidden" name="trx_nominal" id="dlgTrxSearch_nominal1" />
        <input type="hidden" name="trx_sdate" id="dlgTrxSearch_sdate1" />
        <input type="hidden" name="trx_edate" id="dlgTrxSearch_edate1" />
        <input type="hidden" name="trx_id" id="dlgTrxSearch_id1" />
        <input type="hidden" name="status" id="dlgTrxSearch_status1" />
    </form>               
<?php } ?>