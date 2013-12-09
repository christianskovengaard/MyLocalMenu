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
      $('.sortablediv:last').after('<div class="sortablediv newplaceholder sortableList"></div>');
      $('.newplaceholder').append('<h3><input type="text" onkeydown="if (event.keyCode == 13) { SaveMenuListHeadlineToHtml(\''+id+'\');}" placeholder="Overskrift"></h3>');
      $('.newplaceholder h3 input').focus();
      $('.newplaceholder').append('<h4><input type="text" onkeydown="if (event.keyCode == 13) { SaveMenuListHeadlineToHtml(\''+id+'\');}" placeholder="evt ekstra info"></h4>');
      $('.newplaceholder').append('<div class="DishEditWrapper"><div class="moveDish"><img src="img/moveIcon.png"></div><div class="EditDish" onclick="EditListHeadline(this)"><img src="img/edit.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div></div>');
      $('.DishEditWrapper').hide();
      $('.newplaceholder').append('<ul id="'+id+'" class="connectedSortable"></ul>');
      $('#'+id).append('<li class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelNewMenuList(this);"> Annuller</a><a class="saveMenuDishButton" onclick="SaveMenuListHeadlineToHtml(\''+id+'\');">✓ Updater</a></li>');
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
    $('.sortableLiTEMP').append('<div class="DishWrapper DishWrapperTEMP"></div>');
    $('.sortableLiTEMP').removeClass('sortableLiTEMP');
    
    $('.DishWrapperTEMP').append('<div class="DishNumber"><input type="text" maxlength="4" placeholder="nr"></div>');
    $('.DishWrapperTEMP').append('<div class="DishText"><div class="DishHeadline"><input type="text" placeholder="Overskrift"></div><div class="DishDescription"><textarea rows="1" placeholder="Beskrivelse"></textarea></div></div>');
    $('.DishWrapperTEMP').append('<div class="DishPrice"><h2>...</h2><input type="text" onkeydown="if (event.keyCode == 13) { SaveMenuDishToHtml();}" placeholder="0"><h2>kr</h2></div>');
    $('.DishWrapperTEMP').append('<div class="DishEditWrapper DishEditWrapperTEMP"><div class="moveDish"><img src="img/moveIcon.png"></div><div class="EditDish" onclick="EditSortableList(this)"><img src="img/edit.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div></div>');
    $('.DishWrapperTEMP').hide().slideDown();
    $('.DishWrapperTEMP').removeClass('DishWrapperTEMP');

    $('.DishNumber input').focus();
    
    $('.DishWrapper input').autoGrowInput();
    $('.DishDescription textarea').autogrow();
    
    $('.EditDish').hide();
    $('.AddLiButton').hide();
    $('.newsortablediv').hide();
    $('.newsortabledivbuffer').css('display', 'inline-block');
    $('#'+id+' .AddLiButton').before('<li class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelNewMenuDish();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveMenuDishToHtml();">✓ Updater</a></li>');
  }
  
  function CreateNewDivresturanatInfo() {
    $('.AddLiButton.info').before('<div Class="InfoSlide new"><input type="text" placeholder="Overskrift"><textarea rows="1" onkeyup="InputAutoheigth(this);" placeholder="Valgfri tekst"></textarea></div>');
    
    
    $('.InfoSlide.new textarea').autogrow();
    
    $('.InfoSlide.new input').focus();
    
    $('.AddLiButton').hide();
    $('.newsortablediv').hide();
    $('.newsortabledivbuffer').css('display', 'inline-block');
    $('.AddLiButton.info').before('<div class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelNewMenuDish();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveInfoToHtml();">✓ Updater</a></div>');
    $('.EditDish').hide();
      
  }
  
  function SaveMenuDishToHtml() {
      var Number = $('.DishNumber input').val();
      var Headline = $('.DishHeadline input').val();
      var Description = $('.DishDescription textarea').val();
      var price = $('.DishPrice input').val();
      
      if(Number != ''  && Headline != '' && price !=''){
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
          
          $('.DishEditWrapperTEMP').removeClass('DishEditWrapperTEMP');
      }
      
      else{
          alert("udfyld venlist et nummer, en overskrift og en pris");
      }
}
 
  function SaveInfoToHtml(){
     
      var infoHeadline = $('.InfoSlide.new input').val();
      var infoDescription = $('.InfoSlide.new textarea').val();
      
      if(infoHeadline != ''  && infoDescription != ''){
          
          $('.InfoSlide.new').before('<div Class="InfoSlide"><h1>'+infoHeadline+'</h1><h2>'+infoDescription+'</h2><div class="DishEditWrapper"><div class="EditDish" onclick="EditInfo(this)"><img src="img/edit.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div></div></div>');
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

      if(listHeadline != ''){
          
          $('.sortablediv h3 input').parent().html(listHeadline);
          $('.sortablediv h4 input').parent().html(listDescription);
          

          $('.SaveMenuDish').fadeOut('normal', function(){ 

              $(this).before('<li onclick="CreateNewLiInSortableList(\''+id+'\')" class="AddLiButton non-dragable"><h5>+</h5></li>');
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
              
          });
          $('.DishEditWrapper').show();
          $('.EditDish').show();
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          
      }
      else{
          alert("udfyld venlist en overskrift");
      }    
 }
 
   function SaveEditedMenuListHeadlineToHtml(id){
      var listHeadline = $('.sortablediv h3 input').val();
      var listDescription = $('.sortablediv h4 input').val();

      if(listHeadline != ''){
          
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
          
      }
      else{
          alert("udfyld venlist en overskrift");
      }    
 }
 
 function SaveEditedInfoToHtml(id){
      var Headline = $('.InfoSlide input').val();
      var Description = $('.InfoSlide textarea').val();

      if(Headline != '' && Description !=''){
          
          $('.InfoSlide input').parent().html('<h1>'+Headline+'</h1>');
          $('.InfoSlide textarea').parent().html('<h2>'+Description+'</h2>');
          

          $('.SaveMenuDish').fadeOut('normal', function(){ 
              $(this).remove();
              $('.AddLiButton').fadeIn('fast');
              
          });
          $('.DishEditWrapper').show();
          $('.EditDish').show();
          $('.newsortablediv').fadeIn();
          $('.newsortabledivbuffer').hide();
          
      }
      else{
          alert("udfyld venlist begge felter");
      }    
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
      var text = $(elem).find('.DishHeadline').text();
      if (confirm('Dette vil slette: '+text)) 
      {
          $(elem).remove();
      }
  }
  
  function DeleteSortableList(id)
  {
      var text = $(id).parent().parent().find('h3').text();
      if (confirm('Dette vil slette: '+text+' og alle menupunkter ?')) {
          
          $(id).parent().parent().remove();
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
    dish.closest('.DishWrapper').after('<li class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelEditMenuDish();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveMenuDishToHtml();">✓ Updater</a></li>');
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
          
          headline.html('<h3><input id="headEditHeadline" type=text value="'+headlineText+'"></h3>');
          if( descriptionText == "" ){
            description.html('<h4><input id="HeadEditDescription" type=text placeholder="evt ekstra info"></h4>');
          }
          else{
              description.html('<h4><input id="HeadEditDescription" type=text value="'+descriptionText+'"></h4>');
          }
                    
          $('.EditDish').hide();
          
          $('.AddLiButton').hide();
          $('.newsortablediv').hide();
          $('.newsortabledivbuffer').css('display', 'inline-block');
          $(id).parent().after('<div class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelEditHeadline();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveEditedMenuListHeadlineToHtml(this);">✓ Updater</a></div>');
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
          var descriptionText = description.text();
          
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
          $(id).parent().after('<div class="SaveMenuDish"><a class="saveMenuDishButton Cancel" onclick="CancelEditMenuinfo();"> Annuller</a><a class="saveMenuDishButton" onclick="SaveEditedInfoToHtml(this);">✓ Updater</a></div>');
}

   function CancelEditMenuinfo(){
       $('#InfoEditHeadline').parent().html(sessionStorage.headlineInfo);
       $('#InfoEditDescription').parent().html(sessionStorage.descriptionInfo);
       
       $('.EditDish').fadeIn();
       $('.SaveMenuDish').fadeOut();
       $('.newsortablediv').fadeIn();
   }

  function SaveSortableLists()
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
          //iId
          aList['iId'] = $(this).attr('id');          
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
           console.log('result: '+result.result);
       });
       
  }
  
  /* Sortable list functions end */



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
            //Use admin.php
            //TODO: Get data show with mustache templates
            
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
                              sRestuarentInfoDescription: "Felt mangler",
                              sRestuarentPhone: result.sRestuarentPhone,
                              sRestuarentAddress: result.sRestuarentAddress,
                              sRestuarentOpenningHoursToday: result.sRestuarentOpenningHoursToday,
                              sRestuarentTakeAwayHoursToday: result.sRestuarentTakeAwayHoursToday
                          };
                          //Load template and show
                          var template = $('#restuarentinfo_viewmenucard').html();
                          var html = Mustache.to_html(template, restuarent);
                          $('.RestaurantInfo').html(html);

                      });

                      //Show the menucardinfo //TODO: Get the openinig hours and takeaway hours
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

                          //Foreach TakeAwayHours insert into the menucarcardinfo
                          $.each(result.aMenucardTakeAwayHours, function(key,value){
                              var obj = {
                                  sDayName: value.sDayName,
                                  iTimeFrom: value.iTimeFrom,
                                  iTimeTo: value.iTimeTo
                              };
                              //Append the obj to the takeawayhours obj
                              menucardinfo.takeawayhours.push(obj);
                          }); 

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
        case 'PopUpWindowEditManuInfo':
            $("#EditRestaurantInfo").animate({height: 'toggle'},200);
            getValuesForEditManuInfo();
            break;
        case 'HideSortableEdits':
            
            $('#EditMenuButton').text('');
            $('#EditMenuButton').append('<div class="buttonEdit Save" onclick="SaveSortableLists();">✓ Gem menukort</div>')
            $(".DishEditWrapper").slideDown(100);
            $(".AddLiButton").slideDown(100);
            $(".newsortablediv").css('display','inline-table').slideDown(100);
            
            break;
        case 'Login':
            $("#LoginBox").animate({width: 'toggle'},100);
            $("#LoginEmail").focus();
            break;
        case 'Email':
            var mail = $('#sEmailToSubmit').val();
            var mailhost = mail.split('@')[1];
            $('.info02 .wrapper ').append('<div class="EmailSubmission"><h1>Velkommen</h1><h3>Vi har sent en email til <span>'+mail+'</span></h3><h3>med et link til hvor du opretter dit menukort</h3><h3>gå til <a href="http://www.'+mailhost+'">'+mailhost+'</a></h3></div>')
            $('.EmailSubmission').hide().slideDown(100);
            break;
     }
}
   

  function GetMenucardWithSerialNumber()
    {
       
         var iMenucardSerialNumber = $('#iMenucardSerialNumber').val();
         if(iMenucardSerialNumber != '')
         {
             $.ajax({
                type: "GET",
                url: "API/api.php",
                dataType: "json",
                data: {sFunction:"GetMenucardWithSerialNumber",iMenucardSerialNumber:iMenucardSerialNumber}
               }).done(function(result) 
               {
                   console.log('result: '+result.result);
               });
         }
    }
      
    function getValuesForEditManuInfo(){
        
        var MenuName = $('.Restaurant.Name h1').text();
        $("#MenuName").val(MenuName);
        $("#MenuName").focus();
        var MenuSubName = $('.Restaurant.Name h2').text();
        $("#MenuSubName").val(MenuSubName);
        var MenuAdress = $('.RestaurantAdresse h4').html();
        var MenuAdress = MenuAdress.split('<br>');
        $("#MenuAdress").val(MenuAdress[0]);
        var MenuZip = MenuAdress[1].slice(0,4);
        $("#MenuZip").val(MenuZip);
        var MenuTown = MenuAdress[1].slice(5);
        $("#MenuTown").val(MenuTown);
        var MenuPhone = $('.RestaurantPhone h2').text();
        $("#MenuPhone").val(MenuPhone);

    }

   // register

  function registerNext(num) {
    if(num==0){
         $('.info03 .wrapper h3').remove(); 
         $('.info03 .wrapper h1').after('<h3>➊ ➁ ➂</h3>');
         $('.inputFrame.A').css('margin-left','0px');
         var H = $('.inputFrame.A').height();
         $('.inputFrameWrapper').css("height",H+20);
    }
     if(num==1){
         $('.info03 .wrapper h3').remove();
         $('.info03 .wrapper h1').after('<h3>➀ ➋ ➂</h3>');
         $('.inputFrame.A').css('margin-left','-266px');
         var H = $('.inputFrame.B').height();
         $('.inputFrameWrapper').css("height",H+20);
     }
     if(num==2){
        $('.info03 .wrapper h3').remove(); 
        $('.info03 .wrapper h1').after('<h3>➀ ➁ ➌</h3>');
        $('.inputFrame.A').css('margin-left','-532px');
        makeOpeningHours();
        var H = $('.inputFrame.C').height();
        $('.inputFrameWrapper').css("height",H+20);
        
    }
}

  function makeOpeningHours() {
    
    $('.Hours.Opening').append('<p>Man:</p><select  class="Hours" id=""><option value = "0">01:00</option></select><p> til </p><select  class="Hours" id=""><option value = "0">01:00</option></select><div class="button02">lukket</div>');
}

  function makeTakeAwayHours(status) {

    if(status == 0 ){
        $('#TakAwayNo').toggleClass('prev').toggleClass('Clicked') ;
        if($('#TakAwayYes').hasClass('Clicked')){ $('#TakAwayYes').removeClass('Clicked').addClass('prev'); }
        $('.Hours.TakeAway').slideUp(200);
    }
    if(status == 1 ){
        $('#TakAwayYes').toggleClass('prev').toggleClass('Clicked');
        if($('#TakAwayNo').hasClass('Clicked')){
            $('#TakAwayNo').removeClass('Clicked').addClass('prev'); 
        }
        if( $('.Hours.TakeAway').is(':empty') ){
            $('.Hours.TakeAway').append('<p>Man:</p><select  class="Hours" id=""><option value = "0">01:00</option></select><p> til </p>');
        }
        $('.Hours.TakeAway').slideDown(200);
    }
}
    
    // register end
    
    



/* Hook for loge link */
function PageChange(pagename)
{
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
