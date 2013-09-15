<!doctype html>
 
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>jQuery UI Sortable - Connect lists</title>
  <link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css" />
  <link rel="stylesheet" href="css/general.css" />
  <script src="js/jquery-1.7.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/general.js"></script>
</head>
<body>
<div style="height:800px; width: 960px; margin: 0 auto;" id="wrapper">
    <div style="margin-top: 10px;">
        <input type="button" value="Lav ny liste" onclick="CreateNewSortableList();">
        <input type="button" value="Gem lister" onclick="SaveSortableLists();">
    </div>
    <div class="sortablediv">
        <h3>Liste 1</h3>
        <ul id="sortable1" class="connectedSortable">
          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 1</li>
          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 2</li>
          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 3</li>
          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 4</li>
          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 5</li>
          <li onclick="CreateNewLiInSortableList('sortable1')" class="AddLiButton ui-state-default non-dragable">Tilføj nyt li</li>
        </ul>
    </div> 
</div>
      <script>
        $(document).ready(function() {
            //Function to initiate all sortable lists 
            UpdateSortableLists(); 
            
        });  
    </script>
</body>
</html>