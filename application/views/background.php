<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="loading"></div>
    <div id="log"></div>

    <script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'; ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
            getData(<?php echo $mutasi; ?>);

        });

        function getData(mutasi) {

            $('#loading').html(
                '<img src="<?php echo base_url(); ?>img/ajax-loader.gif"></img>'+
                '<span>'+
                '<?php echo base_url().'index.php/mutasi/backgroundToMutasi?mutasi='; ?>'+mutasi+'&date='+'<?php echo $date; ?>'+
                '</span>'
            );
            $('#log').html('Antrian Ke = '+mutasi);

            var a = $.get('<?php echo base_url().'index.php/mutasi/backgroundToMutasi?mutasi='; ?>'+mutasi+'&date='+'<?php echo $date; ?>');
            a.done(function(data) {
                if ( (mutasi+1) <= 16 ) {
                    getData( mutasi+1 );
                }else{
                    window.close();
                }
            });
        }
    </script>
</body>
</html>