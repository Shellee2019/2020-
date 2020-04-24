$(function() {
  var drawSource = new ol.source.Vector();
  var drawLayer = new ol.layer.Vector({
    source: drawSource,
    style: new ol.style.Style({
      fill: new ol.style.Fill({
        color: 'rgba(255, 255, 255, 0.5)'
      }),
      stroke: new ol.style.Stroke({
        color: '#ff3333',
        width: 2
      }),
      image: new ol.style.Circle({
        radius: 7,
        fill: new ol.style.Fill({
          color: '#ff3333'
        })
      })
    })
  });
  map.addLayer(drawLayer);
  var select_interaction=undefined;
  var mouse_interaction=undefined;
  function setInteraction(type){
    if(select_interaction!=undefined)     map.removeInteraction(select_interaction);
    if(mouse_interaction!=undefined)      map.removeInteraction(mouse_interaction);
    mouse_interaction = new ol.interaction.Draw({
      source: drawSource, //put the created layer in drawSource
      type: type, //Point,LineString,Polygon
    });
    mouse_interaction.on('drawend', function(event) {
      map.removeInteraction(mouse_interaction);
      mouse_interaction=undefined;             //the usage is to judge drawing or not
    });
    map.addInteraction(mouse_interaction); //put into map
  }
  $('.btn-draw').click(function(){
    setInteraction($(this).attr('drawType'));
  });

  $('#btn-edit').click(function(){
    if(select_interaction!=undefined)     map.removeInteraction(select_interaction);
    if(mouse_interaction!=undefined)      map.removeInteraction(mouse_interaction);
    select_interaction = new ol.interaction.Select();
    mouse_interaction = new ol.interaction.Modify({
      features: select_interaction.getFeatures()
    });
    map.addInteraction(select_interaction);
    map.addInteraction(mouse_interaction);
  });


  $('#btn-json').click(function(){
    //convert drawn features to geojson
    var gjsonfile = new ol.format.GeoJSON();
    var geojsonStr = gjsonfile.writeFeatures(drawSource.getFeatures(),{
      dataProjection: 'EPSG:4326',
      featureProjection: 'EPSG:3857'
    });
    //pretty print of geojson
    json=JSON.parse(geojsonStr);
    geojsonStr=JSON.stringify(json,null,' ');

    //download the geojson file
    var link=$(this);
    var filename="draw.geojson";
    $(link).attr('download',filename);
    $(link).attr('href','data:application/json,'+encodeURI(geojsonStr));
    console.log(geojsonStr);
  });
});
