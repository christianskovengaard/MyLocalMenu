 /* Sorftable list functions */

  function CreateNewSortableList()
  {    
      
      /*
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
      */
     
      var id = $('.sortableList').length;
      id = 'sortable'+id;
      
      $('.sortablediv:last').after('<div class="sortablediv newplaceholder sortableList"></div>');
      $('.newplaceholder').append('<h3><input type="text" onkeydown="if (event.keyCode == 13) { SaveMenuListHeadlineToHtml(\''+id+'\');}" placeholder="Overskrift"></h3>');
      $('.newplaceholder h3 input').focus();
      $('.newplaceholder').append('<h4><input type="text" onkeydown="if (event.keyCode == 13) { SaveMenuListHeadlineToHtml(\''+id+'\');}" placeholder="evt ekstra info"></h4>');
      $('.newplaceholder').append('<div class="DishEditWrapper"><div class="EditDish" onclick="EditListHeadline(this)"><img src="img/edit_white.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><img src="img/delete_white.png"></div></div><input type="hidden" value="new">');
      $('.DishEditWrapper').hide();
      $('.newplaceholder').append('<ul id="'+id+'" class="connectedSortable"><li></li></ul>');
      $('#'+id).append('<li class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelNewMenuList(this);"> Annuller</a><a class="saveMenuDishButton" onclick="SaveMenuListHeadlineToHtml(\''+id+'\');">✓ Opdatér</a></li>');
//      $('.newplaceholder').append('<ul id="'+id+'" class="connectedSortable"><li onclick="CreateNewLiInSortableList(\''+id+'\')" class="AddLiButton non-dragable"><h5>+</h5></li></ul>');
//      $('.newplaceholder').append(' <input type="button" value="Slet liste '+id+'" onclick="DeleteSortableList(\''+id+'\')">');
      $('.sortablediv:last').removeClass('newplaceholder'); 
      
      $('.AddLiButton').hide();
      $('.newsortablediv').hide();
      
      UpdateSortableLists();   
  }

  function CreateNewLiInSortableList(id)
  {
//    var GetMenuCardItemUl = document.getElementById(id);
    
    // Class = + TEMP for at undgå a appende til alle classer med samme navn, denne ændres sidst i funktionen.
    
    $('#'+id+' .AddLiButton').before('<li class="sortableLi sortableLiTEMP"></li>');
    $('.sortableLiTEMP').append('<div class="DishWrapper DishWrapperTEMP"><input type="hidden" class="DishId" value="" /><input type="hidden" class="DishPlaceInList" value="" /></div>');
    $('.sortableLiTEMP').removeClass('sortableLiTEMP');
    
    $('.DishWrapperTEMP').append('<div class="DishNumber"><input type="text" maxlength="4" placeholder="nr"></div>');
    $('.DishWrapperTEMP').append('<div class="DishText"><div class="DishHeadline"><input type="text" placeholder="Overskrift"></div><div class="DishDescription"><textarea rows="1" placeholder="Beskrivelse"></textarea></div></div>');
    $('.DishWrapperTEMP').append('<div class="DishPrice"><h2>...</h2><input type="text" onkeydown="if (event.keyCode == 13) { SaveMenuDishToHtml();}" placeholder="0"><h2>kr</h2></div>');
    $('.DishWrapperTEMP').append('<div class="DishEditWrapper DishEditWrapperTEMP"><div class="EditDish" onclick="EditSortableList(this)"><img src="img/edit.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><img src="img/delete.png"></div></div>');
    $('.DishWrapperTEMP').hide().slideDown();
    $('.DishWrapperTEMP').removeClass('DishWrapperTEMP');

    $('.DishNumber input').focus();
    
    $('.DishWrapper input').autoGrowInput();
    $('.DishDescription textarea').autogrow();
    
    $('.EditDish').hide();
    $('.AddLiButton').hide();
    $('.newsortablediv').hide();
    $('.newsortabledivbuffer').css('display', 'inline-block');
    $('#'+id+' .AddLiButton').before('<li class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelNewMenuDish();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveMenuDishToHtml();">✓ Opdatér</a></li>');
  
    //Update the items placement
    UpdatePlacementOfItems();
  }
  
  function CreateNewDivresturanatInfo() {
    $('.AddLiButton.info').before('<div Class="InfoSlide new"><input type="text" placeholder="Overskrift"><textarea rows="1" onkeyup="InputAutoheigth(this);" placeholder="Valgfri tekst"></textarea></div>');
    
    
    $('.InfoSlide.new textarea').autogrow();
    
    $('.InfoSlide.new input').focus();
    
    $('.AddLiButton').hide();
    $('.newsortablediv').hide();
    $('.newsortabledivbuffer').css('display', 'inline-block');
    $('.AddLiButton.info').before('<div class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelNewMenuDish();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveInfoToHtml();">✓ Opdatér</a></div>');
    $('.EditDish').hide();
      
  }
  
  function SaveMenuDishToHtml() {
      
      //Set sessionStorage bMenucardChaged to 'true'
      sessionStorage.bMenucardChanged = 'true';
        
      var Number = $('.DishNumber input').val();
      var Headline = $('.DishHeadline input').val();
      var Description = $('.DishDescription textarea').val();
      var price = $('.DishPrice input').val();
      
      //if(Headline != '' && price !=''){
          $('.DishNumber input').parent().html('<h1>'+Number+'</h1>');
          $('.DishHeadline input').parent().html('<h1>'+Headline+'</h1>');
          $('.DishDescription textarea').parent().html('<h2>'+Description+'</h2>');
          $('.DishPrice input').parent().html('<h2>...</h2><h2>'+price+'</h2><h2>kr</h2>');
          $('.SaveMenuDish').fadeOut('normal', function(){ 
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
          });
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          $('.EditDish').show();
          $(".DishEditWrapper").show();
          $('.DishEditWrapperTEMP').removeClass('DishEditWrapperTEMP');
      /*}
      
      else{
          
          alert("Udfyld venlist en overskrift og en pris");
          
      }*/
}
 
  function SaveInfoToHtml(){
      
      //Set session storage bmenucardchanged to 'true'
     sessionStorage.bMenucardChanged = 'true';
     
      var infoHeadline = $('.InfoSlide.new input').val();
      var infoDescription = $('.InfoSlide.new textarea').val();
      
      if(infoHeadline !== ''  && infoDescription !== ''){
          
          $('.InfoSlide.new').before('<div Class="InfoSlide"><h1>'+infoHeadline+'</h1><h2>'+infoDescription+'</h2><div class="DishEditWrapper"><div class="EditDish" onclick="EditInfo(this)"><img src="img/edit.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><img src="img/delete.png"></div></div></div>');
          $('.InfoSlide.new').remove();
          $('.SaveMenuDish').fadeOut('normal', function(){ 
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
          });
          $('.EditDish').show();
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          
      }
      else{
          alert("udfyld venlist alle felter");
      }    
 }   
  
  function SaveMenuListHeadlineToHtml(id){    
      var listHeadline = $('.sortablediv h3 input').val();
      var listDescription = $('.sortablediv h4 input').val();

      if(listHeadline !== ''){
          
          $('.sortablediv h3 input').parent().html(listHeadline);
          $('.sortablediv h4 input').parent().html(listDescription);
          

          $('.SaveMenuDish').fadeOut('normal', function(){ 
              
              //Removed this class 
              $(this).before('<li onclick="CreateNewLiInSortableList(\''+id+'\')" class="AddLiButton non-dragable"><h5>+</h5></li>');
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
              
          });
          $('.DishEditWrapper').show();
          $('.EditDish').show();
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          
          //Set Session storage
          sessionStorage.bMenucardChanged = 'true';
      }
      else{
          alert("udfyld venlist en overskrift");
      }    
 }
 
   function SaveEditedMenuListHeadlineToHtml(id){
      var listHeadline = $('.sortablediv h3 input').val();
      var listDescription = $('.sortablediv h4 input').val();

      if(listHeadline !== ''){
          
          $('.sortablediv h3 input').parent().html(listHeadline);
          $('.sortablediv h4 input').parent().html(listDescription);
          

          $('.SaveMenuDish').fadeOut('normal', function(){ 
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
              
          });
          $('.DishEditWrapper').show();
          $('.EditDish').show();
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          
          //Set Session storage
          sessionStorage.bMenucardChanged = 'true';
          
      }
      else{
          alert("udfyld venlist en overskrift");
      }    
 }
 
 function SaveEditedInfoToHtml(id){
     
     //Set session storage bmenucardchanged to 'true'
     sessionStorage.bMenucardChanged = 'true';
     
      var Headline = $('.InfoSlide input').val();
      var Description = $('.InfoSlide textarea').val();
      //Replace \n with <br />
      Description = Description.replace(/\r?\n/g, '<br />');
      
      
      //if(Headline !== '' && Description !== ''){
          
          $('.InfoSlide input').parent().html(Headline);
          $('.InfoSlide textarea').parent().html(Description);
          

          $('.SaveMenuDish').fadeOut('normal', function(){ 
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
              
          });
          $('.DishEditWrapper').show();
          $('.EditDish').show();
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          
      /*}
      else{
          alert("udfyld venlist begge felter");
      }*/    
 }
 
  
  function CancelNewMenuDish() {
          $('.DishEditWrapperTEMP').parent().slideUp('normal',function(){ $('.DishEditWrapperTEMP').parent().parent().remove(); });
          
          $('.InfoSlide.new').fadeOut('normal', function(){ 
              $(this).remove();
          });
          $('.SaveMenuDish').fadeOut('normal', function(){ 
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
          });
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          $('.EditDish').show();
}

  function CancelEditMenuDish() { 
          

          $('#DishNum').parent().html('<h1>'+sessionStorage.number+'</h1>');
          $('.DishHeadline input').parent().html('<h1>'+sessionStorage.headline+'</h1>');
          $('.DishDescription textarea').parent().html('<h2>'+sessionStorage.DishDescription+'</h2>');
          $('.DishPrice input').parent().html('<h2>...</h2><h2>'+sessionStorage.DishPrice+'</h2><h2>kr</h2>');

  
          $('.SaveMenuDish').fadeOut('normal');
          $('.AddLiButton').fadeIn('fast');
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          $('.EditDish').fadeIn();

}

  function CancelNewMenuList(id) {
          
          $(id).parent().parent().parent().remove();
          $('.AddLiButton').fadeIn('fast');
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          $('.DishEditWrapper').fadeIn();
          

}
  
  function UpdateSortableLists()
  {
      var ids = '';
      $(".sortablediv ul").each(function()
      {
                ids += '#';
                ids += $(this).attr('id');  
                ids += ',';             
      });
      $(ids).sortable({
                connectWith: ".connectedSortable",
                items: "li:not(.non-dragable)",
                tolerance: "pointer",
                change: function( event, ui ) {sessionStorage.bMenucardChanged = 'true';},
                update: function( event, ui ) {UpdatePlacementOfItems();}
      }).disableSelection();
  }
  
  function UpdatePlacementOfItems()
  {
     //Loop through for each sMenucardCategory
      $(".sortableList").each(function(categoryIndex)
      {         
          $(this).children("ul").each(function()
          {             
              $(this).children(":not(.AddLiButton)").each(function(index)
              {                
                  //Loop through .dishwrapper for each of the sMenucardItems
                  $(this).children().each(function()
                  {   
                      //Set the new placement for the item
                      index++;
                      $(this).children(".DishPlaceInList").val(index);
                  });
              });
          });
      });
  }
  
  function DeleteLiSortable(elem)
  {     
      var elem = $(elem).parent().parent();
      var text = $(elem).find('.DishHeadline').text();
      if (confirm('Dette vil slette menupunktet!')) 
      {
          $(elem).remove();
          //Set sessionStorage
          sessionStorage.bMenucardChanged = 'true';
      }
  }
  
  function DeleteSortableList(id)
  {    
      var text = $(id).parent().parent().find('h3').text();
      if (confirm('Dette vil slette '+text+' og alle menupunkter!')) {
          
          $(id).parent().parent().remove();
          //Set sessionStorage
          sessionStorage.bMenucardChanged = 'true';
      }
  } 
  
  function EditSortableList(id){
              
          var dish = $(id);
          var number = dish.closest('.DishWrapper').children('.DishNumber');
          var numberValue = number.text();
          number.html('<input id="DishNum" type="text" maxlength="4" value="'+numberValue+'">');

          var headline = dish.closest('.DishWrapper').children().children('.DishHeadline');
          var headlineValue = headline.text();
          headline.html('<input type="text" value="'+headlineValue+'">');

          var DishDescription = dish.closest('.DishWrapper').children().children('.DishDescription');
          var DishDescriptionValue = DishDescription.text();
          DishDescription.html('<textarea>'+DishDescriptionValue+'</textarea>');
          
          var DishPrice = dish.closest('.DishWrapper').children('.DishPrice');
          var DishPriceValue = DishPrice.children().eq(1).text();
          DishPrice.html('<h2>...</h2><input type="text" value="'+DishPriceValue+'"><h2>kr</h2>');
          
          var PriceWidth = 12*DishPriceValue.length;
          $('.DishPrice input').css('width',PriceWidth);
          $('#DishNum').focus();
          $('.DishWrapper input').autoGrowInput();
          $('.DishDescription textarea').autogrow();
    
          $('.EditDish').hide();
          
    if(typeof(Storage)!=="undefined"){
            sessionStorage.number = numberValue;
            sessionStorage.headline= headlineValue;
            sessionStorage.DishDescription = DishDescriptionValue;
            sessionStorage.DishPrice = DishPriceValue;
    }
    else
    {
      alert("Beklager, Der er en fejl. Du skal hente en nyrere Browser");
    }
    
    
    $('.AddLiButton').hide();
    $('.newsortablediv').hide();
    $('.newsortabledivbuffer').css('display', 'inline-block');
    dish.closest('.DishWrapper').after('<li class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelEditMenuDish();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveMenuDishToHtml();">✓ Opdatér</a></li>');
}
  
  function EditListHeadline(id){
  
          var headline = $(id).closest('.sortablediv').children('h3');
          var headlineText = headline.text();
          var description = $(id).closest('.sortablediv').children('h4');
          var descriptionText = description.text();
          
          if(typeof(Storage)!=="undefined"){
                sessionStorage.headlineHead = headlineText;
                sessionStorage.descriptionHEAD = descriptionText;
          }
          else
          {
                alert("Beklager, Der er en fejl. Du skal hente en nyrere Browser");
          }
          
          headline.html('<input id="headEditHeadline" type=text value="'+headlineText+'">');
          if( descriptionText === "" ){
            description.html('<input id="HeadEditDescription" type=text placeholder="evt ekstra info">');
          }
          else{
              description.html('<input id="HeadEditDescription" type=text value="'+descriptionText+'">');
          }
                    
          $('.EditDish').hide();
          
          $('.AddLiButton').hide();
          $('.newsortablediv').hide();
          $('.newsortabledivbuffer').css('display', 'inline-block');
          $(id).parent().after('<div class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelEditHeadline();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveEditedMenuListHeadlineToHtml(this);">✓ Opdatér</a></div>');
}
  function CancelEditHeadline(){
        $('#headEditHeadline').parent().html(sessionStorage.headlineHead);
        $('#HeadEditDescription').parent().html(sessionStorage.descriptionHEAD);
        $('.EditDish').fadeIn();
        $('.SaveMenuDish').fadeOut();
        $('.AddLiButton').fadeIn();
  }


  function EditInfo(id){
  
          var headline = $(id).closest('.InfoSlide').children('h1');
          var headlineText = headline.text();
          var description = $(id).closest('.InfoSlide').children('h2');
          var descriptionText = description.html();
          
          //Replace line breaks with \n 
          descriptionText = descriptionText.replace(/<br\s*\/?>/mg,"\n");

          if(typeof(Storage)!=="undefined"){
                sessionStorage.headlineInfo = headlineText;
                sessionStorage.descriptionInfo = descriptionText;
          }
          else
          {
                alert("Beklager, Der er en fejl. Du skal hente en nyrere Browser");
          }
          
          headline.html('<input id="InfoEditHeadline" type=text value="'+headlineText+'">');
          description.html('<textarea id="InfoEditDescription">'+descriptionText+'"</textarea>');
          
          $('.InfoSlide textarea').autogrow();
                    
          $('.EditDish').hide();
    
          $('.AddLiButton').hide();
          $('.newsortablediv').hide();
          $('.newsortabledivbuffer').css('display', 'inline-block');
          $(id).parent().after('<div class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelEditMenuinfo();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveEditedInfoToHtml(this);">✓ Opdatér</a></div>');
}

   function CancelEditMenuinfo(){
       $('#InfoEditHeadline').parent().html(sessionStorage.headlineInfo);
       $('#InfoEditDescription').parent().html(sessionStorage.descriptionInfo);
       
       $('.EditDish').fadeIn();
       $('.SaveMenuDish').fadeOut();
       $('.newsortablediv').fadeIn();
   }

  function UpdateMenucard()
  {
      
      //$('#EditMenuButton').text('');
      //$('#EditMenuButton').append('<div class="buttonEdit" onclick="HideShowSwitch(\'HideSortableEdits\');"><img src="img/edit.png">Menukort</div>');
                   
      //$(".DishEditWrapper").slideUp(100);
      //$(".AddLiButton").slideUp(100);
      //$(".newsortablediv").slideUp(100); 
      
      
      var iLastMenucardItemIndex = '';
      var iLastIndexofMenucardCategories = '';
      //Array for all the lists, as and assoc array
      var aAllLists = {};
      //aLists
      //aAllLists['allMenuCategories'] = "";     
      
      
      //Loop through for each sMenucardCategory
      $(".sortableList").each(function(categoryIndex)
      {
          //Aray for one list, as and assoc array
          var aList = {};
          //sMenucardCategoryName
          aList['sMenucardCategoryName'] = $(this).children(":first").html();
          //iMenucardCategoryIdHashed
          aList['iId'] = $(this).children("input[type='hidden']:first").val(); //$(this).attr('id');          
          //sMenucardCategoryDescription
          aList['sMenucardCategoryDescription'] = $(this).children().eq(1).html(); 

          $(this).children("ul").each(function()
          {             
              $(this).children(":not(.AddLiButton)").each(function(index)
              {
                  
                  //Loop through .dishwrapper for each of the sMenucardItems
                  $(this).children().each(function()
                  {                      
                      var sMenucardItemNumber = $(this).children(".DishNumber").children("h1").html();                     
                      var sMenucardItemDesc = $(this).children(".DishText").children(".DishDescription").children("h2").html(); 
                      var sMenucardItemName = $(this).children(".DishText").children(".DishHeadline").children("h1").html();
                      var sMenucardItemPrice = $(this).children(".DishPrice").children(":nth-child(2)").html();
                      var sMenucardItemIdHashed = $(this).children(".DishId").val();
                      var iMenucardItemPlaceInList = $(this).children(".DishPlaceInList").val();
                      
                      //Array for li element, as assoc array
                      var aLiElement = {};
                      //sTitle
                      aLiElement['sTitle'] = sMenucardItemName;
                      //iId
                      aLiElement['iId'] = sMenucardItemIdHashed;
                      //sDescription
                      aLiElement['sDescription'] = sMenucardItemDesc;
                      //iPrice
                      aLiElement['iPrice'] = sMenucardItemPrice;
                      //iNumber
                      aLiElement['iNumber'] = sMenucardItemNumber;
                      //iPlaceInList
                      aLiElement['iPlaceInList'] = iMenucardItemPlaceInList;
                      //Put li array into array for one list
                      aList[index] = aLiElement;

                      iLastMenucardItemIndex = index;
                  });
              });
          });
                  
          //iLastMenucardItemIndex
          aList['iLastMenucardItemIndex'] = iLastMenucardItemIndex;
          //Put aList array into aAllLists array on aLists wich is fiels 0
          aAllLists[categoryIndex] = aList;
          iLastIndexofMenucardCategories = categoryIndex;
          
          
      });
      

      //sMenucard name
      aAllLists['sMenucardname'] = "Menukort navn";
      //sMenucard description
      aAllLists['sMenucarddescription'] = "Menukort beskrivelse";
      aAllLists['iMenucardIdHashed'] = $('#iMenucardIdHashed').val();
      //iNumberofMenucardCategories
      aAllLists['iLastIndexofMenucardCategories'] = iLastIndexofMenucardCategories;
      
      //restuarantInfo, Get menucardinfo
      //Loop through for each sMenucardCategory
      $("#restuarantInfo .InfoSlide > .InfoSlidebox").each(function(index)
      {   
          //alert($(this).html());
          //Getting opening hours
          
      });
      var aAllMenucardInfo = {};
      $("#restuarantInfo .InfoSlide").each(function(index)
      {
          if(index > 0){
            var aMenucardInfo = {};
            aMenucardInfo['headline'] = $(this).find('h1').html();;
            //Get text and Replace <br/> tags with \n
            aMenucardInfo['text'] = $(this).find('h2').html().replace(/<br\s*\/?>/mg,"\n");;
            aAllMenucardInfo[index] = aMenucardInfo;
            aAllMenucardInfo['iLastIndexOfmenucardinfo'] = index;
          }
      }); 
      aAllLists['menucardinfo'] = aAllMenucardInfo;
      var sJSONAllLists = JSON.stringify(aAllLists);
      
      
       $.ajax({
        type: "POST",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"UpdateMenucard",sJSONMenucard:sJSONAllLists}
       }).done(function(result) 
       {
           //Set sessionStorage.bMenucardChanged = 'false';
           sessionStorage.bMenucardChanged = 'false';
           
           //reload the menucard
           //GetMenucard(true);
       });
  }
  
  
  function AutomaticUpdateMenucard()
  {
      //console.log('AutomaticUpdateMenucard');
     
      //Set session storage     
      if(typeof(Storage)!=="undefined") {
          //Set value when the page is loaded
          if(sessionStorage.bMenucardChanged === undefined){
              sessionStorage.bMenucardChanged = 'false';
          }
      }
      else {
        alert('Sorry! No Web Storage support..');
      }
      
      //console.log('bMenucardChanged '+sessionStorage.bMenucardChanged);
      //console.log('$.active '+$.active);
      //Check if the menucard has been changed
      //If changed the run the ajax call
      if(sessionStorage.bMenucardChanged === 'true') {
          
        //Check if a ajax call is all ready running
        if($.active === 0){ 
            //alert('run ajax call');
            UpdateMenucard();
        }else {
            console.log('Det kører allerede et ajax call');
        }      
      }
      //Run every 5 second
      setTimeout(function(){AutomaticUpdateMenucard();},5000);
  }
    
  function SaveMenucard()
  {
      $('#EditMenuButton').text('');
      $('#EditMenuButton').append('<div class="buttonEdit" onclick="HideShowSwitch(\'HideSortableEdits\');"><img src="img/edit.png">Menukort</div>');
                   
      $(".DishEditWrapper").slideUp(100);
      $(".AddLiButton").slideUp(100);
      $(".newsortablediv").slideUp(100);
      
      var iLastMenucardItemIndex = '';
      var iLastIndexofMenucardCategories = '';
      //Array for all the lists, as and assoc array
      var aAllLists = {};
      //aLists
      //aAllLists['allMenuCategories'] = "";     
      
      
      //Loop through for each sMenucardCategory
      $(".sortableList").each(function(categoryIndex)
      {
          //Aray for one list, as and assoc array
          var aList = {};
          //sMenucardCategoryName
          aList['sMenucardCategoryName'] = $(this).children(":first").html();
          //iMenucardCategoryIdHashed
          aList['iId'] = $(this).children("input[type='hidden']:first").val(); //$(this).attr('id');          
          //sMenucardCategoryDescription
          aList['sMenucardCategoryDescription'] = $(this).children().eq(1).html(); 
          
          $(this).children("ul").each(function()
          {             
              $(this).children(":not(.AddLiButton)").each(function(index)
              {
                  
                  //Loop through .dishwrapper for each of the sMenucardItems
                  $(this).children().each(function()
                  {                      
                      var sMenucardItemNumber = $(this).children(".DishNumber").children("h1").html();                     
                      var sMenucardItemDesc = $(this).children(".DishText").children(".DishDescription").children("h2").html(); 
                      var sMenucardItemName = $(this).children(".DishText").children(".DishHeadline").children("h1").html();
                      var sMenucardItemPrice = $(this).children(".DishPrice").children(":nth-child(2)").html();
                      var iMenucardItemPlaceInList = $(this).children(".DishPlaceInList").val();
                      
                      //Array for li element, as assoc array
                      var aLiElement = {};
                      //sTitle
                      aLiElement['sTitle'] = sMenucardItemName;
                      //iId
                      aLiElement['iId'] = "Id";
                      //sDescription
                      aLiElement['sDescription'] = sMenucardItemDesc;
                      //iPrice
                      aLiElement['iPrice'] = sMenucardItemPrice;
                      //iNumber
                      aLiElement['iNumber'] = sMenucardItemNumber;
                      //iPlaceInList
                      aLiElement['iPlaceInList'] = iMenucardItemPlaceInList;
                      //Put li array into array for one list
                      aList[index] = aLiElement;

                      iLastMenucardItemIndex = index;
                  });
              });
          });
                  
          //iLastMenucardItemIndex
          aList['iLastMenucardItemIndex'] = iLastMenucardItemIndex;
          //Put aList array into aAllLists array on aLists wich is fiels 0
          aAllLists[categoryIndex] = aList;
          iLastIndexofMenucardCategories = categoryIndex;
          
          
      });
      

      //sMenucard name
      aAllLists['sMenucardname'] = "Menukort navn HARDCODED";
      //sMenucard description
      aAllLists['sMenucarddescription'] = "Menukort beskrivelse HARDCODED";
      aAllLists['iMenucardIdHashed'] = "Menucard ID HARDCODED";
      //iNumberofMenucardCategories
      aAllLists['iLastIndexofMenucardCategories'] = iLastIndexofMenucardCategories;
      
      //restuarantInfo, Get menucardinfo
      //Loop through for each sMenucardCategory
      $("#restuarantInfo .InfoSlide > .InfoSlidebox").each(function(index)
      {   
          //alert($(this).html());
          //Getting opening hours
          
      });
      var aAllMenucardInfo = {};
      $("#restuarantInfo .InfoSlide").each(function(index)
      {
          if(index > 0){
            var aMenucardInfo = {};
            aMenucardInfo['headline'] = $(this).find('h1').html();;
            aMenucardInfo['text'] = $(this).find('h2').html();;
            aAllMenucardInfo[index] = aMenucardInfo;
            aAllMenucardInfo['iLastIndexOfmenucardinfo'] = index;
          }
      }); 
      aAllLists['menucardinfo'] = aAllMenucardInfo;
      var sJSONAllLists = JSON.stringify(aAllLists);
      
       $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"SaveMenucard",sJSONMenucard:sJSONAllLists}
       }).done(function(result) 
       {
           //console.log('result: '+result.result);
       });
       
  }
  
  /* Sortable list functions end */

  function UpdateRestuarentInfo()
  {    
      var aData = {};
      
      //Get restuarent info from database opening hours
      aData['sRestuarentName'] = $("#MenuName").val();
      aData['sRestuarentSlogan'] = $("#MenuSubName").val();
      aData['sRestuarentAddress'] = $("#MenuAdress").val();

      
      aData['sRestuarentZipcode'] =$("#MenuZip").val();
      /*
       aData['sRestuarentCity'] = $("#MenuTown").val();
      */

      aData['sRestuarentPhone'] = $("#MenuPhone").val();
   
     //Get the Openinghours monday-sunday   
     aData['iMondayTimeFrom'] = $("#iMondayTimeFrom option:selected").val();
     aData['iMondayTimeTo'] = $("#iMondayTimeTo option:selected").val();
     aData['iThuesdayTimeFrom'] = $("#iThuesdayTimeFrom option:selected").val();   
     aData['iThuesdayTimeTo'] = $("#iThuesdayTimeTo option:selected").val();
     aData['iWednesdaysTimeFrom'] = $("#iWednesdaysTimeFrom option:selected").val();
     aData['iWednesdaysTimeTo'] = $("#iWednesdaysTimeTo option:selected").val();
     aData['iThursdayTimeFrom'] = $("#iThursdayTimeFrom option:selected").val();
     aData['iThursdayTimeTo'] = $("#iThursdayTimeTo option:selected").val();
     aData['iFridayTimeFrom'] = $("#iFridayTimeFrom option:selected").val();
     aData['iFridayTimeTo'] = $("#iFridayTimeTo option:selected").val();
     aData['iSaturdayTimeFrom'] = $("#iSaturdayTimeFrom option:selected").val();
     aData['iSaturdayTimeTo'] = $("#iSaturdayTimeTo option:selected").val();
     aData['iSundayTimeFrom'] = $("#iSundayTimeFrom option:selected").val();
     aData['iSundayTimeTo'] = $("#iSundayTimeTo option:selected").val();
     
     //Get the Openinghours if closed
     if($("#Day1_Closed").is(':checked')){aData['iMondayClosed'] = 1;}else{aData['iMondayClosed'] = 0;}
     if($("#Day2_Closed").is(':checked')){aData['iThuesdayClosed'] = 1;}else{aData['iThuesdayClosed'] = 0;}
     if($("#Day3_Closed").is(':checked')){aData['iWednesdaysClosed'] = 1;}else{aData['iWednesdaysClosed'] = 0;}
     if($("#Day4_Closed").is(':checked')){aData['iThursdayClosed'] = 1;}else{aData['iThursdayClosed'] = 0;}
     if($("#Day5_Closed").is(':checked')){aData['iFridayClosed'] = 1;}else{aData['iFridayClosed'] = 0;}
     if($("#Day6_Closed").is(':checked')){aData['iSaturdayClosed'] = 1;}else{aData['iSaturdayClosed'] = 0;}
     if($("#Day7_Closed").is(':checked')){aData['iSundayClosed'] = 1;}else{aData['iSundayClosed'] = 0;}
     
      
     //Workaround with encoding issue in IE8 and JSON.stringify
     for (var i in aData) {
             aData[i] = encodeURIComponent(aData[i]);
     }
    
     var sJSON = JSON.stringify(aData);
      
      //Use admin.php    
        $.ajax({
          type: "GET",
          url: "API/api.php",
          dataType: "json",
          data: {sFunction:"UpdateRestuarentInfo",sJSON:sJSON}
         }).done(function(result){
             if(result.result === true){
                
                //Update info in DOM
                $('.Restaurant.Name h1').html($("#MenuName").val());
                $('.Restaurant.Name h2').html($("#MenuSubName").val());
                $('.RestaurantPhone h2').html($("#MenuPhone").val());
                $('.RestaurantAdresse h4').html($("#MenuAdress").val()+', '+$('#MenuZip').val()+' '+$('#MenuTown').val());
                
                
                //Update opening hours in the DOM
                $('#Openinghours').html('');
                if($('#Day1_Closed').attr('checked') === undefined) { var mondaytime = $("#iMondayTimeFrom option:selected").text()+'-'+$("#iMondayTimeTo option:selected").text();}else{mondaytime = 'Lukket';}
                if($('#Day2_Closed').attr('checked') === undefined) { var thuesdaytime = $("#iThuesdayTimeFrom option:selected").text()+'-'+$("#iThuesdayTimeTo option:selected").text();}else{thuesdaytime = 'Lukket';}
                if($('#Day3_Closed').attr('checked') === undefined) { var wednestime = $("#iWednesdaysTimeFrom option:selected").text()+'-'+$("#iWednesdaysTimeTo option:selected").text();}else{wednestime = 'Lukket';}
                if($('#Day4_Closed').attr('checked') === undefined) { var thurstime = $("#iThursdayTimeFrom option:selected").text()+'-'+$("#iThursdayTimeTo option:selected").text();}else{thurstime = 'Lukket';}
                if($('#Day5_Closed').attr('checked') === undefined) { var fridaytime = $("#iFridayTimeFrom option:selected").text()+'-'+$("#iFridayTimeTo option:selected").text();}else{fridaytime = 'Lukket';}
                if($('#Day6_Closed').attr('checked') === undefined) { var saturdaytime = $("#iSaturdayTimeFrom option:selected").text()+'-'+$("#iSaturdayTimeTo option:selected").text();}else{saturdaytime = 'Lukket';}
                if($('#Day7_Closed').attr('checked') === undefined) { var sundaytime = $("#iSundayTimeFrom option:selected").text()+'-'+$("#iSundayTimeTo option:selected").text();}else{sundaytime = 'Lukket';}
                                             
                $('#Openinghours').append('<h3>Åbningstider</h3>\n\
                                           <h4>Man</h4><h4>'+mondaytime+'</h4><br>\n\
                                           <h4>Tir</h4><h4>'+thuesdaytime+'</h4><br>\n\
                                           <h4>Ons</h4><h4>'+wednestime+'</h4><br>\n\
                                           <h4>Tor</h4><h4>'+thurstime+'</h4><br>\n\
                                           <h4>Fre</h4><h4>'+fridaytime+'</h4><br>\n\
                                           <h4>Lør</h4><h4>'+saturdaytime+'</h4><br>\n\
                                           <h4>Søn</h4><h4>'+sundaytime+'</h4>');
                                           
             
                //Update the day today
                //0 = Sunday, 1 = Monday, 2 = Thuesday and so on up to 6 = Saturday
                var day =  new Date().getDay();
                if(day === 0){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iSundayTimeFrom option:selected").text()+'-'+$("#iSundayTimeTo option:selected").text()+'</h4>');} 
                if(day === 1){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iMondayTimeFrom option:selected").text()+'-'+$("#iMondayTimeTo option:selected").text()+'</h4>');} 
                if(day === 2){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iThuesdayTimeFrom option:selected").text()+'-'+$("#iThuesdayTimeTo option:selected").text()+'</h4>');}
                if(day === 3){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iWednesdaysTimeFrom option:selected").text()+'-'+$("#iWednesdaysTimeTo option:selected").text()+'</h4>');}
                if(day === 4){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iThursdayTimeFrom option:selected").text()+'-'+$("#iThursdayTimeTo option:selected").text()+'</h4>');}
                if(day === 5){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iFridayTimeFrom option:selected").text()+'-'+$("#iFridayTimeTo option:selected").text()+'</h4>');}
                if(day === 6){$('.Restaurant.OpeningHours h4:nth-child(2)').html('<h4>I dag: '+$("#iSaturdayTimeFrom option:selected").text()+'-'+$("#iSaturdayTimeTo option:selected").text()+'</h4>');}
                
                //TODO: Check if the new time is in between the time now and update open class

                //show update is done
                alertSucces();
            }
         });
      
  }

  function alertSucces() {
    $("body").append("<div class='fullPage'><div class='inforUpdateAlert'>Oplysningerne er opdateret ✓</div></div>");
          $(".fullPage").hide().fadeIn("slow", function(){
                  $(this).delay(1000).fadeOut(1000, function(){
                      $(this).remove();
          });
    });
  }

  /* GetMenucard function */
  
  function getUrlVars() 
  {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
  }

   
  function GetMenucard(isAdmin)
  {
        //isAdmin is used to see if the user is logged in or not
        //If the user is logged in then use the admin.php
        //If the user is NOT logged in then use the viewmenucard.php

        //Load the mustache template into viewmenucard
        if(isAdmin === true)
        {
            //console.warn('ADMIN');
            //Clear the area
            $('.sortableList').remove();
            $('#iMenucardIdHashed').remove();
            
            //Use admin.php    
            $.ajax({
              type: "GET",
              url: "API/api.php",
              dataType: "json",
              data: {sFunction:"GetMenucardAdmin"}
             }).done(function(result){
                 if(result.result === true){

                      //Load the template restuarentinfo_viewmenucard.html into viewmenucard.php
                      $("#mustache_template").load( "mustache_templates/restuarentinfo_admin.html",function(){

                          var restuarent = {
                              sRestuarentName: result.sRestuarentName,
                              iMenucardSerialNumber: result.iMenucardSerialNumber,
                              sRestuarentInfoDescription: result.sRestuarentInfoSlogan,
                              sRestuarentPhone: result.sRestuarentPhone,
                              sRestuarentAddress: result.sRestuarentAddress,
                              iZipcode: result.iRestuarentZipcode,
                              sCity: result.sRestuarentCityname,
                              sRestuarentOpenningHoursToday: result.sRestuarentOpenningHoursToday,
                              openNow: result.openNow,
                              sRestuarentTakeAwayHoursToday: result.sRestuarentTakeAwayHoursToday,
                              takeOutNow: result.takeOutNow
                          };
                          //Load template and show
                          var template = $('#restuarentinfo_admin').html();
                          var html = Mustache.to_html(template, restuarent);
                          $('.RestaurantInfo').html(html);
                          
                          //Get restuarent info from database opening hours
                          $("#MenuName").val(result.sRestuarentName);
                          $("#MenuName").focus();

                          $("#MenuSubName").val(result.sRestuarentInfoSlogan);
                          $("#MenuAdress").val(result.sRestuarentAddress);
                          $("#MenuZip").val(result.iRestuarentZipcode);
                          $("#MenuTown").val(result.sRestuarentCityname);
                          $("#currentQRcode").append('<img src='+result.sRestuarentInfoQRcode+'>');
                          
                          /*
                          $("#MenuTown").val(MenuTown);
                          */

                          $("#MenuPhone").val(result.sRestuarentPhone);

                      });
                      

                      //Show the menucardinfo
                      $("#mustache_template").load( "mustache_templates/menucardinfo_admin.html",function(){

                          var menucardinfo = {
                              info: [],
                              openinghours: [],
                              takeawayhours: []
                          };

                          //Foreach menucardinfo insert into the menucarcardinfo
                          $.each(result.aMenucardInfo, function(key,value){                                                        
                              var obj = {                                 
                                  headline: value.sMenucardInfoHeadline,
                                  text: value.sMenucardInfoParagraph
                              };
                              //Append the obj to the menucardinfo obj
                              menucardinfo.info.push(obj);
                          });

                          //Foreach OpeningHours insert into the menucarcardinfo
                          $.each(result.aMenucardOpeningHours, function(key,value){
                              if(value.iClosed === '0') {
                              var obj = {
                                  sDayName: value.sDayName,
                                  iTime: value.iTimeFrom+'-'+value.iTimeTo

                              };
                              }else if (value.iClosed === '1') {
                                 var obj = {
                                  sDayName: value.sDayName,
                                  iTime: 'Lukket i dag'

                              }; 
                              }
                              //Set opening hours
                              $('[name="Day'+value.iTimeCounter+'"] option[value="'+value.iTimeFromId+'"]').attr('selected', 'selected');
                              $('[name="Day'+value.iTimeCounter+'_'+value.iTimeCounter+'"] option[value="'+value.iTimeToId+'"]').attr('selected', 'selected');
                              //Set if closed
                              if(value.iClosed === '1') {
                                  $('#Day'+value.iTimeCounter+'_Closed').attr('checked','checked');
                              }
                              //Append the obj to the openinghours obj
                              menucardinfo.openinghours.push(obj);
                          });

                          /*Foreach TakeAwayHours insert into the menucarcardinfo
                          $.each(result.aMenucardTakeAwayHours, function(key,value){
                              var obj = {
                                  sDayName: value.sDayName,
                                  iTimeFrom: value.iTimeFrom,
                                  iTimeTo: value.iTimeTo
                              };
                              //Append the obj to the takeawayhours obj
                              menucardinfo.takeawayhours.push(obj);
                          });*/ 

                          var template = $('#menucardinfo_admin').html();
                          var html = Mustache.to_html(template, menucardinfo);                       
                          $('#restuarantInfo').html(html);
                                                  
                          //Linebreak hotfix. Replace \n with <br/> tags
                          $('#linebreakhotfix').html($('#linebreakhotfix').html().replace(/\r?\n/g, '<br/>'));                         
                      });

                      //Show the menucard categories and items
                      $("#mustache_template").load( "mustache_templates/menucard_admin.html",function(){

                          var menucards = {
                              menucard: [],
                              iMenucardIdHashed: result.iMenucardIdHashed //This will only work when the user has one menucard.
                          };
                          
                          //Foreach menucard insert into the menucarcardinfo
                          $.each(result.aMenucardCategory, function(key,value){

                              //alert('liste index: '+key);
                              var category = {
                                  sMenucardCategoryName: value.sMenucardCategoryName,
                                  sMenucardCategoryDescription: value.sMenucardCategoryDescription,
                                  iMenucardCategoryIdHashed: value.iMenucardCategoryIdHashed,
                                  items:[]
                              };                                                       

                              //Get all the items and the values name,desc,number,price
                              //Check for items
                              if(typeof result['aMenucardCategoryItems'+key] !== "undefined") {                             
                                $.each(result['aMenucardCategoryItems'+key].sMenucardItemName, function(keyItem,value){

                                    var sMenucardItemName = value;
                                    var sMenucardItemDescription = result['aMenucardCategoryItems'+key].sMenucardItemDescription[keyItem];
                                    var sMenucardItemNumber = result['aMenucardCategoryItems'+key].sMenucardItemNumber[keyItem];
                                    var iMenucardItemPrice = result['aMenucardCategoryItems'+key].iMenucardItemPrice[keyItem];
                                    if(iMenucardItemPrice !== ''){
                                        var havePrice = true;
                                    } else {
                                        havePrice = '';
                                    }
                                    var iMenucardItemIdHashed = result['aMenucardCategoryItems'+key].iMenucardItemIdHashed[keyItem];
                                    var iMenucardItemPlaceInList = result['aMenucardCategoryItems'+key].iMenucardItemPlaceInList[keyItem];

                                    var item = {
                                        sMenucardItemName: sMenucardItemName,
                                        sMenucardItemDescription: sMenucardItemDescription,
                                        sMenucardItemNumber: sMenucardItemNumber,
                                        iMenucardItemPrice: iMenucardItemPrice,
                                        havePrice: havePrice,
                                        iMenucardItemIdHashed: iMenucardItemIdHashed,
                                        iMenucardItemPlaceInList: iMenucardItemPlaceInList
                                    };

                                    //Append the item to the items in the category obj
                                    category.items.push(item);
                                });                            
                              }

                              //Append the category obj to the menucard obj
                              menucards.menucard.push(category);

                          });

                          var template = $('#menucard_admin').html();
                          var html = Mustache.to_html(template, menucards);
                          $('#restuarantInfo').after(html);
                          
                          //Function to initiate all sortable lists 
                          UpdateSortableLists();                                                    
                      });
                }else{
                    
                    $('#restuarantInfo').html('Der kunne ikke findes noget menukort');
                }
             });
            
        }else{

            //Clear the menucard area
            $('.sortableList').remove();

            //Use viewmenucard.php
            var iMenucardSerialNumber = getUrlVars()["iMenucardSerialNumber"];
            //solve æøå problem in IE encodeURIComponent();

            //Get data            
            $.ajax({
              type: "GET",
              url: "API/api.php",
              dataType: "json",
              data: {sFunction:"GetMenucardWithSerialNumber",iMenucardSerialNumber:iMenucardSerialNumber}
             }).done(function(result){
                 if(result.result === true){

                      //Load the template restuarentinfo_viewmenucard.html into viewmenucard.php
                      $("#mustache_template").load( "mustache_templates/restuarentinfo_viewmenucard.html",function(){

                          var restuarent = {
                              sRestuarentName: result.sRestuarentName,
                              sRestuarentInfoDescription: result.sRestuarentSlogan,
                              sRestuarentPhone: result.sRestuarentPhone,
                              sRestuarentAddress: result.sRestuarentAddress,
                              sRestuarentOpenningHoursToday: result.sRestuarentOpenningHoursToday,
                              openNow: result.openNow,
                              sRestuarentTakeAwayHoursToday: result.sRestuarentTakeAwayHoursToday,
                              takeOutNow: result.takeOutNow
                          };
                          //Load template and show
                          var template = $('#restuarentinfo_viewmenucard').html();
                          var html = Mustache.to_html(template, restuarent);
                          $('.RestaurantInfo').html(html);

                      });

                      //Show the menucardinfo
                      $("#mustache_template").load( "mustache_templates/menucardinfo_viewmenucard.html",function(){

                          var menucardinfo = {
                              info: [],
                              openinghours: [],
                              takeawayhours: []
                          };

                          //Foreach menucardinfo insert into the menucarcardinfo
                          $.each(result.aMenucardInfo, function(key,value){
                              var obj = {
                                  headline: value.sMenucardInfoHeadline,
                                  text: value.sMenucardInfoParagraph
                              };
                              //Append the obj to the menucardinfo obj
                              menucardinfo.info.push(obj);
                          });

                          //Foreach OpeningHours insert into the menucarcardinfo
                          $.each(result.aMenucardOpeningHours, function(key,value){
                              var obj = {
                                  sDayName: value.sDayName,
                                  iTimeFrom: value.iTimeFrom,
                                  iTimeTo: value.iTimeTo
                              };

                              //Append the obj to the openinghours obj
                              menucardinfo.openinghours.push(obj);
                          });

//                          //Foreach TakeAwayHours insert into the menucarcardinfo
//                          $.each(result.aMenucardTakeAwayHours, function(key,value){
//                              var obj = {
//                                  sDayName: value.sDayName,
//                                  iTimeFrom: value.iTimeFrom,
//                                  iTimeTo: value.iTimeTo
//                              };
//                              //Append the obj to the takeawayhours obj
//                              menucardinfo.takeawayhours.push(obj);
//                          }); 

                          var template = $('#menucardinfo_viewmenucard').html();
                          var html = Mustache.to_html(template, menucardinfo);
                          $('#restuarantInfo').html(html);
                      });

                      //Show the menucard categories and items
                      $("#mustache_template").load( "mustache_templates/menucard_viewmenucard.html",function(){

                          var menucards = {
                              menucard: []
                          };

                          //Foreach menucard insert into the menucarcardinfo
                          $.each(result.aMenucardCategory, function(key,value){

                              //alert('liste index: '+key);
                              var category = {
                                  sMenucardCategoryName: value.sMenucardCategoryName,
                                  sMenucardCategoryDescription: value.sMenucardCategoryDescription,
                                  items:[]
                              };                                                       

                              //Get all the items and the values name,desc,number,price
                              $.each(result['aMenucardCategoryItems'+key].sMenucardItemName, function(keyItem,value){

                                  var sMenucardItemName = value;
                                  var sMenucardItemDescription = result['aMenucardCategoryItems'+key].sMenucardItemDescription[keyItem];
                                  var sMenucardItemNumber = result['aMenucardCategoryItems'+key].sMenucardItemNumber[keyItem];
                                  var iMenucardItemPrice = result['aMenucardCategoryItems'+key].iMenucardItemPrice[keyItem];

                                  var item = {
                                      sMenucardItemName: sMenucardItemName,
                                      sMenucardItemDescription: sMenucardItemDescription,
                                      sMenucardItemNumber: sMenucardItemNumber,
                                      iMenucardItemPrice: iMenucardItemPrice
                                  };

                                  //Append the item to the items in the category obj
                                  category.items.push(item);
                              });

                              //Append the category obj to the menucard obj
                              menucards.menucard.push(category);

                          });

                          //Format for menucard 
                          /*
                           var menucards = {
                              menucard: [{sMenucardCategoryName: "Kategorinavn",sMenucardCategoryDescription: "Beskrivelse 1",
                                          items : [{sMenucardItemNumber:"11",
                                          sMenucardItemName: "navnet",
                                          sMenucardItemDescription: "beskrivelse",
                                          iMenucardItemPrice: "14"},
                                          {sMenucardItemNumber:"22",
                                          sMenucardItemName: "navnet 2",
                                          sMenucardItemDescription: "beskrivelse 2",
                                          iMenucardItemPrice: "234"}
                                          ]
                                          },
                                          {sMenucardCategoryName: "Kategorinavn 2",sMenucardCategoryDescription: "Beskrivelse 2",
                                          items : [{sMenucardItemNumber:"33",
                                          sMenucardItemName: "navnet 33",
                                          sMenucardItemDescription: "beskrivelse 33",
                                          iMenucardItemPrice: "14"},
                                          {sMenucardItemNumber:"44",
                                          sMenucardItemName: "navnet 44",
                                          sMenucardItemDescription: "beskrivelse 44",
                                          iMenucardItemPrice: "234"}
                                          ]
                                          }      
                              ]
                          };
                          */

                          var template = $('#menucard_viewmenucard').html();
                          var html = Mustache.to_html(template, menucards);
                          $('#restuarantInfo').after(html);
                      });                      
                }else{
                    
                    $('#restuarantInfo').html('Der kunne ikke findes noget menukort');
                }
             });

             

        }
  }  
  /* GetMenucard function end*/
  




  
  function HideShowSwitch(CaseName) {
     
     switch(CaseName)
     {
//        case 'PopUpWindowEditManuInfo':
//            $("#EditRestaurantInfo").animate({height: 'toggle'},200);
//            break;
        
       case 'HideSortableEdits':
            
            $(".menuWrapper").hide();
            $("#TabWrappersMenu").show();
            $(".Tab").removeClass("On");
            $("#TabsMenu").addClass("On");
            //$('#EditMenuButton').text('');
            //$('#EditMenuButton').append('<div class="buttonEdit Save" onclick="UpdateMenucard();">✓ Gem menukort</div>');
            $(".DishEditWrapper").slideDown(100);
            $(".AddLiButton").slideDown(100);
            $(".newsortablediv").css('display','inline-table').slideDown(100);
            
            break;
            
        case 'Login':
            $("#LoginBox").animate({width: 'toggle'},100);
            $("#LoginEmail").focus();
            break;
            
        case 'Email':
            $('.EmailSubmission').remove();
            var mail = $('#sEmailToSubmit').val();
            if(validateEmail(mail))
            {   
                AddNewUser(mail);
            }else{
                $('#sEmailToSubmit').after('<div class="EmailSubmission"><h1>Ikke en korrekt Email</h1></div>');
                $('.EmailSubmission').hide().slideDown(200);
//                setTimeout(function(){$('.EmailSubmission').slideUp(200);},2500);
//                setTimeout(function(){$('.EmailSubmission').remove();},2700);
            }
            break;
     }
}

    function AddNewUser(mail)
    {
       $.ajax({
             type : "GET",
             url : 'API/api.php',
             dataType : 'json',
             data : {sFunction:"AddNewUser",Email:mail}
        }).done(function(result){
            if(result.result === 'true'){
                $('#NewUser').html('');
                var mailhost = mail.split('@')[1];
                $('#NewUser').append('<div class="EmailSubmission"><h1>Sådan!</h1><h3>Vi har sendt en email til <span>'+mail+'</span></h3><h3>med et link til oprettelse af din profil</h3><h3>gå til <a href="http://www.'+mailhost+'">'+mailhost+'</a></h3></div>');
                //Create new account and send email to user
                $('html, body').animate({
                    scrollTop: $(".logo").offset().top
                },0);
            }else{
                $('#sEmailToSubmit').after('<div class="EmailSubmission"><h1>Emailen er allerede i brug</h1><h3>Prøv med en anden email eller log ind nedenfor</h3></div>');
                   $('.EmailSubmission').hide().slideDown(200);
                   $('#sEmailToSubmit').val('');               
            } 
        }); 
    }

    function validateEmail(email) {
        
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(email !== ''){
            if( !emailReg.test(email)) {
              return false;
            } else {
              return true;
            }
        }else{
            return false;
        }
    }

      
//    function getValuesForEditManuInfo(){
//        
//        var MenuName = $('.Restaurant.Name h1').text();
//        $("#MenuName").val(MenuName);
//        $("#MenuName").focus();
//        var MenuSubName = $('.Restaurant.Name h2').text();
//        $("#MenuSubName").val(MenuSubName);
//        var MenuAdress = $('.RestaurantAdresse h4').html();
//        var MenuAdress = MenuAdress.split('<br>');
//        $("#MenuAdress").val(MenuAdress[0]);
//        
//        /*var MenuZip = MenuAdress[1].slice(0,4);
//        $("#MenuZip").val(MenuZip);
//        var MenuTown = MenuAdress[1].slice(5);
//        $("#MenuTown").val(MenuTown);*/
//        
//        var MenuPhone = $('.RestaurantPhone h2').html();
//        $("#MenuPhone").val(MenuPhone);
//        
//        //Get restuarent info from database opening hours
//        
//
//    }

   // register

function registerNext(num) {
//    if($('.validationTag').length != 0 ){
//    }
//    else{
        if(num===0){
            $('.inputFrame.B').hide();
            $('.inputFrame.C').hide();
            $('.inputFrame.A').show();
            var H = $('.inputFrame.A').height();
            $('.inputFrameWrapper').css("height",H+50);
            $('.inputFrame input').eq(2).focus();
        }
         if(num===1){
             
             //Check if password is not empty and is the same
             console.log('repass: '+$('#NewPasswordRetype').val());
             console.log('pass: '+$('#NewPassword').val());
             if($('#NewPasswordRetype').val() === $('#NewPassword').val() && $('#NewPassword').val() !== '' && $('#NewPasswordRetype').val() !== ''){    
                $('.inputFrame.B').show();
                $('.inputFrame.C').hide();
                $('.inputFrame.A').hide();
                $('.inputFrame input').eq(2).focus();             
             }else {
                 //Empty password or not the same
                 $('.validationTag').remove();
                 $('#NewPasswordRetype').before('<div class="validationTag passRe">Koderne er ikke ens</div>');   
             }
         }
         if(num===2){
             
            //Check if all fields are not empty 
            
            if($('#sCompanyName').val() !== '' && $('#iCompanyTelefon').val() !== '' && $('#sCompanyAddress').val() !== '' && $('#iCompanyZipcode').val() !== '' && $('#sRestuarentName').val() !== '' && $('#sRestuarentAddress').val() !== '' && $('#iRestuarentZipcode').val() !== '' && $('#iRestuarentTel').val() !== '') {
            
                $('.inputFrame.B').hide();
                $('.inputFrame.A').hide();
                $('.inputFrame.C').show();
                var H = $('.inputFrame.C').height();
                $('.inputFrameWrapper').css("height",H+50);
            
            }else {
                //All fileds must be field out
                $('.validationTag').remove();
                $('#iRestuarentTel').after('<div class="validationTag">Husk at udfylde alle felter!</div>');  
                
            }
        }
//    }
}

  function makeOpeningHours() {
    $('.Hours.Opening').text('');
    
    
     $.ajax({
             type : "GET",
             url : 'API/api.php',
             dataType : 'json',
             data : {sFunction:"GetOpeningHours"}
        }).done(function(result){
           
           //Load template
           $("#mustache_template").load( "mustache_templates/openinghours_register.html",function(){

                  var hours = {
                      hour: []
                  };
                  
                  $.each(result.Hours, function(key,value){
                              var obj = {
                                  iTimeId: value.iTimeId,
                                  iTime: value.iTime
                                  
                              };
                              //Append the obj
                              hours.hour.push(obj);
                   });
                          
                  var template = $('#openinghours_register').html();               
                  var html = Mustache.to_html(template, hours);
                  $('#OpeningHours').append(html);
           });
           
        });
  
 }


 function GetUserinformation()
 {
     $.ajax({
             type : "GET",
             url : 'API/api.php',
             dataType : 'json',
             data : {sFunction:"GetUserinformation"}
        }).done(function(result){
            if(result.result === true)
            {
                $('#sUsername').val(result.sUsername);
                
                $('#sCompanyName').val(result.sCompanyName);
                $('#iCompanyTelefon').val(result.sCompanyPhone);
                $('#sCompanyAddress').val(result.sCompanyAddress);
                $('#iCompanyZipcode').val(result.sCompanyZipcode);
                $('#sCompanyCVR').val(result.sCompanyCVR);
            }
        });
 }
 
 function UpdateUserinformation()
 {
     
     var aData = {};
     
     //aData['sUsername'] = $('#sUsername').val();               
     aData['sCompanyName'] = $('#sCompanyName').val();
     aData['sCompanyPhone'] = $('#iCompanyTelefon').val();
     aData['sCompanyAddress'] = $('#sCompanyAddress').val();
     aData['sCompanyZipcode'] = $('#iCompanyZipcode').val();
     aData['sCompanyCVR'] = $('#sCompanyCVR').val();
     
     //Workaround with encoding issue in IE8 and JSON.stringify
     for (var i in aData) {
             aData[i] = encodeURIComponent(aData[i]);
     }
    
     var sJSON = JSON.stringify(aData);
     
     $.ajax({
            type : "GET",
            dataType : "json",
            url : 'API/api.php',
            data : { sFunction:"UpdateUserinformation",sJSON:sJSON},
            complete: function() {}
        }).done(function(result){

                if(result.result === true)
                {
                    //show update is done
                    alertSucces();
                }
                else
                {
                    alert('Der er sket en fejl - prøv venlist igen');
                }
        });
 }

//  function makeTakeAwayHours(status) {
//
//    if(status == 0 ){
//        $('#TakAwayNo').toggleClass('prev').toggleClass('Clicked') ;
//        if($('#TakAwayYes').hasClass('Clicked')){ $('#TakAwayYes').removeClass('Clicked').addClass('prev'); }
//        $('.Hours.TakeAway').slideUp(200);
//    }
//    if(status == 1 ){
//        $('#TakAwayYes').toggleClass('prev').toggleClass('Clicked');
//        if($('#TakAwayNo').hasClass('Clicked')){
//            $('#TakAwayNo').removeClass('Clicked').addClass('prev'); 
//        }
//        if( $('.Hours.TakeAway').is(':empty') ){
//            $('.Hours.TakeAway').append('<p>Man:</p><select  class="Hours" id=""><option value = "0">01:00</option></select><p> til </p>');
//        }
//        $('.Hours.TakeAway').slideDown(200);
//    }
//}

function ValidateRegSwitch(CaseName,id){
    
    switch(CaseName)
     {
        case 'password':
            $('.validationTag.pass').remove();
            $('.validationTagImg.pass').remove();
            var pass = $(id).val();
            if(pass.length <= 5 ){
                $(id).before('<div class="validationTag pass">Din kode skal være 6 tegn eller derover.</div>');
            }
        break;
        
        case 'passwordRetype':
            $('.validationTag.passRe').remove();
            $('.validationTagImg.passRe').remove();
            var passRe = $(id).val();
            if(passRe !== $('#NewPassword').val() ){
                console.log('Retype');
                $(id).before('<div class="validationTag passRe">Koderne er ikke ens</div>');
            }
        break;
        
        case 'zipcode':
            $('.validationTag.zipcode').remove();
            $('.validationTagImg.zipcode').remove();
            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
            var zipcode = $(id).val();
            if(zipcode.length <=3 || intRegex.test(zipcode) === false || floatRegex.test(zipcode) === false ){
                $(id).before('<div class="validationTag zipcode">Ikke Korrekt Postnummer</div>');
            }
        break;
        
        case 'phone':
            $('.validationTag.phone').remove();
            $('.validationTagImg.phone').remove();
            var phone = $(id).val();
            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
            if( phone.length <=7 || intRegex.test(phone) === false || floatRegex.test(phone) === false  ){
                $(id).before('<div class="validationTag phone">Ikke Korrekt Telefonnummer</div>');
            }
        break;
        
        case 'MustFill':
            $('.validationTag.MustFill').remove();
            $('.validationTagImg.MustFill').remove();
            var pass = $(id).val();
            if(pass.length < 1 ){
                $(id).before('<div class="validationTag MustFill">Skal udfyldes</div>');
            }
        break;  
     }
 }
 
 
function SubmitFormRegister(){
    
        //Encrypt password with jsEncrypt
        var pubKey = "-----BEGIN PUBLIC KEY-----\r\nMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA4jCNEY3ZyZbhNksbKG+l\r\n+LX9fIEiLkrRy9roGTKJnr2TEuZ28qvwRKeFbAs0wpMUS5\/8hF+Fte2Qywqq9ARG\r\nRNzTcDxjz72VRwTf1tSTKAJUsHYLKbBWPsvZ8FWk9EzJqltdj1mYVKMWcm7Ham5g\r\nwydozgnI3VbX8HMY8EglycKIc43gC+liSUmloWHGCnfKrfSEQ2cuIjnupvodvFw6\r\n5dAanLu+FRuL6hnvt7huxXz5+wbPI5\/aFGWUIHUbHoDFOag8BhVaDjXCrjWt3ry3\r\noFkheO87swYfSmQg4tHM\/2keCrsdHAk2z\/eCuYcbksnmNgTqWgcSHNGM+nq9ngz\/\r\nxXeb1UT+KxBy7K86oCD0a67eDzGvu3XxxW5N3+vvKJnfL6xT0EWTYw9Lczqhl9lp\r\nUdCgrcYe45pRHCqiPGtlYIBCT5lqVZi9zncWmglzl2Fc4fhjwKiK1DH7MSRBO8ut\r\nlgawBFkCprdsmapioTRLOHFRAylSGUiyqYg0NqMuQc5fMRiVPw8Lq3WeAWMAl8pa\r\nksAQHYAoFoX1L+4YkajSVvD5+jQIt3JFUKHngaGoIWnQXPQupmJpdOGMCCu7giiy\r\n0GeCYrSVT8BCXMb4UwIr\/nAziIOMiK87WAwJKysRoZH7daK26qoqpylJ00MMwFMP\r\nvtrpazOcbKmvyjE+Gg\/ckzMCAwEAAQ==\r\n-----END PUBLIC KEY-----";

        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubKey);
        var encrypted = encrypt.encrypt($('#NewPassword').val());
        
        var aData = {};
        
        aData['sCompanyName'] = $('#sCompanyName').val();
        aData['iCompanyTelefon'] = $('#iCompanyTelefon').val();
        aData['sCompanyAddress'] = $('#sCompanyAddress').val();
        aData['iCompanyZipcode'] = $('#iCompanyZipcode').val();
        aData['sCompanyCVR'] = $('#sCompanyCVR').val();
        
        aData['sRestuarentName'] = $('#sRestuarentName').val();
        aData['sRestuarentSlogan'] = $('#sRestuarentSlogan').val();
        aData['sRestuarentAddress'] = $('#sRestuarentAddress').val();
        aData['iRestuarentZipcode'] = $('#iRestuarentZipcode').val();
        aData['iRestuarentTel'] = $('#iRestuarentTel').val();

        //Get the Openinghours monday-sunday 
        aData['iMondayTimeFrom'] = $("#iMondayTimeFrom option:selected").val();
        aData['iMondayTimeTo'] = $("#iMondayTimeTo option:selected").val();
        aData['iThuesdayTimeFrom'] = $("#iThuesdayTimeFrom option:selected").val();   
        aData['iThuesdayTimeTo'] = $("#iThuesdayTimeTo option:selected").val();
        aData['iWednesdaysTimeFrom'] = $("#iWednesdaysTimeFrom option:selected").val();
        aData['iWednesdaysTimeTo'] = $("#iWednesdaysTimeTo option:selected").val();
        aData['iThursdayTimeFrom'] = $("#iThursdayTimeFrom option:selected").val();
        aData['iThursdayTimeTo'] = $("#iThursdayTimeTo option:selected").val();
        aData['iFridayTimeFrom'] = $("#iFridayTimeFrom option:selected").val();
        aData['iFridayTimeTo'] = $("#iFridayTimeTo option:selected").val();
        aData['iSaturdayTimeFrom'] = $("#iSaturdayTimeFrom option:selected").val();
        aData['iSaturdayTimeTo'] = $("#iSaturdayTimeTo option:selected").val();
        aData['iSundayTimeFrom'] = $("#iSundayTimeFrom option:selected").val();
        aData['iSundayTimeTo'] = $("#iSundayTimeTo option:selected").val();
        
        if($("#Day1_Closed").is(':checked')){aData['iMondayClosed'] = 1;}else{aData['iMondayClosed'] = 0;}
        if($("#Day2_Closed").is(':checked')){aData['iThuesdayClosed'] = 1;}else{aData['iThuesdayClosed'] = 0;}
        if($("#Day3_Closed").is(':checked')){aData['iWednesdaysClosed'] = 1;}else{aData['iWednesdaysClosed'] = 0;}
        if($("#Day4_Closed").is(':checked')){aData['iThursdayClosed'] = 1;}else{aData['iThursdayClosed'] = 0;}
        if($("#Day5_Closed").is(':checked')){aData['iFridayClosed'] = 1;}else{aData['iFridayClosed'] = 0;}
        if($("#Day6_Closed").is(':checked')){aData['iSaturdayClosed'] = 1;}else{aData['iSaturdayClosed'] = 0;}
        if($("#Day7_Closed").is(':checked')){aData['iSundayClosed'] = 1;}else{aData['iSundayClosed'] = 0;}
        
        //Workaround with encoding issue in IE8 and JSON.stringify
        for (var i in aData) {
                aData[i] = encodeURIComponent(aData[i]);
        }
        
        //The password should not be encoded
        aData['sPassword'] = encrypted;
        aData['sUserToken'] = $('#sUserToken').val();
        
        var sJSON = JSON.stringify(aData);

        $.ajax({
            type : "GET",
            dataType : "json",
            url : 'API/api.php',
            data : { sFunction:"RegisterNewUser",sJSON:sJSON},
            complete: function() {
                 
            }
        }).done(function(result){
               //alert('Reg. complete: '+result.result);
                if(result.result === true)
                {
                    document.location.href = 'admin';
                }
                else
                {
                    alert('Smid fejl besked');
                }
        });
    
}

    
    // register end
    
    
function SubmitFormNewPasswordNoToken() {
    
    if($('#NewPassword').val() !== '' && $('#NewPasswordRepeat').val() !== '') {
    
    if($('#NewPassword').val() === $('#NewPasswordRepeat').val()){
        
   //Encrypt password with jsEncrypt
    //DO NOT CHANGE code on line below as this is the Public Key
        var pubKey = "-----BEGIN PUBLIC KEY-----\r\nMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA4jCNEY3ZyZbhNksbKG+l\r\n+LX9fIEiLkrRy9roGTKJnr2TEuZ28qvwRKeFbAs0wpMUS5\/8hF+Fte2Qywqq9ARG\r\nRNzTcDxjz72VRwTf1tSTKAJUsHYLKbBWPsvZ8FWk9EzJqltdj1mYVKMWcm7Ham5g\r\nwydozgnI3VbX8HMY8EglycKIc43gC+liSUmloWHGCnfKrfSEQ2cuIjnupvodvFw6\r\n5dAanLu+FRuL6hnvt7huxXz5+wbPI5\/aFGWUIHUbHoDFOag8BhVaDjXCrjWt3ry3\r\noFkheO87swYfSmQg4tHM\/2keCrsdHAk2z\/eCuYcbksnmNgTqWgcSHNGM+nq9ngz\/\r\nxXeb1UT+KxBy7K86oCD0a67eDzGvu3XxxW5N3+vvKJnfL6xT0EWTYw9Lczqhl9lp\r\nUdCgrcYe45pRHCqiPGtlYIBCT5lqVZi9zncWmglzl2Fc4fhjwKiK1DH7MSRBO8ut\r\nlgawBFkCprdsmapioTRLOHFRAylSGUiyqYg0NqMuQc5fMRiVPw8Lq3WeAWMAl8pa\r\nksAQHYAoFoX1L+4YkajSVvD5+jQIt3JFUKHngaGoIWnQXPQupmJpdOGMCCu7giiy\r\n0GeCYrSVT8BCXMb4UwIr\/nAziIOMiK87WAwJKysRoZH7daK26qoqpylJ00MMwFMP\r\nvtrpazOcbKmvyjE+Gg\/ckzMCAwEAAQ==\r\n-----END PUBLIC KEY-----";

        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubKey);
        var encrypted = encrypt.encrypt($('#NewPassword').val());
        
        var aData = {};
        
        //The password should not be encoded
        aData['sPassword'] = encrypted;
        
        var sJSON = JSON.stringify(aData);

        $.ajax({
            type : "GET",
            dataType : "json",
            url : 'API/api.php',
            data : { sFunction:"ResetPasswordNoToken",sJSON:sJSON},
            complete: function() {
                 
            }
        }).done(function(result){
               alert('Password reset: '+result.result);
                if(result.result === true)
                {
                    //document.location.href = 'index.php';
                    $('#NewPassword').val('');
                    $('#NewPasswordRepeat').val('');
                    //show update is done
                    alertSucces();
                }
                else
                {
                    alert('der er desværre sket en fejl');
                }
        }); 
    }else {
        alert('Koderne skal være ens');
    }
    
    }else {
        alert('Begge felter skal udfyldes');
    }
}    
    
function SubmitFormNewPassword(){
    
    //Encrypt password with jsEncrypt
    //DO NOT CHANGE code on line below as this is the Public Key
        var pubKey = "-----BEGIN PUBLIC KEY-----\r\nMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA4jCNEY3ZyZbhNksbKG+l\r\n+LX9fIEiLkrRy9roGTKJnr2TEuZ28qvwRKeFbAs0wpMUS5\/8hF+Fte2Qywqq9ARG\r\nRNzTcDxjz72VRwTf1tSTKAJUsHYLKbBWPsvZ8FWk9EzJqltdj1mYVKMWcm7Ham5g\r\nwydozgnI3VbX8HMY8EglycKIc43gC+liSUmloWHGCnfKrfSEQ2cuIjnupvodvFw6\r\n5dAanLu+FRuL6hnvt7huxXz5+wbPI5\/aFGWUIHUbHoDFOag8BhVaDjXCrjWt3ry3\r\noFkheO87swYfSmQg4tHM\/2keCrsdHAk2z\/eCuYcbksnmNgTqWgcSHNGM+nq9ngz\/\r\nxXeb1UT+KxBy7K86oCD0a67eDzGvu3XxxW5N3+vvKJnfL6xT0EWTYw9Lczqhl9lp\r\nUdCgrcYe45pRHCqiPGtlYIBCT5lqVZi9zncWmglzl2Fc4fhjwKiK1DH7MSRBO8ut\r\nlgawBFkCprdsmapioTRLOHFRAylSGUiyqYg0NqMuQc5fMRiVPw8Lq3WeAWMAl8pa\r\nksAQHYAoFoX1L+4YkajSVvD5+jQIt3JFUKHngaGoIWnQXPQupmJpdOGMCCu7giiy\r\n0GeCYrSVT8BCXMb4UwIr\/nAziIOMiK87WAwJKysRoZH7daK26qoqpylJ00MMwFMP\r\nvtrpazOcbKmvyjE+Gg\/ckzMCAwEAAQ==\r\n-----END PUBLIC KEY-----";

        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubKey);
        var encrypted = encrypt.encrypt($('#NewPassword').val());
        
        var aData = {};
        
        //The password should not be encoded
        aData['sPassword'] = encrypted;
        aData['sUserToken'] = $('#sUserToken').val();
        
        var sJSON = JSON.stringify(aData);

        $.ajax({
            type : "GET",
            dataType : "json",
            url : 'API/api.php',
            data : { sFunction:"ResetPassword",sJSON:sJSON},
            complete: function() {
                 
            }
        }).done(function(result){
               alert('Password reset: '+result.result);
                if(result.result === true)
                {
                    document.location.href = 'admin';
                }
                else
                {
                    alert('Smid fejl besked');
                }
        });
}    

function SendResetPasswordRequest() {
    
    if($('#forgotpassMail').val() !== '') {
        
        if(validateEmail($('#forgotpassMail').val()) === true) {
    
            var aData = {};
            aData['email'] = $('#forgotpassMail').val();
            var sJSON = JSON.stringify(aData);
            
            $.ajax({
                    type : "GET",
                    dataType : "json",
                    url : 'API/api.php',
                    data : { sFunction:"SendResetPasswordRequest",sJSON:sJSON},
                    complete: function() {
                        
                    }
                }).done(function(result){
                        if(result.result === 'true') {
                           alert('Check din mail for link til reset password'); 
                        }
                        else {
                            alert('Din email findes ikke i systemet!');
                        }
                });
               
        }else {
            alert('Email ikke gyldig');
        }
        
    }else {
        alert('Email skal udfyldes');
    }
}

/* Hook for loge link */
function PageChange(pagename){
    
  window.location.href = pagename+'.php';
}
/* end */

/* Submit form */

function SubmitForm(formId)
{
    $( "#"+formId ).submit();
}
/* end */

/* Autocomplete inputs

$(document).ready(function(){
    
  //Get all restuarent names
  
       $.ajax({
             type : "GET",
             url : 'API/api.php',
             dataType : 'json',
             data : {sFunction:"GetRestuarentNames"}
        }).done(function(response){

            $('.autocomplete').autocomplete({
                delay: 150,
                source: function(req, responseFn) {
                    if(req.term.length >= 2){
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp( "^" + re, "i" );
                    var a = $.grep(response.sRestuarentNames, function(item,index){
                        return matcher.test(item);
                    });
                        responseFn( a );
                    }
                }
            }); 
     });
});

 end */

function TapChange(subject) {
    
    if( $(".buttonEdit.Save").length === 0 ) {
    
        $(".Tab").removeClass("On");
        $("#Tab"+subject).addClass("On");
        $(".menuWrapper").hide();
        $("#TabWrapper"+subject).show();
        if( subject === "sMessenger" ) { 
            $("#sMessageHeadline").focus(); 
            $('#sMessageHeadline').autogrow();
            $('#sMessengerTextarea').autogrow();
            // Fill fromdate
            var todayDate = $.datepicker.formatDate('dd-mm-yy', new Date());
            $("#dMessageStart").val(todayDate);
        }
    }
    else{  }
}


function GenerateQRcode() {

   $.ajax({
    type: "GET",
    url: "API/api.php",
    dataType: "json",
    data: {sFunction:"GenerateQRcode"}
   }).done(function(result) 
   {
       $('#currentQRcode').html('');
       $('#currentQRcode').append('<img src="'+result.url+'">');
   });
}

function PrintQRcode() {
    var  w = window.open();
    w.document.write("<style> @media print { img { max-width:40% !important; margin: 0; } } .wrapper { width: 250px; text-align: center; } h2,h3 { margin: 5px 0; } body { font-family: 'HelveticaNeue, 'Helvetica Neue', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; } </style>");
    w.document.write($('#currentQRcode').html());
    w.document.write("<div class='wrapper'><h3>Stemplekort QR kode</h3><h2>"+$('.Restaurant.Name h1').html()+"</h2></div>");
    
    w.print();
    w.close();
}



function GetMessages() {
    
   $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"GetMessages"}
       }).done(function(result) 
       {

          $('#oldMessages').html('');
          $('#currentMessages').html('');

          $.each(result.Messages, function(key,value){
              var date = value.dtMessageDate;
              var yy = date.substring(0,4);
              var mm = date.substring(5,7);
              var dd = date.substring(8,10);
              var h = date.substring(11,13);
              var m = date.substring(14,16);
              var date = dd+"-"+mm+"-"+yy+" "+h+":"+m;

              if( key === 0){
                  $('#currentMessages').append('<div><h1>'+value.sMessageHeadline+'</h1><h3>'+date+'</h3><h2>'+value.sMessageBodyText+'</h2></div>');
              }
              else {
              $('#oldMessages').append('<div><h1>'+value.sMessageHeadline+'</h1><h3>'+date+'</h3><h2>'+value.sMessageBodyText+'</h2></div>');
              }
          });
           
       });
   
}

function SaveMessage() {
    if($("#sMessageHeadline").val() !== "" && $("#sMessengerTextarea").val() !== "" && $('#dMessageEnd').val() !== "" ){
        
       var aData = {};
       
       aData['dMessageStart'] = $('#dMessageStart').val();
       aData['dMessageEnd'] = $('#dMessageEnd').val();
       aData['sMessageHeadnline'] = $('#sMessageHeadline').val(); 
       aData['sMessageBodyText'] = $('#sMessengerTextarea').val();
       
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
           //alert('Besked gemt: '+result.result);
           $('#sMessageHeadline').val(''); 
           $('#sMessengerTextarea').val('');
           GetMessages();
       });
    }
    else {
        $(".Messagepreview").after("<div class='MessageEmpty'>Du skal skrive en besked og en slut dato</div>");
        $(".MessageEmpty").hide().slideDown(200);
        $(".MessageEmpty").delay('1000').slideUp(200, function(){
            $(this).remove();
        });
    }
}


function GetStampcard() {
   
    $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"GetStampcard"}
       }).done(function(result) 
       {
           $('#iStampsgiven').html(result.stampcard.iStampcardNumberOfGivenStamps);
           $('#iMaxStamps').val(result.stampcard.iStampcardMaxStamps);
           $('#stampchart').attr('src',result.stampcard.charturl);
           $('#RedemeCode').html(result.stampcard.iStampcardRedemeCode);
           MakeStampcard(result.stampcard.sStampcardText);
       });
}

function MakeStampcard(sStampcardText) {
   $('#StampEX h4').nextAll().remove();
   var NumStamps = $("#iMaxStamps").val();
   var NumStampsPlusOne = parseInt(NumStamps) + 1;
   $('#StampEX h4').text('Køb '+NumStamps+' '+sStampcardText+' og få den '+NumStampsPlusOne+'. gratis');
   
   for(var i=1; i <= NumStamps; i++) {
       $('#StampEX h4').after("<div class='Stamp'></div>");
       
   }
   
}

function SaveStampcard() {
    
   var aData = {};
   
   aData['iStampcardMaxStamps'] = $('#iMaxStamps').val();
       
   for (var i in aData) {
       aData[i] = encodeURIComponent(aData[i]);
   }

   var sJSON = JSON.stringify(aData);
   
   //Make ajax call
   $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"SaveStampcard",sJSONStampcard:sJSON}
       }).done(function(result) 
       {
           MakeStampcard();
       });
}

function InitiateAutocompleteForRegister() {
     
    $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"GetZipcodesAndCities"}
       }).done(function(result) 
       {
           $("#iRestuarentZipcode").autocomplete({
                delay: 150,
                source: function(req, responseFn) {
                    if(req.term.length >= 1){
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp( "^" + re, "i" );
                    var a = $.grep( result.iZipcode, function(item,index){
                        return matcher.test(item);
                    });
                        responseFn( a );
                    }
                } 
           });
           
           $("#iCompanyZipcode").autocomplete({
                delay: 150,
                source: function(req, responseFn) {
                    if(req.term.length >= 1){
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp( "^" + re, "i" );
                    var a = $.grep( result.iZipcode, function(item,index){
                        return matcher.test(item);
                    });
                        responseFn( a );
                    }
                }
           });
           
       });
}


function InitiateAutocomplete() {
    
    //Initiate the auto complete for zipcode
    $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"GetZipcodesAndCities"}
       }).done(function(result) 
       {
           
           
           
           $( "#iCompanyZipcode" ).autocomplete({
                delay: 150,
                source: function(req, responseFn) {
                    if(req.term.length >= 1){
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp( "^" + re, "i" );
                    var a = $.grep( result.iZipcode, function(item,index){
                        return matcher.test(item);
                    });
                        responseFn( a );
                    }
                }
           });
           
           $( "#MenuZip" ).autocomplete({
                delay: 150,
                source: function(req, responseFn) {
                    if(req.term.length >= 1){
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp( "^" + re, "i" );
                    var a = $.grep( result.iZipcode, function(item,index){
                        return matcher.test(item);
                    });
                        responseFn( a );
                    }
                },
                select: function (event, ui) {
                    //alert('select: '+ui.item.value);
                    var iZipcode = ui.item.value;
                    //Get cityname
                     $.ajax({
                        type: "GET",
                        url: "API/api.php",
                        dataType: "json",
                        data: {sFunction:"GetCityname",iZipcode:iZipcode}
                       }).done(function(result) {
                           $( "#MenuTown" ).val(result);
                       });
                }
           });
           
           $( "#MenuTown" ).autocomplete({
                delay: 150,
                source: function(req, responseFn) {
                    if(req.term.length >= 2){
                    var re = $.ui.autocomplete.escapeRegex(req.term);
                    var matcher = new RegExp( "^" + re, "i" );
                    var a = $.grep( result.sCityname, function(item,index){
                        return matcher.test(item);
                    });
                        responseFn( a );
                    }
                },
                select: function (event, ui) {
                    //alert('select: '+ui.item.value);
                    //Get zipcode 
                    //TODO: Find out what to do with Frederiksberg C, København C, København K, København V, Odense C, Ringsted, Aalborg, Århus C. The same city have multiple zipcodes 
                    
                    var sCityname = ui.item.value; 
                    $.ajax({
                        type: "GET",
                        url: "API/api.php",
                        dataType: "json",
                        data: {sFunction:"GetZipcode",sCityname:sCityname}
                       }).done(function(result) {
                           $( "#MenuZip" ).val(result);
                       });
                }
           });
           
       });
    
}

function UpdateRedemeCode() {
    
    var sRedemeCode = $('#RedemeCode1').val() + $('#RedemeCode2').val() + $('#RedemeCode3').val() + $('#RedemeCode4').val(); 
    $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"UpdateRedemeCode",sRedemeCode:sRedemeCode}
       }).done(function(result) {
           if(result.result === 'true') {
                alert('Stempelkort kode er blevet opdateret');
                $('#RedemeCode').html(sRedemeCode);
                $('#RedemeCode1').val('');
                $('#RedemeCode2').val('');
                $('#RedemeCode3').val('');
                $('#RedemeCode4').val('');
           }
       }); 
}


function UpdateStampcardText() {
    
    var sStampcardtext = $('#sStampcardText').val(); 
    $.ajax({
        type: "GET",
        url: "API/api.php",
        dataType: "json",
        data: {sFunction:"UpdateStampcardText",sStampcardtext:sStampcardtext}
       }).done(function(result) {
           if(result.result === 'true') {
                alert('Stempelkort tekst er blevet opdateret');
                //Set the new text frontend
                var text1 = parseInt($('#iMaxStamps').val())+1;
                text1 = text1+'.';
                var text = 'Køb '+$('#iMaxStamps').val()+' '+$('#sStampcardText').val()+' og få den '+text1+' gratis';
                $('#.StampEX h4').html(text);
           }
       }); 
}


$('#sStampcardText').keyup(function() {
    
    //Set the new text
    var text1 = parseInt($('#iMaxStamps').val()) + 1;
    text1 = text1+'.';
    var text = 'Køb '+$('#iMaxStamps').val()+' '+this.value+' og få den '+text1+' gratis';
    $('#sStampcardTextExample').html(text);
    
});

//Disabled/enable select input types
$("input[name='checkbox_closed']").live('click', function(){
 //Get ID 
 var id = $(this).attr('id').substring(0,4);
 var number  = id.charAt(3);
 //Disable select boxes
 
 //If not disabled then disabled it
 if ($("select[name='"+id+'_'+number+"']").is(':disabled')){
     
     $("select[name='"+id+'_'+number+"']").attr("disabled", false); 
     $("select[name='"+id+"']").attr("disabled", false);     
 }else{
     $("select[name='"+id+'_'+number+"']").attr("disabled", "disabled"); 
     $("select[name='"+id+"']").attr("disabled", "disabled"); 
 }
 });

 // image upload
 var imagetemloate = false;
 function InitFileManeger() {

     var uploadbox = document.getElementById("drop_image_here");

     uploadbox.addEventListener("drop", drop, false);
     uploadbox.addEventListener("dragenter", dragEnter, false);
     uploadbox.addEventListener("dragover", dragOver, false);
     uploadbox.addEventListener("dragleave", dragLeave, false);


     document.getElementById("custum_crop_resizer").addEventListener("dragstart", f_dragstart);
     document.getElementById("custum_crop_resizer").addEventListener("drag", f_dragmove);

     document.getElementById("custum_crop_resizer_hivimig").addEventListener("dragstart", r_dragstart);
     document.getElementById("custum_crop_resizer_hivimig").addEventListener("drag", r_dragmove)


     var MessageImage = document.getElementById('MessageImage');
     MessageImage.addEventListener("drop", AddImageToImageDrop, false);
     MessageImage.addEventListener("dragenter", AddImageToImageDragEnter, false);
     MessageImage.addEventListener("dragover", AddImageToImageDragOver, false);
     MessageImage.addEventListener("dragleave", AddImageToImageDragLeave, false);
     MessageImage.addEventListener("click", function (e) {
         if (e.target.id != "MessageImageRemove") {
             alert("vælg fra bib")
         }
     }, false);
     $("#MessageImageRemove").click(function () {
         FjernPrewievImage();
     });

     jQuery.get('mustache_templates/imageupload_uploaded_images.txt', function (data) {
         imagetemloate = data;
         HentMinBilleder();
     });
     $('#uploadBtn').change(function (e) {
         var filer = [];
         for (var i = 0; i < e.target.files.length; i++) {

             filer.push(e.target.files[i].name);

         }
         $('#uploadFile').html(filer.join(', '));

         if(filer.length == 0) {
             $('#uploadFile').html('Fil(er) ej valgt, klik for at vælg fil');

         }

         delete filer;
     });
     $('#toggleImageButton').click(function () {
        $('#upload_inner').slideToggle();
     });
 }
 function HentMinBilleder() {
     $.ajax({
         type: "GET",
         url: "API/api.php",
         dataType: "json",
         data: {sFunction:"GetUsersImageLibrary"}
     }).done(function(result)
     {
         $('#mit_billede_biblotek').html(Mustache.to_html(imagetemloate, result));
     });
 }

 function FjernPrewievImage() {
     $("#MessageImageRemove").fadeOut(150);
     $("#MessageImage").css({"backgroundImage": "", "height": "auto"}).data('url', '');

 }


 function dragEnter(e) {
     $("#drop_image_here").addClass("uploadhover");
     e.stopPropagation();
     e.preventDefault();
 }

 function dragOver(e) {
     e.stopPropagation();
     e.preventDefault();
 }
 function dragLeave(e) {
     $("#drop_image_here").removeClass("uploadhover");
     e.stopPropagation();
     e.preventDefault();
 }
 function drop(e) {
     e.stopPropagation();
     e.preventDefault();
     $("#drop_image_here").removeClass("uploadhover");
     /** @namespace e.dataTransfer.files */
     var filer = e.target.files || e.dataTransfer.files;

     if (filer.length > 0) {

         beforeUpload(filer);
     }
 }
 function uploadFraKnap() {
     var filer = document.getElementById('uploadBtn').files;

     if (filer.length != 0) {
         beforeUpload(filer);
     }

     document.getElementById('uploadBtn').value = null

 }
 var regespForTestImage = new RegExp("^image/");

 function beforeUpload(files) {
     $('#uploadFile').html('Fil(er) ej valgt, klik for at vælg fil');

     var nyefiler = [];
     var filer = [];
     for (var i = 0; i < files.length; i++) {
         if(regespForTestImage.test(files[i].type)){
            nyefiler.push(files[i]);
            filer.push(files[i].name);
         }else {
             filer.push(files[i].name+" er ikke et billede")
         }
     }
     files = nyefiler;


     if (files.length > 0) {

         $('#upload_in_progress').html('<p>Uploadding ...</p><p>' + filer.join(', <br> ') + '</p>');
         upload(files, function (file) { });
     } else {
         $('#upload_in_progress').html('<p>' + filer.join(', ') + '</p>');

     }
 }



 function upload(files, done) {
     var formobject = new FormData();
     formobject.append('file[]', files[0]);
     formobject.append('sFunction', 'UploadImage');

     var oldfilelist = files;
     files = [];
     for (var i = 1; i < oldfilelist.length; i++) {
         files.push(oldfilelist[i])
     }


     $.ajax({
         type: "POST",
         url: "API/api.php",
         dataType: "json",
         data: formobject,

         async: false,
         cache: false,
         contentType: false,
         processData: false

     }).done(function (result) {
         if (result.result) {
             // dette bliver kort hvis billede bliver uploadet med succes
             $('#mit_billede_biblotek').prepend(Mustache.to_html(imagetemloate, result))
         } else {
             // dette bliver koret hvis billede ikke bliver uploaded
             if (result.toSmall) {
                 alert("Dette billede er ikke stort nok");
             } else {
                 alert("fejl")
             }

         }



         var filer = [];
         for (var i = 0; i < files.length; i++) {

             filer.push(files[i].name);

         }

         $('#upload_in_progress').html('<p>Uploadding ...</p><p>' + filer.join(', <br> ') + '</p>');
         if (files.length > 0) {
             // todo skal set timeout fjernes?
             setTimeout(function () {
             // koe upload igen hvis der er flere billeder der skal uploades
                upload(files, function () {
                });
             }, 250);
         }else {
             // ryd upload_in_progress diven
             $('#upload_in_progress').html('');

             done(result.images.n)
         }
     });

 }


 function deleteImage(id, url) {
    if(confirm("Er du sikker på at du vil slette dette billede?")) {
        var sel = "[data-imageid="+id+"]";
        var sel2 = "[data-imageid="+id+"] .retogsletimage";
        $(sel).css("opacity", 0.5);
        $(sel2).hide();

        if ($("#MessageImage").data('url') == url) {
            FjernPrewievImage();
        }

        $.ajax({
            type: "GET",
            url: "API/api.php",
            dataType: "json",
            data: {sFunction:"DeleteImage",imageid:id}
        }).done(function(result) {

            if(result.result) {
                $(sel).animate({opacity: 0}, 500).slideUp(500);
            }else {
                $(sel).css("opacity", 1);
                $(sel2).show();
            }


            delete sel;
            delete sel2;

        });
    }

}

var eiditimageVariable = {
    "open":false,
    "width":0,
    "height":0,
    "id":null,
    "functions":[],
    "customCropNowPosistions":{
        "top":0,
        "left":0,
        "height":0,
        "width":0
    },
    "drag_pos":{
        "mouseX": 0,
        "mouseY": 0


    }
};
function editImage(id, imageUrl){
    var newImg = new Image();
    newImg.onload = function() {
        eiditimageVariable.open = true;
        eiditimageVariable.height = newImg.naturalHeight;
        eiditimageVariable.width = newImg.naturalWidth;
        eiditimageVariable.id = id;

        document.getElementById('imageAreaImageOuter').innerHTML = "";
        newImg.id = "imageSrc";
        document.getElementById('imageAreaImageOuter').appendChild( newImg );

        $('#imageEidterSave').addClass("disable");
        $('#mageEidterAmlToolBar').show();
        $('#mageEidterCropToolBar').hide();
        $('#custum_crop_resizer').hide();
        $('#custum_crop_resizer_hivimig').hide();


        $("#imageEidter").fadeIn(100);
        resizeEidtImage();
    };
    newImg.src = "imgmsg/"+imageUrl;
}
 function editImageSaveImage(){
     $("#imageEidter").fadeOut(100);


     $.ajax({
         type: "GET",
         url: "API/api.php",
         dataType: "json",
         data: {sFunction:"SaveEidtImage", imageId: eiditimageVariable.id, functions: eiditimageVariable.functions }
     }).done(function(result)
     {
         $('#mit_billede_biblotek').prepend(Mustache.to_html(imagetemloate, result));

         eiditimageVariable.open = false;
         eiditimageVariable.height = 0;
         eiditimageVariable.width = 0;
         eiditimageVariable.id = null;
         eiditimageVariable.functions = [];

     });

 }
function editImageUpdate(){
    var newImg = new Image();
    newImg.onload = function() {
        eiditimageVariable.height = newImg.naturalHeight;
        eiditimageVariable.width = newImg.naturalWidth;


        document.getElementById('imageAreaImageOuter').innerHTML = "";
        newImg.id = "imageSrc";
        document.getElementById('imageAreaImageOuter').appendChild( newImg );

        $('#imageEidterSave').removeClass("disable");


        resizeEidtImage()
        setTimeout(function(){
            resizeEidtImage()
        }, 25)
    };

    newImg.src = "API/api.php?sFunction=PreviewImage&imageId="+eiditimageVariable.id+"&"+$.param({functions:eiditimageVariable.functions});
}
function lukMaaskeImageEidter(e){
    if(e.target.id == "imageEidter"){
        if(eiditimageVariable.functions.length == 0){
            lukImageEidter();
        }else {
            if(confirm("Du har ikke gemt dine rettelser.\n\nVil du forsætte med at lukke?")){
                lukImageEidter();
            }
        }

    }
}
function lukImageEidter(e){
    eiditimageVariable.open = false;
    eiditimageVariable.height = 0;
    eiditimageVariable.width = 0;
    eiditimageVariable.id = null;
    eiditimageVariable.functions = [];
    $("#imageEidter").fadeOut(100);
}
function editImageSetupCrop(){
    if((eiditimageVariable.width*0.9)>700 && (eiditimageVariable.height*0.9)>300){
        $('#mageEidterAmlToolBar').hide();
        $('#mageEidterCropToolBar').show();

        $('#custum_crop_resizer').css({"top":"5%", "left":"5%", "height":"90%", "width":"90%", "display":"block"});
        eiditimageVariable.customCropNowPosistions.height = 90;
        eiditimageVariable.customCropNowPosistions.width = 90;
        eiditimageVariable.customCropNowPosistions.top = 5;
        eiditimageVariable.customCropNowPosistions.left = 5;

        $('#custum_crop_resizer_hivimig').css(
            {
                "top": "95%",
                "left": "95%",
                "display": "block"
            }
        );
    }else{
        alert("Dette billede er ikke stort nok til at blive beskæret")
    }
}
 function editImageSaveCrop() {

     $('#mageEidterAmlToolBar').show();
     $('#mageEidterCropToolBar').hide();
     $('#custum_crop_resizer').hide();
     $('#custum_crop_resizer_hivimig').hide();

     eiditimageVariable.functions.push(
         'crop-' + parseFloat(document.getElementById("custum_crop_resizer").style.left) + '-' +
         parseFloat(document.getElementById("custum_crop_resizer").style.top) + '-' +
         parseFloat(document.getElementById("custum_crop_resizer").style.width) + '-' +
         parseFloat(document.getElementById("custum_crop_resizer").style.height)
     );
     editImageUpdate()
 }

 function editImageCancelCrop() {
     $('#mageEidterAmlToolBar').show();
     $('#mageEidterCropToolBar').hide();
     $('#custum_crop_resizer').hide();
     $('#custum_crop_resizer_hivimig').hide();

 }
function set_hiv_i_mig() {
    $('#custum_crop_resizer_hivimig').css(
        {
            "top": (parseFloat(document.getElementById('custum_crop_resizer').style.height) + parseFloat(document.getElementById('custum_crop_resizer').style.top)) + "%",
            "left": (parseFloat(document.getElementById('custum_crop_resizer').style.width) + parseFloat(document.getElementById('custum_crop_resizer').style.left)) + "%",
            "display": "block"
        }
    );
}


 function r_dragstart(e) {
     eiditimageVariable.drag_pos.mouseX = e.clientX;
     eiditimageVariable.drag_pos.mouseY = e.clientY;


     eiditimageVariable.customCropNowPosistions.width = parseFloat(document.getElementById("custum_crop_resizer").style.width);
     eiditimageVariable.customCropNowPosistions.height = parseFloat(document.getElementById("custum_crop_resizer").style.height);
     eiditimageVariable.customCropNowPosistions.top = parseFloat(document.getElementById("custum_crop_resizer").style.top);
     eiditimageVariable.customCropNowPosistions.left = parseFloat(document.getElementById("custum_crop_resizer").style.left);


 }
 function r_dragmove(e) {
     e.preventDefault();
     var new_drag_pos_x = e.clientX;
     var new_drag_pos_y = e.clientY;
     var forskelX_percent = (new_drag_pos_x - eiditimageVariable.drag_pos.mouseX)/$('#imageSrc').width();
     var forskelY_percent = (new_drag_pos_y - eiditimageVariable.drag_pos.mouseY)/$('#imageSrc').height();
     if (forskelX_percent > 0) {
         if ( (eiditimageVariable.customCropNowPosistions.width+(forskelX_percent*100)+eiditimageVariable.customCropNowPosistions.left)<100 ) {
             $('#custum_crop_resizer').css({ "width":(eiditimageVariable.customCropNowPosistions.width+(forskelX_percent*100))+"%"});
             set_hiv_i_mig();
         }
     } else if (forskelX_percent < 0) {
         if ( (((eiditimageVariable.customCropNowPosistions.width-(Math.abs(forskelX_percent)*100))/100)*eiditimageVariable.width) > 700 ) {
             $('#custum_crop_resizer').css({ "width":(eiditimageVariable.customCropNowPosistions.width+(forskelX_percent*100))+"%"});
             set_hiv_i_mig();
         }
     }

     if (forskelY_percent > 0) {
         if ( (eiditimageVariable.customCropNowPosistions.height+(forskelY_percent*100)+eiditimageVariable.customCropNowPosistions.top)<100 ) {
             $('#custum_crop_resizer').css({ "height":(eiditimageVariable.customCropNowPosistions.height+(forskelY_percent*100))+"%"});

             set_hiv_i_mig();
         }
     } else if (forskelY_percent < 0) {
         if ( (((eiditimageVariable.customCropNowPosistions.height-(Math.abs(forskelY_percent)*100))/100)*eiditimageVariable.height) > 300 ) {
             $('#custum_crop_resizer').css({ "height":(eiditimageVariable.customCropNowPosistions.height+(forskelY_percent*100))+"%"});
             set_hiv_i_mig();
         }
     }

     delete new_drag_pos_x;
     delete new_drag_pos_y;
     delete forskelX_percent;
     delete forskelY_percent;




 }
 function f_dragstart(e) {
     eiditimageVariable.drag_pos.mouseX = e.clientX;
     eiditimageVariable.drag_pos.mouseY = e.clientY;
     eiditimageVariable.customCropNowPosistions.width = parseFloat(document.getElementById("custum_crop_resizer").style.width);
     eiditimageVariable.customCropNowPosistions.height = parseFloat(document.getElementById("custum_crop_resizer").style.height);
     eiditimageVariable.customCropNowPosistions.top = parseFloat(document.getElementById("custum_crop_resizer").style.top);
     eiditimageVariable.customCropNowPosistions.left = parseFloat(document.getElementById("custum_crop_resizer").style.left);

 }
 function f_dragmove(e) {
     e.preventDefault();
     var new_drag_pos_x = e.clientX;
     var new_drag_pos_y = e.clientY;
     var forskelX_percent = (new_drag_pos_x - eiditimageVariable.drag_pos.mouseX)/$('#imageSrc').width();
     var forskelY_percent = (new_drag_pos_y - eiditimageVariable.drag_pos.mouseY)/$('#imageSrc').height();
    if (forskelX_percent > 0) {
         if (eiditimageVariable.customCropNowPosistions.left+eiditimageVariable.customCropNowPosistions.width+(forskelX_percent*100)<100) {
             document.getElementById("custum_crop_resizer").style.left = eiditimageVariable.customCropNowPosistions.left+(Math.abs(forskelX_percent)*100) + "%";
             set_hiv_i_mig();
         }
     } else if (forskelX_percent < 0) {
         if (Math.abs(forskelX_percent)*100<eiditimageVariable.customCropNowPosistions.left) {
             document.getElementById("custum_crop_resizer").style.left = eiditimageVariable.customCropNowPosistions.left-(Math.abs(forskelX_percent)*100)+"%";
             set_hiv_i_mig();
         }
     }
     if (forskelY_percent > 0) {
         if (eiditimageVariable.customCropNowPosistions.top+eiditimageVariable.customCropNowPosistions.height+(forskelY_percent*100)<100) {
             document.getElementById("custum_crop_resizer").style.top = eiditimageVariable.customCropNowPosistions.top+(Math.abs(forskelY_percent)*100) + "%";
             set_hiv_i_mig();
         }
     } else if (forskelY_percent < 0) {
         // op
         if (Math.abs(forskelY_percent)*100<eiditimageVariable.customCropNowPosistions.top) {
             document.getElementById("custum_crop_resizer").style.top = eiditimageVariable.customCropNowPosistions.top-(Math.abs(forskelY_percent)*100)+"%";
             set_hiv_i_mig();
         }
     }
 }





 $( window ).resize(function() {
     resizeEidtImage();
 });

function resizeEidtImage(){
    if(eiditimageVariable.open){

        var newHeight = 0;
        if(eiditimageVariable.width>window.innerWidth-60) {
            $('#imageEidterInner').width(window.innerWidth-60);
            newHeight = ((window.innerWidth - 60) / eiditimageVariable.width) * eiditimageVariable.height;
        }else{
            $('#imageEidterInner').width(eiditimageVariable.width);
            newHeight = eiditimageVariable.height;
        }

        if(newHeight>window.innerHeight-60-$('#toolLine').height()  ) {
            // alt for hoj
            $('#imageEidterInner').width(eiditimageVariable.width * ((window.innerHeight-60-$('#toolLine').height()) / eiditimageVariable.height));

        }
        $("#imageEidterInner").css("marginTop",(window.innerHeight-$('#imageEidterInner').height())/2);


        $("#imageArea").height($("#imageSrc").height());
        delete newHeight;
    }
}
function editImageSortHvid(){
    eiditimageVariable.functions.push('sortHvid');
    editImageUpdate();
}
function editImageRotate(vej) {
    if(vej == "Halv" || (eiditimageVariable.height>699 && eiditimageVariable.width>299)) {
        eiditimageVariable.functions.push('rotate'+vej);
        editImageUpdate()
    }else {
        alert("Dette billede er ikke stort nok det at blive flippet op på siden, det kan kun flippes en halv omagang");
    }

}

 var MessageFinishImageAspect = {
     max: 1.42857142857,
     min: 0.42857142857
 };
function PutImageInPreviewBox(url) {
    var newImg = new Image();
    newImg.onload = function() {
        var neturalAspect = newImg.naturalHeight / newImg.naturalWidth;
        var contWidth = $("#MessageImage").width();
        var newHeight = 0;

        if (neturalAspect < MessageFinishImageAspect.min) {
            newHeight = contWidth * MessageFinishImageAspect.min;
        } else if (neturalAspect > MessageFinishImageAspect.max) {
            newHeight = contWidth * MessageFinishImageAspect.max;
        } else {
            newHeight = contWidth * neturalAspect;
        }


        $("#MessageImage").css({"backgroundImage": "url('" + newImg.src + "')"}).data('url', url).animate({"height": newHeight + "px"}, 1000)
        $("#MessageImageRemove").fadeIn(150)



    };
    newImg.src = "imgmsg/"+url;
}


function AddImageToImageDrop(e){
    e.stopPropagation();
    e.preventDefault();


    $("#MessageImage").removeClass("uploadhover");

    var filer = e.target.files || e.dataTransfer.files;



    if(filer.length == 0){
        if( e.dataTransfer.getData('imageId') && e.dataTransfer.getData('imageSrc') ){
            PutImageInPreviewBox( e.dataTransfer.getData('imageSrc') );
        }else {
            alert("Det er ikke et billede du har slippet")
        }

    }else if(filer.length == 1){
        var files = [filer[0]];
        upload(files, function (file) {
            PutImageInPreviewBox(file);
        });
    }else{
        alert("Du kan kun uploader et billede af gangenn");
    }



}
function AddImageToImageDragEnter(e){
    e.stopPropagation();
    e.preventDefault();



}
function AddImageToImageDragOver(e){
    e.stopPropagation();
    e.preventDefault();

    $("#MessageImage").addClass("uploadhover");
}
function AddImageToImageDragLeave(e){
    e.stopPropagation();
    e.preventDefault();

    $("#MessageImage").removeClass("uploadhover");
}
function AddImageToImageDragStart(ev){
    if(ev.target.className == "imageInList") {
        ev.dataTransfer.setData( 'imageId', ev.target.attributes['data-imageid'].value );
        ev.dataTransfer.setData( 'imageSrc', ev.target.attributes['data-imagesrc'].value );
    }

}



















