<?php


    require("config.php");



    if (isset($_GET["id"])){

        $sth = $db->prepare("select * from getHtml where hId = :hId");
        $sth->bindParam("hId", $_GET["id"], PDO::PARAM_INT);  
        $sth->execute();

        $rows = $sth->fetch();

        $sthTwo = $db->prepare("select * from rainfall where city = :city");
        $sthTwo->bindParam("city", $rows['city'], PDO::PARAM_STR,50);  
        $sthTwo->execute();

        $sthThree = $db->prepare("select * from weather where city = :city");
        $sthThree->bindParam("city", $rows['city'], PDO::PARAM_STR,50);  
        $sthThree->execute();

        $nowWeather = $sthThree->fetch();

        $db = null;

    }else{
        include_once("getData.php");
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人氣象站</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.cwb.gov.tw/V8/assets/css/main.css?v=20200415">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://www.cwb.gov.tw/V8/assets/js/function-tab-jump.js"></script>
    
</head>
<body >


    <nav class="navbar navbar-expand-md navbar-dark bg-primary">

    <a href="http://localhost:8000/RD1_Assignment/" class="navbar-brand">個人氣象站</a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">

        <ul class="navbar-nav">

            <li class="nav-item dropdown active" style="margin-left: 50px;">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= isset($rows['city']) ? $rows['city']:"請選擇城市" ?>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="?id=1">基隆市</a>
                    <a class="dropdown-item" href="?id=2">臺北市</a>
                    <a class="dropdown-item" href="?id=3">新北市</a>
                    <a class="dropdown-item" href="?id=4">桃園市</a>
                    <a class="dropdown-item" href="?id=5">新竹市</a>
                    <a class="dropdown-item" href="?id=6">新竹縣</a>
                    <a class="dropdown-item" href="?id=7">苗栗縣</a>
                    <a class="dropdown-item" href="?id=8">臺中市</a>
                    <a class="dropdown-item" href="?id=9">彰化縣</a>
                    <a class="dropdown-item" href="?id=10">南投縣</a>
                    <a class="dropdown-item" href="?id=11">雲林縣</a>
                    <a class="dropdown-item" href="?id=12">嘉義市</a>
                    <a class="dropdown-item" href="?id=13">嘉義縣</a>
                    <a class="dropdown-item" href="?id=14">臺南市</a>
                    <a class="dropdown-item" href="?id=15">高雄市</a>
                    <a class="dropdown-item" href="?id=16">屏東縣</a>
                    <a class="dropdown-item" href="?id=17">宜蘭縣</a>
                    <a class="dropdown-item" href="?id=18">花蓮縣</a>
                    <a class="dropdown-item" href="?id=19">台東縣</a>
                    <a class="dropdown-item" href="?id=20">澎湖縣</a>
                    <a class="dropdown-item" href="?id=21">金門縣</a>
                    <a class="dropdown-item" href="?id=22">連江縣</a>

                </div>
            </li>


        </ul>

    </div>
    </nav>

    <div id="cityImg" style="float:left;"> 
        
    </div>

    


    <div id="weather" style="float:left;">
        <?= $rows['html'] ?>
    </div>

    <div id="today" style="background:	#CCCCFF;">
        <p class="p"></p>
    </div>

    <?php if( isset($_GET["id"]) ) { ?>

        <div class="nav-item dropdown" style="clear: both; background:#187ac8;">
            <a style="width:150px; margin:auto;" id="day" class="nav-link dropdown-toggle text-white text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                未來兩天天氣
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin: auto;">
                <a class="dropdown-item" type="button" onclick="tomorrow('明天')" >明天</a>
                <a class="dropdown-item" type="button" onclick="tomorrow('後天')" >後天</a>
            </div>

            <table style="margin-top: 0px;" style="margin-top: 50px;" class="table table-hover table-striped">

                <tbody>
                    <tr id="twoDayId"></tr>
                </tbody>

            </table>

        </div>
    <?php } ?>

    <div id="rain">

        <table style="margin-top: 50px;" class="table table-hover table-striped">

            <thead>
                 <tr>
                    <th>城市</th>
                    <th>觀測站</th>
                    <th>前1小時雨量</th>
                    <th>前24小時雨量</th>
                </tr>
            </thead>

            <tbody>
                <?php if( isset($_GET["id"]) ) {
                    while($rainfall = $sthTwo->fetch() ) {
                ?>
                        <tr>
                            <td><?= $rainfall['city'] ?></td>
                            <td><?= $rainfall['station'] ?></td>
                            <td><?= $rainfall['hour'] ?></td>
                            <td><?= $rainfall['day'] ?></td>
                        </tr>
                <?php } } ?>
            </tbody>

        </table>


    </div>



<script>

    $(function(){


        var weather = $("#weather").text();


        if(weather.length != 13){

            var i;

            //動態加載畫面-------------------------------------------------------


                for (i=0;i<14;i++){
                    var svg = $("img").eq(i).prop("src");
                    svg = svg.replace("http://localhost:8000","");
                    $("img").eq(i).prop("src","https://www.cwb.gov.tw"+svg);
                    $("i").remove();
                    $(".tem-F").remove();
                } 
    
                $("#cityImg").html("<img id='img' style='display:none;' src='image/<?= $_GET["id"] ?>.jpg'>");

                setTimeout(function() {
                    var imgWidth = $("#img").width();
                    var imgHeight = $("#img").height();
                    imgWidth = imgWidth/(imgHeight/213);
                    $("#today").css({"width":imgWidth,"height":"177px","margin-top":"213px","position":"absolute","padding-left":"10px"});
                    var nowWeather = "<?= $nowWeather['now'] ?>";

                    nowWeather = nowWeather.replace(/。/g,"<br>");

                    $(".p").html("<h4 class='text-primary'>現在天氣：</h4>"+nowWeather);
                    $("#img").css({"width":imgWidth,"height":"213px","display":"block"});
                    imgWidth = 1425-imgWidth;
                    $("#weather").css({"float":"left","width":imgWidth});
                    
                }, 250);

            //--------------------------------------------------------------------------動態加載畫面



            //滑鼠移動顯示詳細----------------------------------------------------

                for(i=0;i<14;i++){
                    $("td").eq(i).addClass("hover");
                }

                $(".hover").mouseover(function(){
                    var parent = $(this).parent().prop("class");
                    var eq;

                    var w = <?= json_encode($nowWeather) ?>;

                    if (parent == "day"){
                        eq = $(this).index();
                        eq += 3;
                        $(this).append("<div class='toast weekToast' data-autohide='false'><div class='toast-header text-primary'>天氣概況</div><div class='toast-body'><small>"+w[eq]+"</small></div></div>")
                        $('.weekToast').toast('show');
                    }else{
                        eq = $(this).index();
                        eq += 10;
                        $(this).append("<div class='toast weekToast' data-autohide='false'><div class='toast-header text-primary'>天氣概況</div><div class='toast-body'><small>"+w[eq]+"</small></div></div>")
                        $('.weekToast').toast('show');
                    }

                })

                $(".hover").mouseout(function(){
                    $('.weekToast').remove();
                })

            //--------------------------------------------------------滑鼠移動顯示詳情
            
            

        }else{
            $("#rain").hide();
        }

    })



    //未來兩天(明天|後天)
    function tomorrow(day){
        $("#twoDayId").empty();

        $("#day").text(day);
        var id = "<?= $_GET["id"] ?>";

        if (day == "明天") var flag = 0;
        else var flag  = 1;

        var city = "<?= $rows['city'] ?>";

        dataList = {
            flag: flag,
            city: city
        }

        $.ajax({
            type: "post",
            url: "getTwoDayAjax.php",
            data: dataList,
            dataType: 'json',
            success: function(e){
                var i;
                var time = ["00:00-03:00","03:00-06:00","06:00-09:00","09:00-12:00","12:00-15:00","15:00-18:00","18:00-21:00","21:00-24:00"];

                //明天
                if (flag == 0){
                    for (i=2;i<10;i++){
                        var weather = e[i].replace(/。/g,"<br>");
                        $("#twoDayId").append("<td style='padding: 0 3px;'><div class='toast weatherToast' data-autohide='false'><div class='toast-header'><h5 class='text-primary'>"+time[i-2]+"</h5></div><div class='toast-body'><small>"+weather+"</small></div></div></td>");
                    }
                    $('.weatherToast').toast('show');
                }
                //後天
                else{
                    for (i=10;i<18;i++){
                        var weather = e[i].replace(/。/g,"<br>");
                        $("#twoDayId").append("<td style='padding: 0 3px;'><div class='toast weatherToast' data-autohide='false'><div class='toast-header'><h5 class='text-primary'>"+time[i-10]+"</h5></div><div class='toast-body'><small>"+weather+"</small></div></div></td>");
                    }
                    $('.weatherToast').toast('show');
                }
            }
        })
    }

</script>


</body>
</html>