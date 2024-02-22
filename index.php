<?php

$curl = curl_init();
$show = 'no';

function fahrenheitToCelsius($fahrenheit)
{
    $celsius = (5 / 9) * ($fahrenheit - 32);
    return $celsius;
}

if (isset($_POST['search_city'])) {

    $city = $_POST['city'];


    curl_setopt_array($curl, [
        CURLOPT_URL => "https://open-weather13.p.rapidapi.com/city/" . $city,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: open-weather13.p.rapidapi.com",
            "X-RapidAPI-Key: a20e26e898mshdae5f3ac7e85f95p1db741jsnd9a4e0db0d61"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $show = "yes";
        $weather = json_decode($response, true);
        //print_r($weather);
    }
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Weather App</title>
</head>

<style>
    body {
        padding: 2rem 15%;
        text-align: center;
    }
</style>

<body>
    <h1>Weather App</h1>

    <section>
        <form method="POST" action="index.php">
            <div class="mb-3">

                <input type="text" placeholder="City Name" class="form-control" name="city">
            </div>

            <button type="submit" name="search_city" class="btn btn-primary">Search</button>
        </form>
    </section>

    <?php
    if ($show === "yes") {
    ?>

        <h1><?php print_r($weather['name']) ?></h1>
        <h4><?php print_r($weather['weather'][0]['description']) ?></h4>

        <table class="table">
            <thead>
                <tr>

                    <th scope="col"><?php echo $weather['wind']['speed'] . 'mph' ?></th>
                    <th scope="col">Now</th>

                </tr>
            </thead>
            <tbody>
                <tr>

                    <td><?php echo $weather['main']['pressure'] . 'hpa' ?></td>
                    <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud" viewBox="0 0 16 16">
                            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                        </svg>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $weather['clouds']['all'] . '%' ?>
                    </td>
                    <td><?php
                        $temp = $weather['main']['temp'];
                        echo fahrenheitToCelsius($temp) . '°C';
                        ?></td>
                </tr>
            </tbody>
        </table>

    <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>