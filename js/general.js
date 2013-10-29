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
    
    var sNewMenuCardItemLi = document.createElement("li");
    sNewMenuCardItemLi.setAttribute("class","sortableLi");
    
        var sNewMenuCardItemWrapper = document.createElement("div");
        sNewMenuCardItemWrapper.setAttribute("class","DishWrapper");
        sNewMenuCardItemLi.appendChild(sNewMenuCardItemWrapper);
            
            var sNewMenuCardItemNumber = document.createElement("div");
            sNewMenuCardItemNumber.setAttribute("class","DishNumber");
            sNewMenuCardItemWrapper.appendChild(sNewMenuCardItemNumber);
            
                var sNewMenuCardItemNumberText = document.createElement("h1");
                sNewMenuCardItemNumber.appendChild(sNewMenuCardItemNumberText);
                    

                    var sNewMenuCardItemNumberTextNumberPrev = $('ul li .DishNumber').last().text();
                    if(sNewMenuCardItemNumberTextNumberPrev == 0 ){ 
                        
                        
                        
                        var sNewMenuCardItemNumberTextNumberPrev = $('#'+idprev+' .DishNumber').last().text();
                    }
                    
                    var sNewMenuCardItemNumberTextNumberPrev = parseInt(sNewMenuCardItemNumberTextNumberPrev);
                    
                    var sNewMenuCardItemNumberTextNumber = document.createTextNode(sNewMenuCardItemNumberTextNumberPrev+1);
                    sNewMenuCardItemNumberText.appendChild(sNewMenuCardItemNumberTextNumber);           
            
            var sNewMenuCardItemText = document.createElement("div");
            sNewMenuCardItemText.setAttribute("class","DishText");
            sNewMenuCardItemWrapper.appendChild(sNewMenuCardItemText);
            
                var sNewMenuCardItemTextHeadline = document.createElement("div");
                sNewMenuCardItemTextHeadline.setAttribute("class","DishHeadline");
                sNewMenuCardItemText.appendChild(sNewMenuCardItemTextHeadline);
            
                    var sNewMenuCardItemTextHeadlineH1 = document.createElement("h1");
                    sNewMenuCardItemTextHeadline.appendChild(sNewMenuCardItemTextHeadlineH1);

                        var sNewMenuCardItemTextHeadlineText = document.createTextNode('Overskrift');
                        sNewMenuCardItemTextHeadlineH1.appendChild(sNewMenuCardItemTextHeadlineText); 
            
                var sNewMenuCardItemTextDescription = document.createElement("div");
                sNewMenuCardItemTextDescription.setAttribute("class","DishDescription");
                sNewMenuCardItemText.appendChild(sNewMenuCardItemTextDescription);
            
                    var sNewMenuCardItemTextDescriptionH2 = document.createElement("h2");
                    sNewMenuCardItemTextDescription.appendChild(sNewMenuCardItemTextDescriptionH2);

                        var sNewMenuCardItemTextDescriptionText = document.createTextNode('Beskrivelse');
                        sNewMenuCardItemTextDescriptionH2.appendChild(sNewMenuCardItemTextDescriptionText);          
            
            var sNewMenuCardItemPrice = document.createElement("div");
            sNewMenuCardItemPrice.setAttribute("class","DishPrice");
            sNewMenuCardItemWrapper.appendChild(sNewMenuCardItemPrice);
            
                var sNewMenuCardItemPriceH2 = document.createElement("h2");
                sNewMenuCardItemPrice.appendChild(sNewMenuCardItemPriceH2);
                
                    var sNewMenuCardItemPriceH2Text = document.createTextNode('...');
                    sNewMenuCardItemPriceH2.appendChild(sNewMenuCardItemPriceH2Text);
                
                var sNewMenuCardItemPriceH22 = document.createElement("h2");
                sNewMenuCardItemPrice.appendChild(sNewMenuCardItemPriceH22);
                    
                    var sNewMenuCardItemPriceH2Text = document.createTextNode('0');
                    sNewMenuCardItemPriceH22.appendChild(sNewMenuCardItemPriceH2Text);
                
                var sNewMenuCardItemPriceH222 = document.createElement("h2");
                sNewMenuCardItemPrice.appendChild(sNewMenuCardItemPriceH222);   
                
                    var sNewMenuCardItemPriceH2Text = document.createTextNode('kr');
                    sNewMenuCardItemPriceH222.appendChild(sNewMenuCardItemPriceH2Text);
                       
            var sNewMenuCardItemEditWrapper = document.createElement("div");
            sNewMenuCardItemEditWrapper.setAttribute("class","DishEditWrapper");
//            sNewMenuCardItemEditWrapper.setAttribute("style","display: block");
            sNewMenuCardItemWrapper.appendChild(sNewMenuCardItemEditWrapper);
            
                var sNewMenuCardItemEditWrapperMove = document.createElement("div");
                sNewMenuCardItemEditWrapperMove.setAttribute("class","moveDish");
                sNewMenuCardItemEditWrapper.appendChild(sNewMenuCardItemEditWrapperMove);
                    
                    var sNewMenuCardItemEditWrapperMoveImg =  document.createElement("img");
                    sNewMenuCardItemEditWrapperMoveImg.setAttribute("src","img/moveIcon.png");
                    sNewMenuCardItemEditWrapperMove.appendChild(sNewMenuCardItemEditWrapperMoveImg);
                    
                var sNewMenuCardItemEditWrapperDelete = document.createElement("div");
                sNewMenuCardItemEditWrapperDelete.setAttribute("class","DeleteDish");
                sNewMenuCardItemEditWrapperDelete.setAttribute("onclick","DeleteLiSortable(this);");
                sNewMenuCardItemEditWrapper.appendChild(sNewMenuCardItemEditWrapperDelete);
                    
                    var sNewMenuCardItemEditWrapperDelP =  document.createElement("p");
                    sNewMenuCardItemEditWrapperDelete.appendChild(sNewMenuCardItemEditWrapperDelP);
                        
                        var sNewMenuCardItemEditWrapperDelPText = document.createTextNode('╳');
                        sNewMenuCardItemEditWrapperDelP.appendChild(sNewMenuCardItemEditWrapperDelPText);
                        

//      $('#'+id+' .AddLiButton').before('<li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Nyt lis</li>');   
      $('#'+id+' .AddLiButton').before(sNewMenuCardItemLi); 
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
    
 