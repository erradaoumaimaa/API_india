<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "india";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

$request = "http://universities.hipolabs.com/search?country=India";
$curl = curl_init();
curl_setopt_array($curl, array( 
    CURLOPT_URL => $request,
    CURLOPT_RETURNTRANSFER => 1 
));
$response = curl_exec($curl); 
$data = json_decode($response);

// print_r($data);

curl_close($curl);

foreach ($data as $p) { 
    // var_dump($p);   
    $name = $p->name;
    $country = $p->country;
    $stmt = $conn->prepare("INSERT INTO india (name, country) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $country);
    $stmt->execute();
}
$conn->close();
?>




