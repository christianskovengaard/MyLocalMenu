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
    
    <pre class='xdebug-var-dump' dir='ltr'>
<b>array</b> <i>(size=6)</i>
  0 <font color='#888a85'>=&gt;</font> 
    <b>array</b> <i>(size=9)</i>
      0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Liste 1'</font> <i>(length=7)</i>
      1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'sortable1'</font> <i>(length=9)</i>
      2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
      3 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item 1'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      4 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item 2'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      5 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item 3'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      6 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item 4'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      7 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item 5'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      8 <font color='#888a85'>=&gt;</font> <small>int</small> <font color='#4e9a06'>7</font>
  1 <font color='#888a85'>=&gt;</font> 
    <b>array</b> <i>(size=6)</i>
      0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Liste 2'</font> <i>(length=7)</i>
      1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'sortable2'</font> <i>(length=9)</i>
      2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
      3 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item1'</font> <i>(length=5)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      4 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Nyt li'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      5 <font color='#888a85'>=&gt;</font> <small>int</small> <font color='#4e9a06'>4</font>
  2 <font color='#888a85'>=&gt;</font> 
    <b>array</b> <i>(size=7)</i>
      0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Liste 3'</font> <i>(length=7)</i>
      1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'sortable3'</font> <i>(length=9)</i>
      2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
      3 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Item1'</font> <i>(length=5)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      4 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Nyt li'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      5 <font color='#888a85'>=&gt;</font> 
        <b>array</b> <i>(size=4)</i>
          0 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Nyt li'</font> <i>(length=6)</i>
          1 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Id'</font> <i>(length=2)</i>
          2 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Beskrivelse'</font> <i>(length=11)</i>
          3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Prisen'</font> <i>(length=6)</i>
      6 <font color='#888a85'>=&gt;</font> <small>int</small> <font color='#4e9a06'>5</font>
  3 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Menukort navn'</font> <i>(length=13)</i>
  4 <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Menukort beskrivelse'</font> <i>(length=20)</i>
  5 <font color='#888a85'>=&gt;</font> <small>int</small> <font color='#4e9a06'>2</font>
</pre>
</body>
</html>