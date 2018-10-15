<?php
    $conn = mysqli_connect('localhost', 'root', '', 'gdp_catan');

    echo '<h2 style="text-align: center; padding-top:20px;">Leaderboards</h2>';

    header("Refresh: 3; url=lobby.php");

    if(!$conn){
        die('Connection Failed: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM scores ORDER BY GDP DESC";

    $result = mysqli_query($conn, $sql);
    echo '<link rel="stylesheet" href="bootstrap4/css/bootstrap.min.css">';
    echo '<link rel="stylesheet" href="styles.css">';

    echo "<table>";
    echo "<tr><th>Team Name</th><th>Score</th></tr>";
    foreach($result as $x){
        echo "<tr><td>";
        echo $x['TeamName'];
        echo "</td><td>";
        echo $x['GDP']." Million";
        echo "</td></tr>";
    }

    echo "</table>";

    echo '<script src="bootstrap4/js/popper.min.js"></script>';
    echo '<script src="bootstrap4/js/bootstrap.min.js"></script>';
?>