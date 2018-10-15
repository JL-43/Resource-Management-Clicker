<?php
    $conn = mysqli_connect('localhost', 'root', '', 'gdp_catan');

    if(!$conn){
        die('Connection Failed: ' . mysqli_connect_error());
    }

    $team = $_POST['team'];
    $gdp = $_POST['gdp'];

    $sql = "UPDATE scores SET GDP='".$gdp."' WHERE TeamName='".$team."'";

    if ($conn == TRUE) {
        mysqli_query($conn, $sql);
    } else {
    }
    
?>