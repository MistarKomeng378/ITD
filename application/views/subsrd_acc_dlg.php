<?php if(5) { ?>
    <fieldset>
    <table width="100%">
        <tr>
            <td width="25%">Client Code</td>
            <td width="1%">:</td>
            <td>
                <select id="dlgSubsrdAccClient_code" onchange="set_subsrd_acc_par(this.value);get_sa_subsrd_acc_dlg(this.value,0);"></select>
            </td>
        </tr>
        <tr>
            <td>Selling Agent</td>
            <td>:</td>
            <td><select id="dlgSubsrdAccSa_id"></select></td>
        </tr>
        <tr>
            <td>Nama Bank</td>
            <td>:</td>
            <td><select id="dlgSubsrdAccBank_code"></select></td>
        </tr>
        <tr>
            <td>Account Type</td>
            <td>:</td>
            <td>
                <select id="dlgSubsrdAcc_type"></select>
            </td>
        </tr>
        <tr>
            <td>Account No</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrdAcc_no"  name="dlgSubsAcc_no" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>Account Name</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrdAcc_name"  name="dlgSubsAcc_name" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>Enable</td>
            <td>:</td>
            <td>
                <select id="dlgSubsrdAcc_enable">
                    <option value="1">Enable</option>
                    <option value="0">Disable</option>
                </select>
            </td>
        </tr>
    </table>   
    </fieldset>              
    <fieldset>
    <legend>Instruction Reference</legend>
    <table>
        <tr>
            <td width="25%">Kepada</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgSubsrdRef_to"  name="dlgSubsrdRef_to" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>Up.</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrdRef_up"  name="dlgSubsrdRef_up" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>Telp.</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrdRef_telp"  name="dlgSubsrdRef_telp" style="width:280px;" /></td>
        </tr><tr>
            <td>Fax.</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrdRef_fax"  name="dlgSubsrdRef_fax" style="width:280px;" /></td>
        </tr>
    </table>
    </fieldset>
<?php } ?>