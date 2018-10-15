<html>
<head>
<title>Test</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
<?php
    $conn = mysqli_connect('localhost', 'root', '', 'gdp_catan');

    if(!$conn){
        die('Connection Failed: ' . mysqli_connect_error());
    }

    $team = $_POST['teamname'];

    $sql = "INSERT INTO scores (TeamName) VALUES ('".$team."')";

    if ($conn == TRUE) {
        mysqli_query($conn, $sql);
    } else {
    }

?>
<script type="text/javascript">

var resource = [0,0,0,0,0];
var producer = [0,0,0,0,0];
var producerPow = [0,0,0,0,0];
var clickPow = [1,1,1,1,1];
var producerMult = [1,1,1,1,1];
var clickMult= [1,1,1,1,1]
var require = [[5,0,0,0,0],[3,2,0,0,1],[2,2,1,0,1],[2,0,2,2,1],[3,0,0,3,2]];
var timer = 599;
var ievent = 1;
var endMult = 1;



function clicked1(type){
    resource[type] += Math.round(clickPow[type] * clickMult[type]);
    update1(type);
}

function clicked2(type){
    if(require[type][0] <= resource[0]){
        if(require[type][1] <= resource[1]){
            if(require[type][2] <= resource[2]){
                if(require[type][3] <= resource[3]){
                    if(require[type][4] <= resource[4]){
                        producer[type] += 1;
                        producerPow[type] = producer[type] * (1 + Math.floor(producer[type]/5));
                        clickPow[type] = 1 + Math.floor(producer[type]/5);
                        update2(type);
                        for(var i = 0; i < 5; i++){
                            resource[i] -= require[type][i];
                            update1(i);
                            require[type][i] += Math.ceil(require[type][i]*0.45);
                            try{
                                document.getElementById("req"+type+i).innerHTML = ""+require[type][i];
                            }
                            catch(err){
                            }
                        }
                    }
                }
            }
        }
    }
}

function update1(type){
    document.getElementById("resource"+type).innerHTML = resource[type];
}

function update2(type){
    document.getElementById("producerAmt"+type).innerHTML = producer[type];
    document.getElementById("producerPow"+type).innerHTML = Math.round(producerPow[type] * producerMult[type]);
    document.getElementById("click"+type).innerHTML = Math.round(clickPow[type] * clickMult[type]);
}

function update3(){
    var minute = Math.floor(timer/60);
    var seconds = timer%60;
    document.getElementById("timer").innerHTML = minute+":";
    if(seconds < 10){
        document.getElementById("timer").innerHTML += "0"+seconds;
    }
    else{
        document.getElementById("timer").innerHTML += seconds;
    }
}

function stop(){
    var butts = document.getElementsByTagName("button");
    var size = butts.length;
    for(var i = 0; i < size; i++){
        butts[i].disabled = true;
    }
}

function eventer(){
    
    if(ievent == 1 && timer == 480){
        document.getElementById("EventView").innerHTML ="<b>OVERPOPULATION</b> - +10k 👨‍🏭, 1/2 production for Fisheries and Farms.<br>";
        lock = 0;
        resource[0] += 10000;
        producerMult[1] = 0.5;
        producerMult[2] = 0.5;
        document.getElementById("producerPow1").style.color = "red";
        document.getElementById("producerPow2").style.color = "red";
        update2(1);
        update2(2);
        ievent = 2;
    }
    if(ievent == 2 && timer == 360){
        document.getElementById("EventView").innerHTML = "<b>RED TIDE</b> - Lose 75% of your current 🐟.<br>";
        lock = 0;
        producerMult[1] = 1;
        producerMult[2] = 1;
        resource[1] = Math.round(resource[1]*0.25);
        document.getElementById("producerPow1").style.color = "black";
        document.getElementById("producerPow2").style.color = "black";
        update1(0);
        update2(1);
        update2(2);
        ievent = 3;
    }
    if(ievent == 3 && timer == 240){
        document.getElementById("EventView").innerHTML ="<b>LANDSLIDE</b> - 1/2 production for Schools and Mineshafts.<br>";
        lock = 0;
        producerMult[0] = 0.5;
        producerMult[3] = 0.5;
        document.getElementById("producerPow0").style.color = "red";
        document.getElementById("producerPow3").style.color = "red";
        update2(0);
        update2(3);
        ievent = 4;
    }
    if(ievent == 4 && timer == 120){
        document.getElementById("EventView").innerHTML ="<b>GOLD RUSH</b> - Quadruple clicking power when Drilling.<br>";
        lock = 0;
        producerMult[0] = 1;
        producerMult[3] = 1;
        clickMult[3] = 4;
        document.getElementById("producerPow0").style.color = "black";
        document.getElementById("producerPow3").style.color = "black";
        document.getElementById("click3").style.color = "#7FFF00";
        update2(0);
        update2(3);
        ievent = 5;
    }
    if(ievent == 5 && timer == 60){
        document.getElementById("EventView").innerHTML = "<b>HIGH DEMAND</b> - Value of 🐟 increased by 500%.<br>";
        lock = 0;
        clickMult[3] = 1;
        endMult = 5;
        document.getElementById("click3").style.color = "white";
        update2(3);
        ievent = 6;
    }
}

function GDP(){
    var gdp = 0;
    gdp += resource[0]*0.01;
    gdp += resource[1]*0.5 * endMult;
    gdp += resource[2]*1;
    gdp += resource[3]*2.5;
    gdp += resource[4]*5;
    gdp += producer[0]*1;
    gdp += producer[1]*5;
    gdp += producer[2]*10;
    gdp += producer[3]*25;
    gdp += producer[4]*50;
    document.getElementById("hide1").value = Math.round(gdp*100)/100;;
    if(gdp >= 1000){
        document.getElementById("GDPHead").innerHTML = "Billion";
        gdp /= 1000;
    }
    else{
        document.getElementById("GDPHead").innerHTML = "Million";
    }
    gdp = Math.round(gdp*100)/100;
    eventer();
    document.getElementById("gdp").innerHTML = gdp;
    if(timer%10 == 0){
        var frm = $('#info');
        $.ajax({
            type: 'POST',
            url: 'data.php',
            data: frm.serialize(),
            success: function(){
                console.log("GDP backed up");
            },
        });
    }
}

function tick(){
    setInterval(function(){ if(timer >= 0){for(var i = 0; i < 5; i++){resource[i] += Math.round(producerPow[i]*producerMult[i]); update1(i); GDP(); update3();} timer -= 1 }else{stop()}}, 1000);
}

</script>
</head>
<body onload="tick()">

<div class="sticky-top header">
    <div class="container-fluid"style="padding-top: 10px;">
        <div class="row" style="width: 100%;">
            <div id="timerDisplay" class="col-xs-6 timer" style="padding-right: 60px;">
                <h5 id="timer">10:00</h5>
            </div>
            <div id="producerInfo" class="col-xs-6 producerInfo">
                Schools: <label id="producerAmt0">0</label> producing <label id="producerPow0">0</label> 👨‍🏭/sec. You have 👨‍🏭: <label id="resource0">0</label><br>
                Fisheries: <label id="producerAmt1">0</label> producing <label id="producerPow1">0</label> 🐟/sec.  You have 🐟: <label id="resource1">0</label><br>
                Farms: <label id="producerAmt2">0</label> producing <label id="producerPow2">0</label> 🌽/sec.  You have 🌽: <label id="resource2">0</label><br>
                Mineshafts: <label id="producerAmt3">0</label> producing <label id="producerPow3">0</label> 💎/sec.  You have 💎: <label id="resource3">0</label><br>
                Factories: <label id="producerAmt4">0</label> producing <label id="producerPow4">0</label> ⚙️/sec.  You have ⚙️: <label id="resource4">0</label><br>
            </div>
        </div>
        <div class="row">
            <div class="teamname">
                <h6>Team Name: <?php echo $team;?> </h6> 
            </div>

            <div id="GDPDiv" class="GDPDiv">
                <h6>GDP: Php <label id="gdp">0</label> <label id="GDPHead">Million</label></h6>
            </div>
        </div>
    </div>
    <div id="Events" class="Events">
        <h6>Events: </h6><br>
        <p id="EventView"></p>
    </div>
</div>


<div class="resources container-fluid">
    <div class="row" style="width: 100%;">
        <div class="col-xs-12">
            <h3>Resources:</h3>
        </div>
    </div>
    <div class="row" style="width: 100%;">
        <div id="resourceButtons" class="col-xs-12">
            <button class="btn btn-primary btn-resources" onclick="clicked1(0)">Teach + <label id="click0">1</label> 👨‍🏭</label> </button>
            <button class="btn btn-primary btn-resources" onclick="clicked1(1)">Fish +<label id="click1">1</label> 🐟</button>
            <button class="btn btn-primary btn-resources" onclick="clicked1(2)">Harvest +<label id="click2">1</label> 🌽</button>
            <button class="btn btn-primary btn-resources" onclick="clicked1(3)">Drill +<label id="click3">1</label> 💎</button>
            <button class="btn btn-primary btn-resources" onclick="clicked1(4)">Craft +<label id="click4">1</label> ⚙️</button>
        </div>
    </div>
</div>

<div class="resources container-fluid">
        <div class="row" style="width: 100%;">
            <div class="col-xs-12">
                <h3>Producers:</h3>
            </div>
        </div>
        <div class="row" style="width: 100%;">
            <div id="producerButtons" class="col-xs-12">
                <button class="btn btn-primary" onclick="clicked2(0)">School <br> Requirements: <br> <label id="req00">5</label> 👨‍🏭</button>
                <button class="btn btn-primary" onclick="clicked2(1)">Fishery <br> Requirements: <br> <label id="req10">3</label> 👨‍🏭 <br> <label id="req11">2</label> 🐟 <br> <label id="req14">1</label> ⚙️</button> 
                <button class="btn btn-primary" onclick="clicked2(2)">Farm <br> Requirements: <br> <label id="req20">2</label> 👨‍🏭 <br> <label id="req21">2</label> 🐟 <br> <label id="req22">1</label> 🌽 <br> <label id="req24">1</label> ⚙️</button>
                <button class="btn btn-primary" onclick="clicked2(3)">Mineshaft <br> Requirements: <br> <label id="req30">2</label> 👨‍🏭 <br> <label id="req32">2</label> 🌽 <br> <label id="req33">2</label> 💎 <br> <label id="req34">1</label> ⚙️</button> 
                <button class="btn btn-primary" onclick="clicked2(4)">Factory <br> Requirements: <br> <label id="req40">3</label> 👨‍🏭 <br> <label id="req43">3</label> 💎 <br> <label id="req44">2</label> ⚙️</button> 
            </div>
        </div>
    </div>

<form name="info" id="info">
    <input type="hidden" name="gdp" value = 0 id="hide1">
    <?php
        echo "<input type='hidden' name='team' value='".$team."' id='hide2'>";
    ?>
</form>
<script src="bootstrap4/js/jquery-3.3.1.js">
<script src="bootstrap4/js/popper.min.js"></script>
<script src="bootstrap4/js/bootstrap.min.js"></script>
</body>
</html>