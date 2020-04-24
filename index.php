<!DOCTYPE html>
<html lang="en">
  <head>
    <title>選舉得來速</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/bar_style.css">
    <link rel="stylesheet" href="./css/style.css" type="text/css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <!--Openlayers-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/css/ol.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/build/ol.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.4.4/proj4.js'></script>
  </head>
  <script>
  $( function() {
    //國民黨
    $( "#slider-vertical_1" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: 74,
      slide: function( event, ui ) {
        $( "#amount1" ).val( ui.value );
      }
    });
    $( "#amount1" ).val( $( "#slider-vertical_1" ).slider( "value" ) );
    //民進黨
    $( "#slider-vertical_2" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: 74,
      slide: function( event, ui ) {
        $( "#amount2" ).val( ui.value );
      }
    });
    $( "#amount2" ).val( $( "#slider-vertical_2" ).slider( "value" ) );
    //親民黨
    $( "#slider-vertical_3" ).slider({
      orientation: "vertical",
      range: "min",
      min: 0,
      max: 100,
      value: 74,
      slide: function( event, ui ) {
        $( "#amount3" ).val( ui.value );
      }
    });
    $( "#amount3" ).val( $( "#slider-vertical_3" ).slider( "value" ) );

  } );


  </script>

  <style>

  #container {
    width:100%;
  }
  #left {
    float:left;
    width:60px;
    /* background: #ff0000; */
  }

  #center {
    display: inline-block;
    width:60px;
    /* background: #00ff00; */
  }

  /* #right {
    float:right;
    width:60px;
    background: #0000ff;
  } */

  #slider-vertical_1 .ui-slider-range { background: #8ae234; }
  #slider-vertical_1 .ui-slider-handle { border-color: #8ae234; }
  #slider-vertical_2 .ui-slider-range { background: #729fcf; }
  #slider-vertical_2 .ui-slider-handle { border-color: #729fcf; }
  #slider-vertical_3 .ui-slider-range { background: #D26900; }
  #slider-vertical_3 .ui-slider-handle { border-color: #D26900; }

  .map{
     width: 50%;
     height: 100%;
     border-radius: 2px;
     border: #999 2px solid;
  }

  .info{
  	background: #FFF;
  	color: #000;
    border-radius: 3px;
  	border: 1px solid #fae3d9;
  }
  .info > .table{
  	margin-bottom:0;
  }
  .info > .table th, .info > .table td{
  	padding: 4px;
  	line-height: 1.2;
  }
  .info > .table > tbody > tr:nth-child(odd){
  	background: #EEF0B7
;
  }
  .info > .table > tbody > tr:nth-child(even){
  	background: #F5E7CC
;
  }

  /*legend color setting*/
  
  .boxleg {
  
  width: 20px;
  height: 20px;
  margin: 5px;
  border: 1px solid rgba(0, 0, 0, .2);
	}

.will1 {
  background: rgba(68, 64, 45, 0.8);
}

.will2 {
  background: rgba(135, 127, 14, 0.8);
}

.will3 {
  background: rgba(111, 103, 70, 0.8);
}
.will4 {
  background: rgba(176, 161, 107, 0.8);
}
.will5 {
  background: rgba(220, 200, 132, 0.8);
}


  </style>
<body>
   <nav class="nav navbar-default" style="background-image: linear-gradient(to right, #5aeb50, #ffaa00, #5079eb);color:black;border:1px black solid;"> <!--感謝水果小組提供 -->

    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar navbar-default"></span>
          <span class="icon-bar navbar-default"></span>
          <span class="icon-bar navbar-default"></span>
        </button>
        <a class="navbar-brand"> <img src="https://img.icons8.com/color/48/000000/elections.png" style="width:35px;height:25px;"></a>
        <a class="navbar-brand" href="http://140.112.64.232/rootvote/term/index.php">選舉得來速</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a data-toggle="tab" href="#layerlist" id="nav_layerlist">圖層列表</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><img src="./data/flag.jpg" style="width:35px;height:25px;"></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div id="container">
    <div id="sidebar" > <!--style="display:none"-->
      <div id="accordion">
        <h3>圖層列表<button type="button" id="btn-hide" class="btn btn-xs btn-default pull-right" id="sidebar-hide-btn"><i class="fa fa-chevron-left"></i></button></h3>
        <div id="acc_layerlist">
          <h4 id="baselayerlist"><div style="color:rgb(34, 122, 130);"><strong>基本底圖</strong></div></h4>
          <h4 id="overlayerlist"><div style="color:rgb(34, 122, 130);"><strong>模擬結果</strong></div></h4>
          <h4 id="overlayerlist2"><div style="color:rgb(34, 122, 130);"><strong>問卷結果</strong></div></h4>
		  <h4 ><div style="color:rgb(34, 122, 130);"><strong>實際結果地圖 (媒體連結)</strong></div></h4>
		  <div><a href="https://www.thenewslens.com/interactive/126883" target="_blank" style="color:rgb(86, 125, 240);" >關鍵評論網</a></div>
		  <div><a href="https://web.cw.com.tw/2020-taiwan-presidential-election/map.html" target="_blank" style="color:rgb(86, 125, 240);">天下雜誌</a></div>
		  <div><a href="https://www.bloomberg.com/graphics/2020-taiwan-election-results/" target="_blank" style="color:rgb(86, 125, 240);">Bloomberg Taiwan 2020 Election Results</a></div>
        </div>
        <h3>資料說明</h3>
        <div>
          <strong>政黨代號名稱</strong></br>
          <span style="color:blue;">KMT：國民黨</span></br>
          <span style="color:green;">DPP：民進黨</span></br>
          <span style="color:orange;">OTH：其他</span></br>
          </br>
          <strong>參數名稱</strong></br>
          青年投票率：rate<sub>y</sub></br>
          中年投票率：rate<sub>m</sub></br>
          老年投票率：rate<sub>o</sub></br>
          </br>
          N = 1~22</br>
          KMT青年歷史得票率（縣市N）：KMT<sub>yN</sub></br>
          KMT中年歷史得票率（縣市N）：KMT<sub>mN</sub></br>
          KMT老年歷史得票率（縣市N）：KMT<sub>oN</sub></br>
          </br>
          DPP青年歷史得票率（縣市N）：DPP<sub>yN</sub></br>
          DPP中年歷史得票率（縣市N）：DPP<sub>mN</sub></br>
          DPP老年歷史得票率（縣市N）：DPP<sub>oN</sub></br>
          </br>
          OTH青年歷史得票率（縣市N）：OTH<sub>yN</sub></br>
          OTH中年歷史得票率（縣市N）：OTH<sub>mN</sub></br>
          OTH老年歷史得票率（縣市N）：OTH<sub>oN</sub></br>
          </br>
          <strong>縣市得票率</strong></br>
          分母 = <span style="color:blue;">rate<sub>y</sub>×KMT<sub>yN</sub>+rate<sub>m</sub>×KMT<sub>mN</sub>+rate<sub>o</sub>×KMT<sub>oN</sub></span>
          +<span style="color:green;">rate<sub>y</sub>×DPP<sub>yN</sub>+rate<sub>m</sub>×DPP<sub>mN</sub>+rate<sub>o</sub>×DPP<sub>oN</sub></span>
          +<span style="color:orange;">rate<sub>y</sub>×OTH<sub>yN</sub>+rate<sub>m</sub>×OTH<sub>mN</sub>+rate<sub>o</sub>×OTH<sub>oN</sub></span></br></br>
          <em>KMT在縣市N得票率(%)</em></br>
          KMT<sub>N</sub>=100×(<span style="color:blue;">rate<sub>y</sub>×KMT<sub>yN</sub>+rate<sub>m</sub>×KMT<sub>mN</sub>+rate<sub>o</sub>×KMT<sub>oN</sub></span>)/分母</br>
          <em>DPP在縣市N得票率(%)</em></br>
          DPP<sub>N</sub>=100×(<span style="color:green;">rate<sub>y</sub>×DPP<sub>yN</sub>+rate<sub>m</sub>×DPP<sub>mN</sub>+rate<sub>o</sub>×DPP<sub>oN</sub></span>)/分母</br>
          <em>OTH在縣市N得票率(%)</em></br>
          OTH<sub>N</sub>=100×(<span style="color:orange;">rate<sub>y</sub>×OTH<sub>yN</sub>+rate<sub>m</sub>×OTH<sub>mN</sub>+rate<sub>o</sub>×OTH<sub>oN</sub></span>)/分母</br>
          </br>
          <strong>全國得票率</strong></br>
          <em><span style="color:blue;">KMT在全國得票率(%)</span></em>=(KMT<sub>1</sub>+KMT<sub>2</sub>+⋯+KMT<sub>22</sub>)/22</br>
          <em><span style="color:green;">DPP在全國得票率(%)</span></em>=(DPP<sub>1</sub>+DPP<sub>2</sub>+⋯+DPP<sub>22</sub>)/22</br>
          <em><span style="color:orange;">OTH在全國得票率(%)</span></em>=(OTH<sub>1</sub>+OTH<sub>2</sub>+⋯+OTH<sub>22</sub>)/22</br>

        </div>
        <h3>網頁作者&資料來源</h3>
        <div id="draw_data">
          台大地理系 108-1 WebGIS 課程 </br></br>
          邵旻純、李欣儒、張禎晏、王祥恒 2020.Jan. 期末製作</br></br>
          資料來源：</br>
          <ul>
          <li><a href="https://data.gov.tw/" target="_blank"  style="text-decoration:none;color:blue;">政府資料開放平台</a></br></li>
          <li><a href="https://www.ris.gov.tw/app/portal" target="_blank"  style="text-decoration:none;color:blue;">2018年地方選舉資料：中選會選舉資料庫</a></br></li>
          <li><a href="https://db.cec.gov.tw/" target="_blank"  style="text-decoration:none;color:blue;">人口資料：內政部戶政司</a></br></li>
          <li><a href="#" target="_blank"  style="text-decoration:none;color:blue;">2020總統選舉民意調查資料：本團隊自行搜集</a></br></li>
          <li><a href="https://web.cec.gov.tw/upload/file/2017-02-17/2632faa8-582d-4e31-85ab-8d5f2ba6d9e3/0e44676e544ec6326a5c6b81497720e3.pdf" target="_blank"  style="text-decoration:none;color:blue;">各年齡層投票率資料：莊文忠等（2016）。選舉人性別投票統計改良之研究，中央選舉委員會委託研究。</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div  id="map" class='map'></div>

    <div id="labar" class="container" style="position:fixed; right:-350px;  top: 65px; max-width: 50%; overflow-wrap: break-word; display:none;">
    <!-- <div style="width: 60%; float: right;"> Text to the left.</div> -->

    <div id="left">
    <p> <label for="amount1"><img src="https://img.icons8.com/emoji/48/000000/woman-student.png" style="width:30px;height:30px;">青年<br>投票率%:</label>
      <input type="text" id="amount1" readonly style="border:0; color:#8ae234; font-weight:bold;"> </p>
      <div id="slider-vertical_1" style="height:200px;" class='inline'></div>
    </div>
    <div id="center">
    <p> <label for="amount2"><img src="https://img.icons8.com/emoji/48/000000/woman-office-worker.png" style="width:30px;height:30px;">中年<br>投票率%:</label>
      <input type="text" id="amount2" readonly style="border:0; color:#729fcf; font-weight:bold;"> </p>
      <div id="slider-vertical_2" style="height:200px;" class='inline'></div>
    </div>
    <div id="center">
    <p> <label for="amount3"><img src="https://img.icons8.com/color/48/000000/matrix-architect.png" style="width:30px;height:30px;">老年<br>投票率%:</label>
      <input type="text" id="amount3" readonly style="border:0; color:#D26900; font-weight:bold;"> </p>
      <div id="slider-vertical_3" style="height:200px;" class='inline'></div>
    </div>
  <p></p>
    <div > 使用說明: </div>
    <div> 嘗試不同的投票率組成模擬總統大選結果 </div>
    <ul>當選組合
      <li style="color:orange;">親民黨 宋楚瑜 余湘 <span id="aOTH"></span></li>
      <li style="color:blue;">國民黨 韓國瑜 張善政 <span id="aKMT"></span></li>
      <li style="color:green;">民進黨 蔡英文 賴清德 <span id="aDPP"></span></li>
    </ul>
	<div id= 'click2open' style='display:none;border-width:3px;border-style:dashed;border-color:#FFAC55;padding:5px;width:250px;'>
		調整上方數值<strong>後</strong><u>游標覆蓋</u>各縣市圖層<br>查看動態政黨得票率
	</div>
    </div>
	
	
	<!--問卷結果 2020問卷結果-->
	<div id="pollresult1" class="container" style="position:fixed; right:-325px;  top: 65px; max-width: 50%; overflow-wrap: break-word; display:none;">
		<p><strong>圖層說明</strong></p>
		<p > 本圖層呈現本團隊分別於Facebook社團</br>「NTU台大學生交流版」及長輩Line群組，</br>進行方便抽樣的問卷結果，並合併計算展示</br>。
兩份問卷發放期間皆在2019年12月中下</br>旬，發放於前者Facebook社團者，有效回</br>覆N=172，年齡集中於21-24歲；後者發放</br>於長輩Line群組者，有效回覆N=166，年</br>齡集中於45-65歲。</p>
	<div>各縣市最高支持度政黨</div>
	<ul>
      <li style="color:orange;">親民黨 <span id="aOTH1"></span></li>
      <li style="color:blue;">國民黨 <span id="aKMT1"></span></li>
      <li style="color:green;">民進黨 <span id="aDPP1"></span></li>
    </ul>
	<div  style='border-width:3px;border-style:dashed;border-color:#FFAC55;padding:5px;width:200px;'>
		<u>游標覆蓋</u>各縣市圖層<br>查看各縣市政黨支持率
	</div>
	</div>	
	<!--問卷結果 各縣市台大生投票率意願-->
	<div id="pollresult2" class="container" style="position:fixed; right:-325px;  top: 65px; max-width: 50%; overflow-wrap: break-word; display:none;">
		<p><strong>圖層說明</strong></p>
		<div > 本圖層呈現本團隊於Facebook社團</br>「NTU台大學生交流版」，進行方便抽樣</br>的問卷結果，並計算展示填答之台大學生返回</br>戶籍地投票的意願統計結果</br>（5分為極願意返鄉投票，1分為不願意</br>返鄉投票）。
該問卷發放期間在</br>2019年12月中下旬，有效回覆N=172，</br>年齡集中於21-24歲。 </div>
		
		<p>
		<ul class="list-unstyled"> 
			<li class="boxleg will1">  </li><span>平均意願<=4.0</span>
			<li class="boxleg will2">  </li><span>4.0<平均意願<4.2</span>
			<li class="boxleg will3">  </li><span>4.2<平均意願<4.4</span>
			<li class="boxleg will4">  </li><span>4.4<平均意願<4.6</span>
			<li class="boxleg will5">  </li><span>4.6<平均意願</span>
		</ul>
		</p>
		<div  style='border-width:3px;border-style:dashed;border-color:#FFAC55;padding:5px;width:200px;'>
		<u>游標覆蓋</u>各縣市圖層<br>查看各縣市問卷回應結果
		</div>
		
		
	</div>	
		
  </div><!-- end of container -->

  <script src="./js/map.js"></script>         <!-- include map.js here because it must appear after <div id="map"> -->
  <script src="./js/main.js"></script>
  <script src="./js/draw.js"></script>
</body>
