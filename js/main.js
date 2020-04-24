$(function() {
  $("#nav_layerlist").click(function() { //上方圖層列表
      $("#sidebar").toggle(); //if click, show sidebar
      $("#accordion").accordion("option", { active: 0 }); //control the layer
      updateSize();
  });
  $("#btn-hide").click(function() { //左方圖層列表右方箭頭
      $("#sidebar").hide();
      updateSize();
  });
  $(window).resize(function() {
      updateSize();
  });
});

updateSize();

function updateSize(){
  $("#container").css("height", $(window).height() - $("nav").height());
  $("#accordion").accordion({        //jQuery UI
      heightStyle: "fill",
  });
   map.updateSize();
  $("#accordion").accordion("refresh");
}
