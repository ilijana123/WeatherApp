<?php
$weatherInfo = "";

function getWeather($city) {
    global $weatherInfo;
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
    $weatherInfo = "Weather information for $city: <br>";
    $weatherInfo .= "Temperature: " . $tempCelsius . " °C <br>";
    $weatherInfo .= "Description: " . $weather['weather'][0]['description'] . " <br>";
    $weatherInfo .= "Humidity: " . $weather['main']['humidity'] . "% <br>";
}

if (php_sapi_name() == "cli") 
{
    if ($argc < 2) {
        echo "Enter city name as an argument.\n";
        exit(1);
    }
    $city = urlencode($argv[1]);
    getWeather($city);
    echo strip_tags($weatherInfo);
} 
else 
{
    if (isset($_POST["submit"])) 
    {
        if (empty($_POST["city"])) 
        {
            $weatherInfo = "Enter city name.";
        } 
        else 
        {
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
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f0f0f0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            section {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 300px;
            }
            h1 {
                margin-bottom: 20px;
                font-size: 24px;
                color: #333;
            }
            input[type="text"] {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            input[type="submit"] {
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                background-color: #28a745;
                color: #fff;
                cursor: pointer;
                font-size: 16px;
            }
            input[type="submit"]:hover {
                background-color: #218838;
            }
            .weather-info {
                margin-top: 20px;
                padding: 10px;
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 4px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <section>
            <form method="post">
                <h1>The Weather App</h1>
                <input type="text" name="city" id="" value="<?php echo isset($_POST["city"]) ? htmlspecialchars($_POST["city"]) : ''; ?>" placeholder="Enter city name">
                <input type="submit" name="submit" value="Check weather">
            </form>
            <div class="weather-info">
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
