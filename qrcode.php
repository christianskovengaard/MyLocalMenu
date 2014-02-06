<h2>QR koder</h2>
<div>
    <span>Brug denne QRcode til stempelkort</span>
    <div id="currentQRcode"></div>
</div>
<h2>Lav ny QR kode</h2>
<div>
    <span>Her kan du lave en ny QR kode</span>
    <br>
    <button onclick='GenerateQRcode()'>Lav ny QR kode</button>
    <div id="newQRcode">
        
    </div>
</div>
<script src='js/jquery-1.7.1.min.js'></script>
<script>
    
    var GenerateQRcode = function GenerateQRcode()
    {

       $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"GenerateQRcode"}
       }).done(function(result) 
       {
           
           $('#newQRcode').html('');
           $('#newQRcode').append('<img src="'+result.url+'">');
       })
    };

</script>
