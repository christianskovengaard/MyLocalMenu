<h2>Beskeder</h2>
<h3>Skriv ny besked</h3>
<div>
    <span>Her kan du skrive en ny besked</span>
    <br>
    <div id="newMessages">
        
        <input id="sMessageHeadline" type="text" value="" placeholder="Overskrift"/>
        <br/>
        <textarea rows="8" cols="40" id="sMessageBodytext" placeholder="broedtekst"></textarea>
        <br/>
        <button onclick='SaveMessage()'>Gem besked</button>
     </div>
</div>

<h3>Se gamle beskeder</h3>
<div>
    <span>Her kan du se de gamle beskeder</span>
    <br>
    <button onclick='GetMessages()'>Hent gamle beskeder</button>
    <div id="oldMessages">
        
    </div>
</div>

<script src='js/jquery-1.7.1.min.js'></script>
<script>
    
    var GetMessages = function GetMessages()
    {

       $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"GetMessages"}
       }).done(function(result) 
       {

          $('#oldMessages').html('');

          $.each(result.Messages, function(key,value){
              $('#oldMessages').append('<div><h4>'+value.sMessageHeadline+'</h4><p>'+value.dtMessageDate+'</p><span>'+value.sMessageBodyText+'</span></div>');
          });
           
       });
    };
    
    var SaveMessage = function SaveMessage()
    {
       var aData = {};
       
       aData['sMessageHeadnline'] = $('#sMessageHeadline').val(); 
       aData['sMessageBodyText'] = $('#sMessageBodytext').val();
       
       //Workaround with encoding issue in IE8 and JSON.stringify
       for (var i in aData) {
           aData[i] = encodeURIComponent(aData[i]);
       }

       var sJSON = JSON.stringify(aData);
       
       $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"SaveMessage",sJSON:sJSON}
       }).done(function(result) 
       {
           alert('Besked gemt: '+result.result);
       })
    };

</script>
