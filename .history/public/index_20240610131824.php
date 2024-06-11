<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
    <section>
        <form method="post">
            <h1>The Weather App</h1>
            <input type="text" name="city" id="">
            <input type="submit" name="submit" value="Check weather">
        </form>
    </section>
</body>
</html>
<?php
if(isset($_POST["submit"]))
{
    if(empty($_POST["city"])){
        echo "Enter city name: ";
    }
    else
    {
        $city=$_POST["city"];
        $api_key="4455df790ea7c46257f03cd620c87545";
        $api="https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key";
        $api_data=file_get_contents($api);
        print_r($api_data);
        $weather=json_decode($api_data.true);
        print_r($weather);
    }
}
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';
/*
// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
*/
?>