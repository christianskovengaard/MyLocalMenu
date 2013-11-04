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
      $('.newplaceholder').append('<div class="DishEditWrapper"><div class="moveDish"><img src="img/moveIcon.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div></div>');
      $('.newplaceholder').append('<ul id="'+id+'" class="connectedSortable"><li onclick="CreateNewLiInSortableList(\''+id+'\')" class="AddLiButton non-dragable"><h3>+</h3></li></ul>');
//      $('.newplaceholder').append(' <input type="button" value="Slet liste '+id+'" onclick="DeleteSortableList(\''+id+'\')">');
      $('.sortablediv:last').removeClass('newplaceholder'); 
      UpdateSortableLists();   
  }
  
function CreateNewLiInSortableList(id)
  {
//    var GetMenuCardItemUl = document.getElementById(id);
    
    // Class = + TEMP for at undgå a appende til alle classer med samme navn, denne ændres sidst i funktionen.
    
    $('#'+id+' .AddLiButton').before('<li class="sortableLi sortableLiTEMP"></li>');
    $('.sortableLiTEMP').append('<div class="DishWrapper DishWrapperTEMP"></div>');
    $('.sortableLiTEMP').removeClass('sortableLiTEMP');
    
    $('.DishWrapperTEMP').append('<div class="DishNumber"><input type="text" maxlength="4" onkeyup="InputAutogrow(this);" placeholder="nr"></div>');
    $('.DishWrapperTEMP').append('<div class="DishText"><div class="DishHeadline"><input type="text" onkeyup="InputAutogrow(this);" placeholder="Overskrift"></div><div class="DishDescription"><textarea rows="1" onkeyup="InputAutoheigth(this);" placeholder="Beskrivelse"></textarea></div></div>');
    $('.DishWrapperTEMP').append('<div class="DishPrice"><h2>...</h2><input onkeyup="InputAutogrow(this);" type="text" placeholder="0"><h2>kr</h2></div>');
    $('.DishWrapperTEMP').append('<div class="DishEditWrapper"><div class="moveDish"><img src="img/moveIcon.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div></div>');
    $('.DishWrapperTEMP').removeClass('DishWrapperTEMP');
    $('.DishNumber input').focus();
    

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
                items: "li:not(.non-dragable)",
                tolerance: "pointer",
                handle: ".moveDish"
      }).disableSelection();
  }
  
  function DeleteLiSortable(elem)
  {
      var elem = $(elem).parent().parent();
      var text = $(elem).text();
      if (confirm('Ønsker du at slette '+text)) 
      {
          $(elem).remove();
      }
  }
  
  function DeleteSortableList(id)
  {
      var text = $(id).parent().parent().text();
      if (confirm('Ønsker du at slette '+text+' og alle under punkter?')) {
          
          $(id).parent().parent().remove();
      }
  }    
  
  function SaveSortableLists()
  {
      var iLastMenucardItemIndex = '';
      var globalIndex = '';
      var iLastIndexofMenucardCategories = '';
      var iLastIndexManucardItem = '';
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
              
              iLastIndexManucardItem = index+1;
              iLastMenucardItemIndex = index;
          });         
          
          //iLastMenucardItemIndex
          aList[iLastIndexManucardItem] = iLastMenucardItemIndex;
          
          //Put aList array into aAllLists array on aLists wich is fiels 0
          aAllLists[index] = aList;
          iLastIndexofMenucardCategories = index;
          globalIndex = index;
          
      });
      globalIndex++;
      //sMenucard name
      aAllLists[globalIndex] = "Menukort navn";
      //sMenucard description
      globalIndex++;
      aAllLists[globalIndex] = "Menukort beskrivelse";
      //iNumberofMenucardCategories
      globalIndex++;
      aAllLists[globalIndex] = iLastIndexofMenucardCategories;
      
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
  
function HideShowSwitch(CaseName,sObjectId) {
     
     switch(CaseName)
     {
        case 'PopUpWindow':
            $("#"+sObjectId).animate({height: 'toggle'},200);
            break;
        case 'HideSortableEdits':
            $(".DishEditWrapper").animate({height: 'toggle'},100);
            $(".AddLiButton").animate({top: 'toggle'},100);
            $(".newsortablediv").animate({top: 'toggle'},100);
            break;
        case 'Login':
            $("#"+sObjectId).animate({width: 'toggle'},100);
            $("#LoginEmail").focus();
            break;
     }

}
 
    function InputAutogrow(id){

        var value = $(id).val();
        var length = value.length + 2;
        
        $(id).css('width', length * 10);
        if( value == '0'){
            $(id).css('width', '10');
        }
        
    }
    
function InputAutoheigth(id){
    
    var value = $(id).val();
    var length = value.length;
    length = length /36;
    var rows = length + 1;
    $(id).attr('rows',rows);
        
    }
    