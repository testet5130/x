<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      body{background-color:#f4f4f4}

      .hidden{display: none;}

      .spanner-container{position: fixed;top: 0;left: 0%;width: 100%;height: 100%;}
      .spanner-overlay{background: #fff;width: 100%;height: 100%;z-index: 999;opacity: .6;}
      .spanner{position: fixed;top: 40%;left: 50%;border:5px solid #1eaae1;border-radius: 50%;transform: translate(-50%);padding:20px;animation: scalable infinite 1.5s;}
      @keyframes scalable{
          from{padding:0;opacity: 0;}
          to{padding:20px;opacity: 1;}
      }
      
      .table{display: table;width: 90%;margin: 0 auto;text-align: center;}
      .table .tr{display: table-row;}
      .table .tr:first-child{background-color: #00a9dd;color: #fff;}
      .table .tr:nth-child(odd){box-shadow: 0 0 5px #ddd;}
      .table .th,.table .td{display:table-cell;padding: 10px 0;}
      .table .th{font-weight: bold;}
      .table .td:first-child{border-left:solid #00a9dd;}
      .table .td{background-color: #fff;}
      .table .td img{width:50px;height:50px}
      .table .td span{display:block}
      
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
  <div class="spanner-container hidden">
    <div class="spanner-overlay"></div>
    <div class="spanner"></div>
  </div>

  <div class="league">
    <div>
        <select name="league" id="leagues">
            <option value="1">الدوري الانجليزي</option>
            <option value="2">الدوري الاسباني</option>
            <option value="3">الدوري الايطالي</option>
            <option value="4">الدوري الالماني</option>
            <option value="5">الدوري الفرنسي</option>
        </select>
    </div>
    <div class="table league-table">
    </div>

  </div>

  <script>

      var responseVal;

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

      function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 3; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
      }

      function list(arr) {
        
        let table = document.querySelector(".table.league-table");

        table.textContent = "";
        let len = arr.length;
        let th = '<div class="tr"><div class="th">pos</div><div class="th">club</div><div class="th">played</div><div class="th">won</div><div class="th">drawn</div><div class="th">lost</div><div class="th">for</div><div class="th">againest</div><div class="th">points</div></div>';

        table.innerHTML = th;

        for(i = 0;i < len;i++) {
          var td = [];

          var tr = document.createElement("div");
          tr.setAttribute("class", "tr");

          for(ii=0;ii<9;ii++){
              var d = document.createElement("div");
              d.setAttribute("class", "td");
              td.push(d);
          }
          
          td[0].textContent = (parseInt(i+1)).toString();
          td[0].setAttribute("style", "border-left:solid "+getRandomColor());
          
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
          td[8].textContent = arr[i]["overall_league_PTS"].toString();

          for(ii=0;ii<9;ii++){
              tr.appendChild(td[ii]);
          }
        
          var tp = document.createElement("div");
          tp.setAttribute("class", "tr");

          var p = document.createElement("div");
          p.setAttribute("style", "padding:10px 0");

          tp.appendChild(p);
          table.appendChild(tp);

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

</body>
</html>