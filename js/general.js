 /* Sorftable list functions */
  
  function CreateNewSortableList()
  {      
      var lastId = $('.sortablediv:last ul').attr('id');
      
      var lastchar = '';
      //Loop through all chars in string and check if it is a number
      for ( var i = 0; i < lastId.length; i++ )
      {
          if(!isNaN(lastId.charAt(i)))
          {
             lastchar += lastId.charAt(i);
          }
      }
      lastchar = parseInt(lastchar) +1;
      var id = 'sortable'+lastchar;
      $('.sortablediv:last').after('<div class="sortablediv newplaceholder"></div>');
      $('.newplaceholder').append('<h3>Liste '+lastchar+'</h3>');
      $('.newplaceholder').append('<ul id="'+id+'" class="connectedSortable"><li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item1</li><li onclick="CreateNewLiInSortableList(\''+id+'\')" class="AddLiButton ui-state-default non-dragable">Tilføj nyt li</li></ul>');
      $('.newplaceholder').append(' <input type="button" value="Slet liste '+id+'" onclick="DeleteSortableList(\''+id+'\')">');
      $('.sortablediv:last').removeClass('newplaceholder'); 
      UpdateSortableLists();   
  }
  
  function CreateNewLiInSortableList(id)
  {
      $('#'+id+' .AddLiButton').before('<li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Nyt li</li>');            
  }
  
  function UpdateSortableLists()
  {
      var ids = '';
      $(".sortablediv ul").each(function()
      {
                ids += '#'
                ids += $(this).attr('id');  
                ids += ',';             
      });
      $(ids).sortable({
                connectWith: ".connectedSortable",
                items: "li:not(.non-dragable)"
      }).disableSelection();
  }
  
  function DeleteLiSortable(elem)
  {
      var html = $(elem).html();
      if (confirm('Ønsker du at slette '+html)) 
      {
          $(elem).remove();
      }
  }
  
  function DeleteSortableList(id)
  {
      $('#'+id).parent().remove();
      $('#'+id).remove();
  }    
  
  function SaveSortableLists()
  {
      var globalIndex = '';
      //Array for all the lists
      var aAllLists = new Array();
      //aLists
      aAllLists[0] = "";
      //aAllLists[1] = "Menukort navn";

      $(".sortablediv ul").each(function(index)
      {
          //Aray for one list
          var aList = new Array();
          //sTitle
          aList[0] = $(this).prev().html();
          //iId
          aList[1] = $(this).attr('id');
          //sCategoriDescription
          aList[2] = "Beskrivelse"; 
          
          //Id used in the next jQuery each loop
          var iId = $(this).attr('id');
          $("#"+iId+" li:not(.AddLiButton)").each(function(index)
          {
              //Need to increse index with 3 so it does not overwrite aList[2];
              //This makes the first index to be 3
              index = index+3;
              
              //Array for li element
              var aLiElement = new Array();
              //sTitle
              aLiElement[0] = $(this).html();
              //iId
              aLiElement[1] = "Id";
              //sDescription
              aLiElement[2] = "Beskrivelse";
              //iPrice
              aLiElement[3] = "Prisen";
              //Put li array into array for one list
              aList[index] = aLiElement;
              
          });
          
          //Put aList array into aAllLists array on aLists wich is fiels 0
          aAllLists[index] = aList;
          globalIndex = index;
      });
      globalIndex++;
      //sMenucard name
      aAllLists[globalIndex] = "Menukort navn";
      
      var sJSONAllLists = JSON.stringify(aAllLists);
      
       $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"SaveMenucard",sJSONMenucard:sJSONAllLists}
       }).done(function(result) 
       {
           console.log('result: '+result.result);
       });
      
      
  }
  
  /* Sortable list functions end */