<?php

        $keyword = "";
        $select = "";
        $distance1 = "";
        $editPlace = "";
        $enEditPlace = "";
        $enKey = "";
        $enSelect = "";
        $enRadius = "";
        $api_key = "AIzaSyDIf8KK0RrwgUeWDCp7xrlZQM7EjBpTdeA";
        $content = null;
       $lat = "34.0266";
       $lon = "-118.2831";

//$new ="";
        
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ); 
        


?>
<?php 
    if (isset($_GET["lat"]) && isset($_GET["lon"])){
    $lat = $_GET["lat"];
    $lon = $_GET["lon"];
      //  echo $lat;
       // exit();
}
?>
<?php
        if($_SERVER["REQUEST_METHOD"]=="POST"||isset($_POST['search']))
        {
            
            $keyword = test_input($_POST["keyword"]);
            $select = test_input($_POST["select"]);
            $editPlace = test_input($_POST["editPlace"]);
            $enEditPlace = urlencode($editPlace);
            $distance1 = test_input($_POST["distance1"]);
            if($distance1 =="") $distance1 = "10";
            
            if($editPlace != ""){
                $urlContent = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$enEditPlace.'&key='.$api_key);
                $jsonFile = json_decode($urlContent);
                $lat = $jsonFile->results[0]->geometry->location->lat;
                $lon = $jsonFile->results[0]->geometry->location->lng;
            }


            $enKey = urlencode($keyword);
            $enSelect = urlencode($select);
            $distanceVal = floatval($distance1)*1609.344;
            if($distanceVal>50000) $distanceVal = 50000;
            $enRadius = urlencode($distanceVal);

            //echo $content;
        }
        
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
?>
<?php
if (isset($_GET["keyzzz"]) && !empty($_GET["keyzzz"])) {
    //$gkey = array();
    $gkey = urlencode($_GET["keyzzz"]);//$new = count();
    $photo = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$gkey.'&key='.$api_key);
    $File = json_decode($photo);
if(array_key_exists('reviews',$File->result)){

    $number2 = count($File->result->reviews);
    
    if($number2>5) $number2 = 5;
    

    for($j=0;$j<$number2;$j++){
        $auname[] = $File->result->reviews[$j]->author_name;
        $profileP[] = $File->result->reviews[$j]->profile_photo_url;
        $reviewt[] = $File->result->reviews[$j]->text;
    }
    $dataN = array(
        "aName" => $auname,
        "profile" => $profileP,
        "review" => $reviewt
    );
}
    else{
        $auname[0]="no";
$dataN = array(
        "aName" => $auname
    );
    }
    
    $data = json_encode($dataN);
    echo $data;
    exit();
}
?>

<?php
if (isset($_GET["key7"]) && !empty($_GET["key7"])) {
    //$gkey = array();
    $gkey = urlencode($_GET["key7"]);//$new = count();
    $photo = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$gkey.'&key='.$api_key);
    $File = json_decode($photo);
    if(array_key_exists('photos',$File->result)){
    $number = count($File->result->photos);
        if($number>5) $number = 5;
        for($i=0;$i<$number;$i++){
        
        $photo_reference[] = $File->result->photos[$i]->photo_reference;
        $file[] = file_get_contents('https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference='.$photo_reference[$i].'&key='.$api_key);
        $nf[] = json_decode($file[$i]);
        $path[] = '/home/scf-28/yunshen/apache2/htdocs/'.$i.'.png';
        $store = file_put_contents($path[$i],$file[$i]);
    }}
    else 
//if($path==null) 
        $path[0]="no";
    $dataN2 = array(
        "photos" => $path
    );
    $data2 = json_encode($dataN2);
    echo $data2;
    exit();
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <meta name="Generator" content="Cocoa HTML Writer"/>
        <meta name="CocoaVersion" content="1561.2"/>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
        <script>
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET","http://ip-api.com/json",false);
            xmlhttp.send();
            jsonObj=JSON.parse(xmlhttp.responseText);
            root = jsonObj.documentElement;
            //var zzzz = jsonObj;
            console.log(jsonObj);
            var latz = jsonObj.lat;
            console.log(latz);
            var lonz = jsonObj.lon;
            console.log(lonz);
            var aja = new XMLHttpRequest();
            aja.open("GET","place.php?lat="+latz+"&lon="+lonz,false);
            aja.send();
            //var zz = aja.responseText;
            //console.log(zz);
        </script>
        
        <style type="text/css">
            #mode{
            font-family: serif;
            font-size: 17px;
            background-color: rgb(235,235,235);
            text-align: center;
        }
            .center{
                margin: auto;
            }
            #floating-panel{
                position: absolute;
            }
            
            .abc
            {
            border: 1px;
            MARGIN-RIGHT: auto;
            MARGIN-LEFT: auto;
            width: 700px;
            height: 200px;
            border-style: solid;
            border-color: rgb(193, 193, 193);
            border-width: 3px;
            background-color: rgb(250, 250, 250);
            font-weight: bold;
            }
            .Result {
            border-collapse: collapse;
            MARGIN-RIGHT: auto;
            MARGIN-LEFT: auto;
            width: 80%;
            margin-top: 30px;
            border: 1px solid black;
            }
            .Result td, th {
            border: 1px solid black;
            }
            th{
                height: 30px;
            }
            #map {
            height: 250px;
            width: 400px;
            background-color: darkgray;
            margin-left: 100px;
            cursor: pointer;
            display: block;
            transition: left .5s ease-in, top .5s ease-in;
            position: relative;

            }
            .nor{
                background-color: rgb(250,250,250);
            }
            .title {
            margin-top: 2%;
            letter-spacing: 1px;
            text-align: center;
            font-size: 35px;
            font-weight: 400;
            font-family: serif;
            font-style: italic;
        }
            .two{
                text-align: center;
            }

            a:link {
                text-decoration:none;
                color: black;
            }
            a:active{
                color: gainsboro;
            }
            #circle{
                border-radius: 50%;
                width: 50px;
                height: 50px;
            }
            .dropdown {
                position: relative;
                display: inline-block;
            }
            .dropdown-content {
                display: none;
                position: absolute;
}
            .dropdown:hover .dropdown-content {
                display: block;
            }
            .HHH{
                
                text-align: center;
                font-weight: bold;
            }
            .lll{
                border-collapse: collapse;
                margin: auto;
            }
            #Response{
                margin: auto;
                text-align: center;
            }
            #table1{
                display: none;
            }
            #table2{
                display: none;
            }
            #under{
                position: absolute;
            }
            #upp{
                position: absolute;
                display: none;
            }
            

        </style>
    </head>
    
    <body>
        <div class="center">
        <table class = 'abc'>
            <tr class = "title"><td colspan="2">Travel and Entertainment Search</td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <form method="post" action="">
            <tr>
                <td>
                Keyword<input type="text" name="keyword" id="textType" value='' required>
                </td>
            </tr>
            <tr><td>
                Category<select id="Select" name="select">
                <option value="default">default</option>
                <option value="cafe">cafe</option>
                <option value="bakery">bakery</option>
                <option value="restaurant">restaurant</option>
                <option value="beauty salon">beauty salon</option>
                <option value="casine">casine</option>
                <option value="movie theater">moive theater</option>
                <option value="lodging">lodging</option>
                <option value="airport">airport</option>
                <option value="train station">train station</option>
                <option value="subway station">subway station</option>
                <option value="bus station">bus station</option>
                </select>
                </td>
            </tr>
            <tr>
                <td>Distance(miles)<input type="text" placeholder="10" name="distance1" id="distance">from
                </td>
                
                <td>
                    <input type="radio" name="distance" id="here" value="here" checked>
            <label for="here">Here</label>
                </tr>
                <tr><td></td><td>
            <input type="radio" name="distance" id="edit" value="blank" onclick="chooseOne()">
            <label><input type="text" placeholder="location" id="editText" name="editPlace"></label>
                </td>
            </tr>
            <tr class="two">
                <td><input type="submit" name="search" value="Search" id="SearchButton" onsubmit="return Search();">
            <input type="reset" name="clear" value="Clear" onclick="Clear()">
                </td>
                </tr>
                
            </form>
            </table>
            </div>
        <div id="Response">
        </div>
        
        
        <script type="text/javascript">
            
            
            
            
            //var getreturn1 = zzzz.responseText;
            //console.log(getreturn1);
            function Clear(){
                document.getElementById("textType").value="";
                //document.getElementById("textType").required=false;
                //document.getElementById("editText").required=false;
                document.getElementById("editText").value="";
                document.getElementById("distance").value="";
                document.getElementById("Select").value="default";
                document.getElementById("edit").disabled=false;
                document.getElementById("here").disabled=false;
                document.getElementById("edit").checked =false;
                document.getElementById("here").checked =true;
                document.getElementById("editText").required=false;
                html_text = "";
                document.getElementById("Response").innerHTML=html_text;
            }
            function chooseOne(){
                if(document.getElementById("edit").checked==true){
                    document.getElementById("editText").required=true;
                    document.getElementById("editText").disabled=false;
                }
                else{
                    document.getElementById("editText").required=false;
                    document.getElementById("editText").disabled=true;
                }
                    
            }
            
            function Search(){
                document.getElementById("textType").value= "<?php echo $keyword ?>";
                if(document.getElementById("here").checked==true)
                    {
                        document.getElementById("editText").required=false;
                        document.getElementById("edit").disabled=true;
                    }
                else if(document.getElementById("edit").checked==true)
                {
                    document.getElementById("editText").required=true;
                    document.getElementById("here").disabled=true;
                }
                document.getElementById("SearchButton").disabled=true;
            }
            
            a='<?=$keyword?>';
            console.log(a);
                //var jsonnew = getJson();
            <?php 
            if($select=="default") {
                $content = file_get_contents( 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' .$lat. ',' .$lon. '&radius=' .$enRadius. '&keyword=' .$enKey. '&key=' .$api_key);
            }
            else{
            $content = file_get_contents( 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' .$lat. ',' .$lon. '&radius=' .$enRadius. '&type=' .$enSelect. '&keyword=' .$enKey. '&key=' .$api_key);}
        
            ?>
            
            
            
            var jsonnew = <?=$content?>;
            console.log(jsonnew);
            //function showtable(){
                var html_text="";
                
                if(jsonnew.status=="OK")
                {
                root = jsonnew.DocumentElement;
                    html_text = "<table class= 'Result'><tr><th>Category</th><th>Name</th><th>Address</th></tr>";
                Results= jsonnew.results;
                ResultsNode = Results[0];
                //var str = new Array();
                //var ResultsKeys = Object.keys(ResultsNode);
                i = Results.length;
                if(Results.length>20) i = 20;
                
                for(j=0;j<i;j++){
                ResultsNode = Results[j];    
                html_text += "<tr><td><img src = '"+ResultsNode.icon+"' height = '30px' width ='75px'></td><td><a href ='javascript:PandR("+j+")'>"+ResultsNode.name+"</a></td><td><a href='javascript:void(0)' onclick='initMap("+ResultsNode.geometry.location.lat+","+ResultsNode.geometry.location.lng+","+j+")' id = 'linka"+j+"'>"+ResultsNode.vicinity+"</a><div id = 'upp"+j+"' style='display:none;position:absolute;height: 400px' ><div id='map"+j+"'  style='width:400px;height:250px'></div><div id='floating-panel"+j+"' style='height:20px;width:80px;position:absolute;margin-top:-250px'><select id='mode"+j+"' style='font-family:serif;font-size:20px;background-color:rgb(235,235,235);text-align:center;-webkit-appearance:none;-moz-appearance:none'><option value='WALKING'>Walk there</option><option value='BICYCLING'>Bike there</option><option value='DRIVING'>Drive there</option></select></div></div></td></tr>";
                }
                html_text += "</table>";
                //document.getElementById("aaa").innerHTML=results;
                }
                else if(a!='')
                {html_text = "<br><table style='background-color:rgb(250,250,250);width:700px;margin:auto;text-align:center' border='1'><tr><td>No Records has been found</td></tr></table>";
                }
                document.getElementById("Response").innerHTML=html_text;
            
            document.getElementById("SearchButton").disabled=false;
           
           // console.log(aaa);
            //html_text = "<p>"+getreturn+"</p>";
            //document.getElementById("Response").innerHTML=html_text;
            
            
            function PandR(num){
                ResultsNode = Results[num];
                //alert(str);
                var str = ResultsNode.place_id;
                var Name = ResultsNode.name;
                console.log(Name);
                console.log(str);
                var ajax = new XMLHttpRequest();
                ajax.open("GET", "place.php?keyzzz="+str, false);
                ajax.send();
                var getreturn = ajax.responseText;
                console.log(getreturn);
                var ajaxaa = new XMLHttpRequest();
                ajaxaa.open("GET", "place.php?key7="+str, false);
                ajaxaa.send();
                var getreturn1 = ajaxaa.responseText;
                console.log(getreturn);
                
                
                html_text1 = "";
                html_text1 = "<h1>"+Name+"</h1>";
                html_text1 += "<br>";
                html_text1 += "<p>click to show reviews</p>";
                html_text1 += "<img src=http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png width=50px onclick = 'showoff()' id = 'down'>";
                html_text1 += "<br>";
                html_text1 += "<div id = 'table1'><table border='1' width = '700px' class = 'lll'>";
                
                
                     
                     
                
                var newget = JSON.parse(getreturn);
                
                
                //console.log(pic);
                auname = newget.aName;
                Auname = auname[0];
                if(Auname=="no"){
                    html_text1 +="<tr height = '60px'><td class = 'HHH'>No Reviews Found</td></tr>";
                }
                else{
                
                textR = newget.review;
                pro = newget.profile;
                console.log(auname);
                
                TextR = textR[0];
                Pro = pro[0];
                
                console.log(Auname);
                
                for(i=0;i<auname.length;i++){
                    Auname = auname[i];
                    TextR = textR[i];
                    Pro = pro[i];
                    html_text1 += "<tr height = '60px'><td class = 'HHH'><img src='"+Pro+"' id = 'circle'>"+Auname+"</td></tr><tr height = '60px'><td>"+TextR+"</td></tr>";
                    
                }}
                html_text1 += "</table></div><br>";
                html_text1 += "<p>click to show photos</p>";
                html_text1 += "<img src=http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png width=50px onclick= 'showoff1()' id='down1'>";
                html_text1 += "<br>";
                html_text1 += "<div id = 'table2'><table border='1' class = 'lll' width = '700px'>";
                console.log(getreturn1);
                var newg = JSON.parse(getreturn1);
                     pic = newg.photos;
                pics = pic[0];
                console.log(pics);
                if(pics=="no"){
                    html_text1 +="<tr height='60px'><td class = 'HHH'>No Photos Found</td></tr>";
                }
                else{    
                
                for(i=0;i<pic.length;i++){
                    pics = pic[i];
                    html_text1 += "<tr><td class = 'HHH'><img src='http://cs-server.usc.edu:15672/"+i+".png' width = '700px' onclick='piccc("+i+")'></td></tr>";
                }}
                html_text1 += "</table></div>";
                //html_text1 += "<p id = 'aaa'>"+text+"</p>";
                document.getElementById("Response").innerHTML=html_text1;
            }
            
            function piccc(m){
                var URL = 'http://cs-server.usc.edu:15672/'+m+'.png';
                window.open(URL);
            }
            
            function showoff(){
                var pic = document.getElementById('down');
                var tableq = document.getElementById("table1");
                
                if(tableq.style.display == "none"){
                    tableq.style.display = 'inline';
                    pic.src = 'http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png';
                }
                else {
                    tableq.style.display = "none";
                    pic.src = 'http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png';
                     }
                
                
            }
            
            
            function showoff1(){
                var pic1 = document.getElementById('down1');
                var tableq1 = document.getElementById("table2");
                
                
                if(tableq1.style.display == "none"){
                    tableq1.style.display = 'inline'; 
                    pic1.src = 'http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png';
                }
                else {tableq1.style.display = "none";
                      pic1.src = 'http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png';
                     }
            }
            
            
            
            
            function initMap(Num,Num2,z) {
                if(z=="undefined") z=0;
                console.log(z);
                var newId = "linka"+z;
                var ccc = "upp"+z;
                var mappp = "map"+z;
                var moded = "mode"+z;
                console.log(ccc);
                
                var zzz = document.getElementById(newId);
                var mapa = document.getElementById(ccc);
                console.log(mapa);
                if(mapa.style.display=="none"){
                    //mapa.innerHTML = mam;
                    mapa.style.display = '';
                    mapa.style.display = '';
                }
                else mapa.style.display = 'none';
                aaa = Num;
                bbb = Num2;
                ccc = a;
                console.log(aaa);
                console.log(bbb);
                //alert(str);
                //var str1 = ResultsNode.place_id;
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var directionsService = new google.maps.DirectionsService();
        var map = new google.maps.Map(document.getElementById("map"+z), {
          zoom: 14,
          center: {lat: aaa, lng: bbb}
        });
        var marker = new google.maps.Marker({
          position: {lat: aaa, lng: bbb},
          //map: map
        });
        directionsDisplay.setMap(map);
        marker.setMap(map);
        //calculateAndDisplayRoute(directionsService, directionsDisplay,aaa,bbb);
        document.getElementById(moded).addEventListener('change', function() {
        marker.setMap(null);
          calculateAndDisplayRoute(directionsService, directionsDisplay,aaa,bbb,moded);
        });
      }
            function calculateAndDisplayRoute(directionsService, directionsDisplay,p,q,dd) {
                var LAT = p;
                var LNG = q;
                console.log(LAT);
                console.log(LNG);
                console.log(<?=$lat?>);
                console.log(<?=$lon?>);
        var selectedMode = document.getElementById(dd).value;
        directionsService.route({
          origin: {lat: <?=$lat?>, lng: <?=$lon?>},  // Haight.
         //ResultsNode = Results[j];
          destination: {lat: LAT, lng: LNG},  // Ocean Beach.
          // Note that Javascript allows us to access the constant
          // using square brackets and a string value as its
          // "property."
          travelMode: google.maps.TravelMode[selectedMode]
        }, function(response, status) {
          if (status == 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      } 
        </script>
        <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIf8KK0RrwgUeWDCp7xrlZQM7EjBpTdeA&callback=initMap">

    </script>

    </body>
</html>