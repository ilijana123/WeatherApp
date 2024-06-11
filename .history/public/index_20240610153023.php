<?php
$weatherInfo = "";

function getWeather($city) {
    global $weatherInfo; // Use global variable to store the weather info
    $api_key = "4455df790ea7c46257f03cd620c87545";
    $api_url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key";
    $api_data = file_get_contents($api_url);
    if ($api_data === false) {
        $weatherInfo = "Failed to fetch data from the API.\n";
        return;
    }
    $weather = json_decode($api_data, true);
    if ($weather === null) {
        $weatherInfo = "Error decoding JSON data.\n";
        return;
    }
    $tempCelsius = $weather['main']['temp'] - 273.15;
    $weatherInfo = "Weather information for $city:<br>";
    $weatherInfo .= "Temperature: " . $tempCelsius . " °C<br>";
    $weatherInfo .= "Description: " . $weather['weather'][0]['description'] . "<br>";
    $weatherInfo .= "Humidity: " . $weather['main']['humidity'] . "%<br>";
}

if (php_sapi_name() == "cli") {
    if ($argc < 2) {
        echo "Enter city name as an argument.\n";
        exit(1);
    }
    $city = urlencode($argv[1]);
    getWeather($city);
    echo strip_tags($weatherInfo); // Remove HTML tags for CLI output
} else {
    if (isset($_POST["submit"])) {
        if (empty($_POST["city"])) {
            $weatherInfo = "Enter city name.";
        } else {
            $city = urlencode($_POST["city"]);
            getWeather($city);
        }
    }
    ?>
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
                <input type="text" name="city" id="" value="<?php echo isset($_POST["city"]) ? htmlspecialchars($_POST["city"]) : ''; ?>">
                <input type="submit" name="submit" value="Check weather">
            </form>
            <div>
                <?php
                if (!empty($weatherInfo)) {
                    echo $weatherInfo;
                }
                ?>
            </div>
        </section>
    </body>
    </html>
    <?php
}
?>
