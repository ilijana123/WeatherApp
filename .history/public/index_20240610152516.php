<?php
function getWeather($city) {
    $api_key = "4455df790ea7c46257f03cd620c87545";
    $api_url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key";
    $api_data = file_get_contents($api_url);
    if ($api_data === false) {
        echo "Failed to fetch data from the API.\n";
        return;
    }
    $weather = json_decode($api_data, true);
    if ($weather === null) {
        echo "Error decoding JSON data.\n";
        return;
    }
    echo "Weather information for $city:\n";
    echo "Temperature: " . ($weather['main']['temp'] - 273.15) . " °C\n";
    echo "Description: " . $weather['weather'][0]['description'] . "\n";
    echo "Humidity: " . $weather['main']['humidity'] . "%\n";
}

if (php_sapi_name() == "cli") {
    // Handling command-line arguments
    if ($argc < 2) {
        echo "Enter city name as an argument.\n";
        exit(1);
    }
    $city = urlencode($argv[1]);
    getWeather($city);
} else {
    // Handling web form submission
    if (isset($_POST["submit"])) {
        if (empty($_POST["city"])) {
            echo "Enter city name.";
        } else {
            $city = urlencode($_POST["city"]);
            getWeather($city);
        }
    }
    // Include HTML form only for web access
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
                <input type="text" name="city" id="">
                <input type="submit" name="submit" value="Check weather">
            </form>
        </section>
    </body>
    </html>
    <?php
}
?>
