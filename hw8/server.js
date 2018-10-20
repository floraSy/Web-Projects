var express = require('express');
var request = require('request');
var urlencode = require('urlencode');
const yelp = require('yelp-fusion');
'use strict';
var app = express();
var cors = require('cors');
app.use(cors());
app.use(express.static('public'));
app.all('*',function (req, res, next) {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Headers', 'Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild');
  res.header('Access-Control-Allow-Methods', 'PUT, POST, GET, DELETE, OPTIONS');

  if (req.method == 'OPTIONS') {
    res.send(200);
  }
  else {
    next();
  }
});
 
app.get('/index.html', function (req, res) {
   res.sendFile( "http://www-scf.usc.edu/~yunshen/0704Sy/hw8/index.html" );
})
 
app.get('/input', function (req, res) {
    var api_key = "AIzaSyDIf8KK0RrwgUeWDCp7xrlZQM7EjBpTdeA";
    //console.log(api_key);
    var distance = req.query.distance;
    //console.log(distance);
    if(distance==undefined) distance="10";
    //console.log(distance);
    distance = distance*1609.344;
    //console.log(distance);
    if(distance>50000) distance=50000;
    var radius = urlencode(distance);
    console.log(distance);
    //res.end(distance);
    var keyword = urlencode(req.query.keyword);
    console.log(req.query.select);
    var select = req.query.select;
    var from = req.query.from;
    console.log(from);
    if(from=="0"){
        var lat = urlencode(req.query.lat);
        console.log(lat);
        var lon = urlencode(req.query.lon);
        var newU = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='+lat+','+lon+'&radius='+radius+'&type='+select+'&keyword='+keyword+'&key='+api_key;
        console.log(newU);
        request(newU,function(error, response, body){//console.log(body);
                                                    res.end(body);
        //console.log(body);
                                                    });
    
    }
    
    else if(from=="1"){
        var edit = req.query.edit;
        edit = urlencode(edit);
        console.log(edit);
        var url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+edit+'&key='+api_key;
        //console.log(url);
        request(url, function (error, response, body) {
            //console.log(body);
            var Location = JSON.parse(body);
            var root = Location.documentElement;
            var lat = Location.results[0].geometry.location.lat;
            var lon = Location.results[0].geometry.location.lng;
            var newU = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='+lat+','+lon+'&radius='+radius+'&type='+select+'&keyword='+keyword+'&key='+api_key;
        console.log(newU);
        request(newU,function(error, response, body){//console.log(body);
                                                     res.end(body);
        //console.log(Lo);
                                                    });
        });
    }
    //var Lat = location.lat;
    //console.log(location);

})

app.get('/nextpage', function (req, res) {
    var nextp = urlencode(req.query.nextpage);
    var api_key = "AIzaSyDIf8KK0RrwgUeWDCp7xrlZQM7EjBpTdeA";
    //console.log(nextp);
    var url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken="+nextp+"&key="+api_key;
    request(url,function(error,response,body){
        res.end(body);
        //console.log(body);
    });
})

app.get('/yelp', function (req, res) {
    const apiKey = 'OJJGeqNKAfVbs6POnI_SCXnk3rJeWCyMnLIqE8mf9czpIePMeKGRRJn_IZNBdLxo8apBcYrfs_E3v6zAT3vFxaZ40S1N3p-IkymZepIqRFYJkbWll4WFATQ0kx3LWnYx';

const client = yelp.client(apiKey);

client.businessMatch('best', {
  name: req.query.yname,
  address1: req.query.add1,
  address2: req.query.add2,
  city: req.query.city,
  state: req.query.state,
  country: "US"
}).then(response => {
  //console.log(response.jsonBody.businesses[0]);
    res.end(JSON.stringify(response.jsonBody.businesses[0]));
}).catch(e => {
  console.log(e);
});
    
})

app.get('/yelpR', function (req, res) {
    const apiKey = 'OJJGeqNKAfVbs6POnI_SCXnk3rJeWCyMnLIqE8mf9czpIePMeKGRRJn_IZNBdLxo8apBcYrfs_E3v6zAT3vFxaZ40S1N3p-IkymZepIqRFYJkbWll4WFATQ0kx3LWnYx';

    const client = yelp.client(apiKey);

client.reviews(req.query.alias).then(response => {
  console.log(response.jsonBody.reviews[0].text);
    res.end(JSON.stringify(response.jsonBody.reviews));
}).catch(e => {
  console.log(e);
});
    
})
 
var server = app.listen(8081, function () {
 
  var host = server.address().address
  var port = server.address().port
 
  console.log(host, port)
 
})