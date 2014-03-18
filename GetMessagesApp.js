
function GetMessagesAndStampsApp() {

       var aData = {};
       var menucards = {};
       
       menucards[0] = 'AA0000';
       menucards[1] = 'AA0001';
       menucards['sCustomerId'] = 'abc123';
       aData = menucards;
       //Workaround with encoding issue in IE8 and JSON.stringify
       for (var i in aData) {
           aData[i] = encodeURIComponent(aData[i]);
       }

       var sJSON = JSON.stringify(aData);
       
       //Make ajax call
   $.ajax({
        type: "GET",
        url: "/MyLocalMenu/API/api.php",
        dataType: "json",
        data: {sFunction:"GetMessagesAndStampsApp",sJSONMenucards:sJSON}
       }).done(function(result) 
       {
           
       });
       
}

