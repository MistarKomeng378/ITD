<style>
    .font-md {
        font-size: 12px;
        margin-left: 20px;
    }
    .cell-title {
        font-weight: bold;
    }

    .cell-effort-driven {
        text-align: center;
    }

    .toggle {
        height: 9px;
        width: 9px;
        display: inline-block;
    }

    .toggle.expand {
        background: url(../img/expand.gif) no-repeat center center;
    }

    .toggle.collapse {
        background: url(../img/collapse.gif) no-repeat center center;
    }

    #hapus_pending_data {
        margin-bottom: 5px
    }
    #refresh_pending_data {
        margin-bottom: 5px
    }
</style>
<button id="hapus_pending_data">Hapus Data (0)</button>
<div id="list_pending" style="height: 170px;border: 1.25px solid #84142d;border-radius: 5px; margin-bottom: 15px"></div>

<span>Data Aapproved</span>
<div id="list_parent" style="margin-top: 10px; margin-bottom: 5px;
    height: 170px;
    border: 1.25px solid #84142d;
    border-radius: 5px;
    white-space: nowrap;">
</div>

<span>Hasil</span>
<div id="list_parent" style="height: 50px;
    border: 1.25px solid #84142d;
    border-radius: 5px;
    background: white;
    white-space: nowrap;">

    <ul class="font-md"><span id="result_parent" class="font-md">Parent : xxxxxxxx</span>
        <li id="result_chlid" class="font-md">Child : xxxxxx</li>
    </ul>
</div>

<div style="margin-top: 5px">
    <button id="pending_submit">Submit</button>
    <input type="hidden" id="input_parent">
    <input type="hidden" id="input_child">
</div>

