<?php /* Template Name: pace */ ?>
 
<?php get_header(); ?>
 
<div id="primary" class="content-area">

<style>

html{direction:rtl;}
body{background-color:#f4f4f4;}

.hidden{display: none;}

.spanner-container{position: fixed;top: 0;left: 0%;width: 100%;height: 100%;}
.spanner-overlay{background: #fff;width: 100%;height: 100%;z-index: 999;opacity: .6;}
.spanner{position: fixed;top: 40%;left: 50%;border:5px solid #1eaae1;border-radius: 50%;transform: translate(-50%);padding:20px;animation: scalable infinite 1.5s;}
@keyframes scalable{
    from{padding:0;opacity: 0;}
    to{padding:20px;opacity: 1;}
}

.table{display: table;width: 90%;margin: 0 auto;text-align: center;}
.table .tr{display: table-row;transition:ease-in-out .4s}
.table .tr:first-child{background-color: #06212C;color: #fff;}
.table .th,.table .td{display:table-cell;padding: 10px 0;transition:ease-in-out .4s}
.table .th{font-weight: bold;}
.table .td{background-color: #fff;}
.table .td:nth-child(2),.table .th:nth-child(2){text-align:right}
.table .td img{width:50px;height:50px}
.table .td span{height: 50px;margin:0 10px;display: inline-block;vertical-align: middle;}

.dark.table .tr{display: table-row;background-color: #252525}
.dark.table .tr:first-child{background-color:#191919;color: #fff;}
.dark.table .tr:nth-child(even){background-color: #2B2B2B;}
.dark.table .td{color:#fff;background-color:transparent;}
.dark.table .td:nth-child(2),.table .th:nth-child(2){text-align:right}        

@media only screen and (max-width: 600px) {
    .table{font-size: 8px;}
}

@media only screen and (min-width: 600px) {
    .table{font-size: 15    px;}
}

</style>
<title>Document</title>
</head>
<body>
<nav>
<select name="league" id="leagues">
<option value="1">الدوري الانجليزي</option>
<option value="2">الدوري الاسباني</option>
<option value="3">الدوري الايطالي</option>
<option value="4">الدوري الالماني</option>
<option value="5">الدوري الفرنسي</option>
<option value="6">الدوري المصري</option>
<option value="7">الدوري السعودي</option>
<option value="8">الدوري المغربي</option>
<option value="9">الدوري الجزائري</option>
<option value="10">الدوري التونسي</option>
<option value="11">الدوري الإماراتي</option>
</select>
<input type="button" id="dark" value="Dark" />
</nav>

<div class="spanner-container hidden">
<div class="spanner-overlay"></div>
<div class="spanner"></div>
</div>

<div class="table dark league-table"></div>

<script>

var responseVal;
var table = document.querySelector(".table.league-table");

var mode = document.querySelector("#dark");

mode.onclick = function() {
if(table.getAttribute("class") == "table league-table") {
    this.value = "Light";
    table.setAttribute("class", "table league-table dark");
} else {
    this.value = "Dark";
    table.setAttribute("class", "table league-table");
}
}

function req(url, callback="") {
var xhr = new XMLHttpRequest();
xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4 && this.status == 200) {
      responseVal = this.response;
        if( callback != "" ) {
            callback();
        }
    }
});

document.querySelector(".spanner-container").setAttribute("class", "spanner-container");

xhr.onprogress = function(e) {
    if(e.loaded >= e.total) {
        document.querySelector(".spanner-container").setAttribute("class", "spanner-container hidden");
    } else {
        console.log(e.loaded.toString()+"-"+e.total.toString());
    }
};

xhr.open("GET", url, true);
xhr.send();
return responseVal;
}

function list(arr) {

let rowElementCount = 10;
table.textContent = "";
let len = arr.length;
// let th = '<div class="tr"><div class="th">pos</div><div class="th">club</div><div class="th">played</div><div class="th">won</div><div class="th">drawn</div><div class="th">lost</div><div class="th">for</div><div class="th">againest</div><div class="th">points</div></div>';

let th = '<div class="tr"><div class="th">مركز</div><div class="th">فريق</div><div class="th">ل</div><div class="th">ف</div><div class="th">ت</div><div class="th">خ</div><div class="th">له</div><div class="th">ضد</div><div class="th">-/+</div><div class="th">نقاط</div></div>';

table.innerHTML = th;

for(i = 0;i < len;i++) {
  var td = [];

  var tr = document.createElement("div");
  tr.setAttribute("class", "tr");

  for(ii=0;ii<rowElementCount;ii++){
      var d = document.createElement("div");
      d.setAttribute("class", "td");
      td.push(d);
  }
  
  td[0].textContent = (parseInt(i+1)).toString();
  
  var img = document.createElement("img")
  img.setAttribute("src", arr[i]["team_badge"]);
  img.setAttribute("style","width:50px;height:50px");
  var span = document.createElement("span");
  span.textContent = arr[i]["team_name"];
  td[1].appendChild(img);
  td[1].appendChild(span);            
  td[2].textContent = arr[i]["overall_league_payed"].toString();
  td[3].textContent = arr[i]["overall_league_W"].toString();
  td[4].textContent = arr[i]["overall_league_D"].toString();
  td[5].textContent = arr[i]["overall_league_L"].toString();
  td[6].textContent = arr[i]["overall_league_GF"].toString();
  td[7].textContent = arr[i]["overall_league_GA"].toString();
  var gd = (parseInt(arr[i]["overall_league_GF"]) - parseInt(arr[i]["overall_league_GA"]))
  td[8].textContent = parseInt(gd) > 0 ? "+"+gd.toString() : gd.toString();
  td[9].textContent = arr[i]["overall_league_PTS"].toString();

  for(ii=0;ii<rowElementCount;ii++){
      tr.appendChild(td[ii]);
  }

  table.appendChild(tr);

}
}

var r = "";

function res() {
let val = JSON.parse(responseVal)
list(val);
}

let select = document.querySelector("select#leagues");

select.addEventListener("change", function(e) {
let val = this.value.trim();
if( val != "" && isFinite(val) ) {
  req("api.php?id="+val.toString(), res);
}
});

req("api.php?id=1", res);

</script>

 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>