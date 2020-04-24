proj4.defs('EPSG:3826', "+title=二度分帶：TWD97 TM2 台灣 +proj=tmerc  +lat_0=0 +lon_0=121 +k=0.9999 +x_0=250000 +y_0=0 +ellps=GRS80 +units=公尺 +no_defs");
proj4.defs('urn:ogc:def:crs:OGC:1.3:CRS:84',  proj4.defs('EPSG:4326'));
proj4.defs('urn:ogc:def:crs:EPSG::3826',      proj4.defs('EPSG:3826'));
ol.proj.proj4.register(proj4);

var init_lat=23.62;   //23.750815, 121.027538
var init_lng=120.5;
var zoom=7;
var user_location=null;
var view = new ol.View({
  center: ol.proj.transform([init_lng, init_lat], 'EPSG:4326', 'EPSG:3857'),
  zoom: zoom,
  minZoom: 7,
  maxZoom: 14,
  //extent: ol.proj.transformExtent([119.8, 21,122.07, 25.3], 'EPSG:4326', 'EPSG:3857')
});
var map = new ol.Map({
  layers: [],
  target: 'map',
  view: view,
  interactions: ol.interaction.defaults({ doubleClickZoom: false }),
});



//setting for tile services
var projection = ol.proj.get('EPSG:3857');              //projection
var projectionExtent = projection.getExtent();          //projectionExtent
var size = ol.extent.getWidth(projectionExtent) / 256;  //size
var resolutions = new Array(20);                        //resolutions
var matrixIds = new Array(20);                          //matrixIds
for (var z = 0; z < 20; ++z) {
    resolutions[z] = size / Math.pow(2, z);
    matrixIds[z] = z;
}


var layers = {
    'OSM': {
        'title': 'OpenStreetMap(開放街圖)',
        'type': 'base',
        'layer': new ol.layer.Tile({
            visible:false,
            source: new ol.source.OSM()
            })
        },
    'Google Maps': {
        'title': 'Google Maps',
        'type': 'base',
        'layer': new ol.layer.Tile({
            visible:false,
            source: new ol.source.XYZ({
                crossOrigin: 'anonymous',
                url: 'https://mt{0-3}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
            })
        })
    },
    'county': {
        'title': '總統選舉',
        'type': 'overlay',
        'layer': new ol.layer.Vector({
            visible:false,
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: './data/country.geojson',
            })

        })
    },
    'city': {
        'title': '各縣市政黨得票率',
        'type': 'overlay',
        'layer': new ol.layer.Vector({
            visible:false,
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: './data/county.geojson',
            })

        })
    },
    'poll': {
        'title': '2020問卷結果',
        'type': 'overlay_show',
        'layer': new ol.layer.Vector({
            visible:false,
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: './data/county.geojson',
            })

        })
    },
    'NTU_vote': {
        'title': '各縣市台大生投票率意願',
        'type': 'overlay_show',
        'layer': new ol.layer.Vector({
            visible:false,
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: './data/county.geojson',
            })

        })
    }
}


var setLayer=function(key){     //function setLayer(idx)
  for (i = 0; i < Object.keys(layers).length; i++) {
    var tlayer = layers[Object.keys(layers)[i]];
    if (tlayer.type == 'base')
      layers[Object.keys(layers)[i]].layer.setVisible(Object.keys(layers)[i]==key); //Object.keys(layers):'OSM','Google map'...
  }
}



var fill = new ol.style.Fill({
 color: 'rgba(	255,255,255, 0.6)'
});

var styles = {
    'county': [new ol.style.Style({
        fill: fill

    })],
    'city': [new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'rgba(210,180,140, 0.7)',
            width: 0.5
        }),
        fill: fill
    })],
    'poll': [new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'rgba(50, 60, 50, 0.7)',
            width: 0.5
        }),
        fill: fill
    })],
    'NTU_vote': [new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'rgba(50, 60, 50, 0.7)',
            width: 0.5
        }),
        fill: fill
    })]
};




function initLayers() {
  //console.log("layers:",layers[Object.keys(layers)[0]].layer);
  //console.log("layers:",Object.keys(layers)[0].layer);
  for (i = 0; i < Object.keys(layers).length; i++) {
    var tlayer = layers[Object.keys(layers)[i]];
    if (tlayer.type == 'base') {
      $('<div class="radio"><label><input type="radio" class="basecontrol" name="baselayer" id=' + Object.keys(layers)[i] + ' value="' + Object.keys(layers)[i] +'"'+ (i==2?' checked':'')   +' >' + tlayer.title + '</label></div>').appendTo("#baselayerlist");
      //console.log(layers[Object.keys(layers)[i]].title);
      map.addLayer(tlayer.layer);
    }else if(tlayer.type == 'overlay') {
      $('<div class="checkbox"><label><input type="checkbox" class="overlaycontrol" name="overlayer" value="' + Object.keys(layers)[i] + '">' + tlayer.title + '</label></div>').appendTo("#overlayerlist");
      map.addLayer(tlayer.layer);
      tlayer.layer.setZIndex(10000-i);
      tlayer.layer.setStyle(styleFunction(Object.keys(layers)[i]));
    }else if(tlayer.type == 'overlay_show') {
      $('<div class="checkbox"><label><input type="checkbox" class="overlaycontrol2" name="overlayer2" value="' + Object.keys(layers)[i] + '">' + tlayer.title + '</label></div>').appendTo("#overlayerlist2");
      map.addLayer(tlayer.layer);
      tlayer.layer.setZIndex(10000-i);
      tlayer.layer.setStyle(styleFunction(Object.keys(layers)[i])); //why no response
    }
  }

}

function styleFunction(stylename) {
  return styles[stylename];
};

initLayers();

//popup part
var popup=undefined;
map.on('pointermove', function(evt) {  //triger singleclick, get evt,
  var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {  //get feature and layer by evt.pixel
    return feature;
  });
  if(typeof(popup)!=undefined){
    map.removeOverlay(popup);
  }
  if (feature && feature.get('COUNTYNAME')!="台灣") { // only city layer will have popup window
    if(feature.get('COUNTYCODE')!=undefined){
      popup = new ol.Overlay({
        element: $("<div id='popup'/>").addClass('info').append(   //put a table to element parameter
          $("<table />").addClass('table').append(
            $("<tbody />").append(
              $("<tr />").append(
                $("<td />").html("縣市名稱")
              ).append(
                $("<td />").html(feature.get('COUNTYNAME'))
              )
            ).append(
              $("<tr />").append(
                $("<td />").html("KMT得票率%")
              ).append(
                $("<td id='pop_KMT'/>").html('')
              )
            ).append(
              $("<tr />").append(
                $("<td />").html("DPP得票率%")
              ).append(
                $("<td id='pop_DPP'/>").html('')
              )
            ).append(
              $("<tr />").append(
                $("<td />").html("OTH得票率%")
              ).append(
                $("<td id='pop_OTH'/>").html('')
              )
            )
          )
        )[0]  //[0] return a HTML_DOM object, convert jquery object to HTML_DOM
      });
	  if($("input.overlaycontrol").is(':checked')&&$("input.overlaycontrol").val()=='county'){ // only city layer will have popup window
		  popup.setPosition(evt.coordinate);
		  map.addOverlay(popup);
	  }

    }
  }
 
});//popup part end

//popup by hover part
var popup_hover=undefined;
map.on('pointermove', function(evt) {  //triger pointermove, get evt,
  var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {  //get feature and layer by evt.pixel
    return feature;	
  });
  if(typeof(popup_hover)!=undefined){
    map.removeOverlay(popup_hover);
  }
  
  if (feature && feature.get('COUNTYNAME')!="台灣") { // only NTU_vote layer will have popup window
    if(feature.get('COUNTYCODE')!=undefined){
      popup_hover = new ol.Overlay({
        element: $("<div id='popup_hover'/>").addClass('info').append(   //put a table to element parameter
          $("<table />").addClass('table').append(
            $("<tbody />").append(
              $("<tr />").append(
                $("<td />").html("縣市名稱")
              ).append(
                $("<td />").html(feature.get('COUNTYNAME'))
              )
            ).append(
              $("<tr />").append(
                $("<td id='pollNT'/>").html("台大生問卷樣本數")
              ).append(
                $("<td id='pollN'/>").html('')
              )
            ).append(
              $("<tr />").append(
                $("<td />").html("KMT支持度%")
              ).append(
                $("<td id='pop_KMT1'/>").html('')
              )
            ).append(
              $("<tr />").append(
                $("<td />").html("DPP支持度%")
              ).append(
                $("<td id='pop_DPP1'/>").html('')
              )
            ).append(
              $("<tr />").append(
                $("<td />").html("OTH支持度%")
              ).append(
                $("<td id='pop_OTH1'/>").html('')
              )
            )
          )
        )[0]  //[0] return a HTML_DOM object, convert jquery object to HTML_DOM
      });
	 
		
	  if($("input.overlaycontrol2").is(':checked') && $("input.overlaycontrol2").val()=='poll'){ // only NTU_vote layer will have popup window, all $("input.overlaycontrol2").val() is set to poll(the first input layer)	
			 popup_hover.setPosition(evt.coordinate);
			 map.addOverlay(popup_hover);	
			 
	  }
	 
		
    }
  }
 
});//popup by hover part end



$(function() {
  //baseLayer control
  //console.log(map.getView().calculateExtent(map.getSize()));
  setLayer('Google Maps');
  $("input.basecontrol").change(function() {
    if($(this).is(':checked'))
      setLayer($(this).attr('value'));
  });

  //overlayLayer control
  $("input.overlaycontrol").change(function() {
    if($(this).is(':checked')){
      for (i = 0; i < Object.keys(layers).length; i++) {
        var tlayer = layers[Object.keys(layers)[i]];
        if ((tlayer.type == 'overlay'|| tlayer.type == 'overlay_show') && tlayer.title != $(this).val()) {
          tlayer.layer.setVisible(false);
          $("input.overlaycontrol").not(this).prop('checked',false); //unckeck the box
          $("input.overlaycontrol2").not(this).prop('checked',false); //unckeck the box
        }
		
      }
      layers[$(this).val()].layer.setVisible(true);
      $("#labar").show();
	  $("#pollresult1").hide();
	  $("#pollresult2").hide();
    }
    else{
      layers[$(this).val()].layer.setVisible(false);
    }

    if($('input.overlaycontrol').is(':checked')==false){
      $("#labar").hide();
    }
	
	if($(this).val()=='city'){
      $("#click2open").show();
    }else $("#click2open").hide();
  });

  $("input.overlaycontrol2").change(function() {
    if($(this).is(':checked')){
      for (i = 0; i < Object.keys(layers).length; i++) {
        var tlayer = layers[Object.keys(layers)[i]];
        if ((tlayer.type == 'overlay'|| tlayer.type == 'overlay_show')  && tlayer.title != $(this).val()) {
          tlayer.layer.setVisible(false);
          $("input.overlaycontrol").not(this).prop('checked',false); //unckeck the box
          $("input.overlaycontrol2").not(this).prop('checked',false); //unckeck the box
        }
		
      }

	  $("#labar").hide();
      layers[$(this).val()].layer.setVisible(true);
      //console.log($(this).attr('value'));
    }
    else{
      layers[$(this).val()].layer.setVisible(false);
    }

		if($(this).val()=="poll"){
			$("#pollresult1").show();
			$("#pollresult2").hide();
		}else if($(this).val()=="NTU_vote"){
			$("#pollresult1").hide();
			$("#pollresult2").show();
		}
   	 
	 
  });

  

  var postdata = [];
$('#slider-vertical_1, #slider-vertical_2, #slider-vertical_3, input.overlaycontrol2, #map').on('slide change  mousemove', function(event, ui) { //if slider change   slidestop
  var postdata = [{ "personcate": "old", "value": $( "#amount1" ).val()},
                  { "personcate": "mid", "value": $( "#amount2" ).val()},
                  { "personcate": "you", "value": $( "#amount3" ).val()}];
  var postdata = JSON.stringify(postdata);           // 拉霸的動態的政黨支持度(%), 是得票率的分母變數之一, 所以下面的ajax也必須要不停更新
  var php_response_object=[];

  $.ajax({
      url: 'connectClient.php',
      type: 'POST',
      datatype: 'json',
      data: { mydata: postdata },                    // 送拉霸的動態的政黨支持度(%)給connectClient.php
      // <!--mydata是連結php的名字&postdata是json的名字-->
      success: myCallback,
      error: function () {
          //your code here
      }
  })
  function myCallback(php_response) {             // 傳回整合歷史資料的新的全國(和縣市)支持度
        //console.log(php_response);               // 檢查拉動拉霸後的得票率變化
		//console.log(php_response_object[21]);
	   
	    php_response_object = JSON.parse(php_response);
		//console.log(php_response_object[22].Nation[0].percentage);        // 第一個[]是第幾份資料 (0~21是22個縣市County1~22, 22是全國Nation)
                                                                         // 第二個[]是第幾個政黨 (0~2是KMT, DPP, OTH)
         
		//update county color
  function updateLayers() {
    for (i = 0; i < Object.keys(layers).length; i++) {
      var tlayer = layers[Object.keys(layers)[i]];
      if(tlayer.type == 'overlay' && Object.keys(layers)[i]=='county') {
        tlayer.layer.setZIndex(10000-i);
        tlayer.layer.setStyle(styleFunction1(Object.keys(layers)[i]));
      }
    }
  }

  //county part
  function styleFunction1(stylename) {
    return styles1[stylename];
  };
	var elected = Math.max(php_response_object[22].Nation[0].percentage, php_response_object[22].Nation[1].percentage, php_response_object[22].Nation[2].percentage);

	switch(true){
	   case php_response_object[22].Nation[0].percentage==elected:
		var fill = new ol.style.Fill({
			color: 'rgba(0, 0, 255, 0.6)'
		}); break;
	   case php_response_object[22].Nation[1].percentage==elected:
		var fill = new ol.style.Fill({
			color: 'rgba(0, 128, 0, 0.6)'
		}); break;
	   case php_response_object[22].Nation[2].percentage==elected:
		var fill = new ol.style.Fill({
			color: 'rgba(255,165,0, 0.6)'
		}); break;
	   
   }
		//console.log(elected);
  var styles1 = {
      'county': [new ol.style.Style({
          fill: fill
      })]
  };
  
	updateLayers();
	
  $('#aOTH').html(php_response_object[22].Nation[2].percentage+'%');  //dynamic update HTML
  $('#aKMT').html(php_response_object[22].Nation[0].percentage+'%'); 
  $('#aDPP').html(php_response_object[22].Nation[1].percentage+'%'); 

  
  
  //city part
  layers.city.layer.getSource().forEachFeature(function(feature){

	   var styles2 = function returnStyleCity(feature, resolution) {		   
		var fill_OTH = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(255,165,0, 0.6)'
					}) //OTH
				})
		
		var fill_KMT = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(0, 0, 255, 0.6)'
					}) //KMT
				})
		
		var fill_DPP = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(0, 128, 0, 0.6)'
					}) //DPP
				})

	   //console.log(php_response_object[0].County1[0].percentage); //KMT
	   //console.log(php_response_object[0].County1[1].percentage); //DPP
	   //console.log(php_response_object[0].County1[2].percentage); //OTH
	   
	   function outcolor(php_response_object,idx) { //find which party elected in each county
	   var cityelected = Math.max(php_response_object[idx].County[0].percentage, php_response_object[idx].County[1].percentage, php_response_object[idx].County[2].percentage);
		switch(true){
	   case php_response_object[idx].County[0].percentage==cityelected:
		return [fill_KMT]; break;
	   case php_response_object[idx].County[1].percentage==cityelected:
		return [fill_DPP]; break;
	   case php_response_object[idx].County[2].percentage==cityelected:
		return [fill_OTH]; break;
			}				
	   }
	   
	   switch(feature.get('COUNTYENG')){ //22 county  color   
		   case 'Lienchiang County': 
		   return outcolor(php_response_object,0); break;
		   case "Yilan County" : 
		   return outcolor(php_response_object,1); break;
		   case "Changhua County" : 
		   return outcolor(php_response_object,2);break;
		   case "Nantou County" : 
		   return outcolor(php_response_object,3);break;
		   case "Yunlin County" : 
		   return outcolor(php_response_object,4);break;
		   case "Pingtung County" : 
		   return outcolor(php_response_object,5);break;
		   case "Taitung County" : 
		   return outcolor(php_response_object,6);break;
		   case "Hualien County" : 
		   return outcolor(php_response_object,7);break;
		   case "Penghu County" : 
		   return outcolor(php_response_object,8);break;
		   case "Keelung City" : 
		   return outcolor(php_response_object,9);break;
		   case "Hsinchu City" : 
		   return outcolor(php_response_object,10);break;
		   case "Taipei City" : 
		   return outcolor(php_response_object,11);break;
		   case "New Taipei City" : 
		   return outcolor(php_response_object,12);break;
		   case "Taichung City" : 
		   return outcolor(php_response_object,13);break;
		   case "Tainan City" : 
		   return outcolor(php_response_object,14);break;
		   case "Taoyuan City" : 
		   return outcolor(php_response_object,15);break;
		   case "Miaoli County" : 
		   return outcolor(php_response_object,16);break;
		   case "Hsinchu County" : 
		   return outcolor(php_response_object,17);break;
		   case "Chiayi City" : 
		   return outcolor(php_response_object,18);break;
		   case "Chiayi County" : 
		   return outcolor(php_response_object,19);break;
		   case "Kaohsiung City" : 
		   return outcolor(php_response_object,20);break;
		   case "Kinmen County" : 
		   return outcolor(php_response_object,21);break;	   
	   }
	
	  }; //styles2  end
	   		
		function updateLayers_show() { //choropleth
		for (i = 0; i < Object.keys(layers).length; i++) {
		var tlayer = layers[Object.keys(layers)[i]];
		if(tlayer.type == 'overlay' && Object.keys(layers)[i]=='city') {
        tlayer.layer.setZIndex(10000-i);
        tlayer.layer.setStyle(styles2);
		}
    }
  }
		updateLayers_show();
		
		
		map.on('pointermove', function(evt) {
			var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {  //get feature and layer by evt.pixel
			return feature;	
			});
			//console.log(feature.get('COUNTYENG'));
			for(i=0; i<22;i++){ 
			if(feature!=undefined && php_response_object[i].County[3].countyname==feature.get('COUNTYENG')){			  
			  $('#popup #pop_KMT').html(php_response_object[i].County[0].percentage); //各縣市 KMT 支持度
			  $('#popup #pop_DPP').html(php_response_object[i].County[1].percentage);
			  $('#popup #pop_OTH').html(php_response_object[i].County[2].percentage);
				}
			}
		});
		
  }); //city part end
  
  //2020 poll part
  layers.poll.layer.getSource().forEachFeature(function(feature){

	   var styles4 = function returnStylePoll(feature, resolution) {		   
		var fill_OTH = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(255,165,0, 0.6)'
					}) //OTH
				})
		
		var fill_KMT = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(0, 0, 255, 0.6)'
					}) //KMT
				})
		
		var fill_DPP = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(0, 128, 0, 0.6)'
					}) //DPP
				})
	   
	   function outcolor4(php_response_object,idx) { //find the max supported party in each county
	   var POLLmax = Math.max(php_response_object[idx].Roll[0].KMT, php_response_object[idx].Roll[0].DPP, php_response_object[idx].Roll[0].OTH);
		switch(true){
	   case php_response_object[idx].Roll[0].KMT==POLLmax:
		return [fill_KMT]; break;
	   case php_response_object[idx].Roll[0].DPP==POLLmax:
		return [fill_DPP]; break;
	   case php_response_object[idx].Roll[0].OTH==POLLmax:
		return [fill_OTH]; break;
			}				
	   }
	   
	   switch(feature.get('COUNTYENG')){ //22 county popup value and color   
		   case 'Lienchiang County': 			   
		   return outcolor4(php_response_object,23); break;
		   case "Yilan County" : 
		   return outcolor4(php_response_object,24); break;
		   case "Changhua County" : 
		   return outcolor4(php_response_object,25);break;
		   case "Nantou County" : 
		   return outcolor4(php_response_object,26);break;
		   case "Yunlin County" : 
		   return outcolor4(php_response_object,27);break;
		   case "Pingtung County" : 
		   return outcolor4(php_response_object,28);break;
		   case "Taitung County" : 
		   return outcolor4(php_response_object,29);break;
		   case "Hualien County" : 
		   return outcolor4(php_response_object,30);break;
		   case "Penghu County" : 
		   return outcolor4(php_response_object,31);break;
		   case "Keelung City" : 
		   return outcolor4(php_response_object,32);break;
		   case "Hsinchu City" : 
		   return outcolor4(php_response_object,33);break;
		   case "Taipei City" : 
		   return outcolor4(php_response_object,34);break;
		   case "New Taipei City" : 
		   return outcolor4(php_response_object,35);break;
		   case "Taichung City" : 
		   return outcolor4(php_response_object,36);break;
		   case "Tainan City" : 
		   return outcolor4(php_response_object,37);break;
		   case "Taoyuan City" : 
		   return outcolor4(php_response_object,38);break;
		   case "Miaoli County" : 
		   return outcolor4(php_response_object,39);break;
		   case "Hsinchu County" : 
		   return outcolor4(php_response_object,40);break;
		   case "Chiayi City" : 
		   return outcolor4(php_response_object,41);break;
		   case "Chiayi County" : 
		   return outcolor4(php_response_object,42);break;
		   case "Kaohsiung City" : 
		   return outcolor4(php_response_object,43);break;
		   case "Kinmen County" : 
		   return outcolor4(php_response_object,44);break;	   
	   }
	
	  }; //styles4  end
	   		
		function updateLayers_show4() { //choropleth
		for (i = 0; i < Object.keys(layers).length; i++) {
		var tlayer = layers[Object.keys(layers)[i]];
		if(tlayer.type == 'overlay_show' && Object.keys(layers)[i]=='poll') {
        tlayer.layer.setZIndex(10000-i);
        tlayer.layer.setStyle(styles4);
		}
    }
  }
		updateLayers_show4();
		
		map.on('pointermove', function(evt) {
			var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {  //get feature and layer by evt.pixel
			return feature;	
			});
			for(i=0; i<22;i++){
			if(feature!=undefined && php_response_object[i+45].WILL[0].Countyname==feature.get('COUNTYENG')){
			  $('#popup_hover #pollN').html(php_response_object[i+45].WILL[0].num);	
			  $('#popup_hover #pop_KMT1').html((php_response_object[i+23].Roll[0].KMT*100).toFixed(2)); //各縣市 KMT 支持度
			  $('#popup_hover #pop_DPP1').html((php_response_object[i+23].Roll[0].DPP*100).toFixed(2));
			  $('#popup_hover #pop_OTH1').html((php_response_object[i+23].Roll[0].OTH*100).toFixed(2));
				}
			}
		});
		
  }); //2020 poll part end
  
  
  //NTU_vote part
  layers.NTU_vote.layer.getSource().forEachFeature(function(feature){

	   var styles3 = function returnStyleNTU_vote(feature, resolution) {	
		var fill_1 = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(68, 64, 45, 0.8)'
					}) //OTH
				})	   
		var fill_2 = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(135, 127, 14, 0.8)'
					}) //OTH
				})
		
		var fill_3 = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.8)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(111, 103, 70, 0.8)'
					}) //KMT
				})
		
		var fill_4 = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(176, 161, 107, 0.8)'
					}) //DPP
				})
		var fill_5 = new ol.style.Style({
					stroke: new ol.style.Stroke({
					color: 'rgba(50, 60, 50, 0.7)',
					width: 0.5
					}),
					fill: new ol.style.Fill({
					color: 'rgba(220, 200, 132, 0.8)'
					}) //DPP
				})
		

	   //console.log(php_response_object[45].County1[0].percentage); //KMT
	   //console.log(php_response_object[45].County1[1].percentage); //DPP
	   //console.log(php_response_object[45].County1[2].percentage); //OTH
	   
	    function outcolor1(php_response_object,idx) { //
	   
		switch(true){
	   case php_response_object[idx].WILL[0].Vote<=4.0:
		return [fill_1]; break;
	   case php_response_object[idx].WILL[0].Vote<4.2:
		return [fill_2]; break;
	   case php_response_object[idx].WILL[0].Vote<4.4:
		return [fill_3]; break;
	   case php_response_object[idx].WILL[0].Vote<4.6:
		return [fill_4]; break;
	   case php_response_object[idx].WILL[0].Vote<5.1:
		return [fill_5]; break;
			}				
	   }
	   	   
	   switch(feature.get('COUNTYENG')){ //22 county color   
		   case 'Lienchiang County': 		
		   return outcolor1(php_response_object,45); break;
		   case "Yilan County" : 	   
		   return outcolor1(php_response_object,46); break;
		   case "Changhua County" : 		   
		   return outcolor1(php_response_object,47);break;
		   case "Nantou County" : 		   
		   return outcolor1(php_response_object,48);break;
		   case "Yunlin County" : 		   
		   return outcolor1(php_response_object,49);break;
		   case "Pingtung County" : 		   
		   return outcolor1(php_response_object,50);break;
		   case "Taitung County" : 		   
		   return outcolor1(php_response_object,51);break;
		   case "Hualien County" : 		   	
		   return outcolor1(php_response_object,52);break;
		   case "Penghu County" : 		  
		   return outcolor1(php_response_object,53);break;
		   case "Keelung City" : 		   
		   return outcolor1(php_response_object,54);break;
		   case "Hsinchu City" : 		   
		   return outcolor1(php_response_object,55);break;
		   case "Taipei City" : 		   
		   return outcolor1(php_response_object,56);break;
		   case "New Taipei City" : 		   
		   return outcolor1(php_response_object,57);break;
		   case "Taichung City" : 		   
		   return outcolor1(php_response_object,58);break;
		   case "Tainan City" : 		   
		   return outcolor1(php_response_object,59);break;
		   case "Taoyuan City" : 		   
		   return outcolor1(php_response_object,60);break;
		   case "Miaoli County" : 		  
		   return outcolor1(php_response_object,61);break;
		   case "Hsinchu County" : 		   
		   return outcolor1(php_response_object,62);break;
		   case "Chiayi City" : 	
		   return outcolor1(php_response_object,63);break;
		   case "Chiayi County" : 	
		   return outcolor1(php_response_object,64);break;
		   case "Kaohsiung City" : 		
		   return outcolor1(php_response_object,65);break;
		   case "Kinmen County" : 
		   return outcolor1(php_response_object,66);break;	 
	   }
	
	  }; //styles3  end
	   		
		function updateLayers_show2() { //choropleth
		for (i = 0; i < Object.keys(layers).length; i++) {
		var tlayer = layers[Object.keys(layers)[i]];
		if(tlayer.type == 'overlay_show' && Object.keys(layers)[i]=='NTU_vote') {
        tlayer.layer.setZIndex(10000-i);
        tlayer.layer.setStyle(styles3);
				}
			}
		}
		updateLayers_show2(); //update NTU_vote layers
		
		map.on('pointermove', function(evt) {
			var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {  //get feature and layer by evt.pixel
			return feature;	
			});
			//console.log(feature.get('COUNTYENG'));
			for(i=0; i<22;i++){
			if(feature!=undefined && php_response_object[i+45].WILL[0].Countyname==feature.get('COUNTYENG')){
			  $('#popup_hover #pollN').html(php_response_object[i+45].WILL[0].num);	//各縣市 問卷樣本數 
			  $('#popup_hover #pop_KMT1').html((php_response_object[i+23].Roll[0].KMT*100).toFixed(2)); //各縣市 KMT 支持度
			  $('#popup_hover #pop_DPP1').html((php_response_object[i+23].Roll[0].DPP*100).toFixed(2));
			  $('#popup_hover #pop_OTH1').html((php_response_object[i+23].Roll[0].OTH*100).toFixed(2));
			  
				}
			}
		});
		
				
		
  }); //will part end
  
  
  	
		
     } //ajax

 
}); //slider change



});
