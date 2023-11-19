<!DOCTYPE html>
<html>

<head>
    <title>Province Data in China</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;

        }

        h1 {
            font-family: 'Times New Roman';
            text-align: center;
            color: #333;
        }

        .table {
            background-color: #fff;
            box-shadow: 6px 6px 6px rgba(0.3, 0.3, 0.3, 0.3); 
        }

        .table th,
        .table td {
            text-align: center;
            padding: 5px; 
            font-size: 14px; 
        }

        .table-responsive {
            max-height: 600px; /* Set a height for the table to enable scrolling */
            overflow-y: auto; 
        }

        .thead-dark {
            background-color: #343a40;
            color: white; 
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center"><b>Latitude and Longitude for Each Province in China</b></h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark sticky-top">
                    <tr style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">
                        <th>Province Name</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $apiKey = 'f854d839d5msh5c2a1d0064b4392p142469jsn13678ef23fbf'; // Replace with the private or individual API-Key.
                    $apiUrl = 'https://covid-19-statistics.p.rapidapi.com/provinces?iso=CHN';

                    $ch = curl_init($apiUrl);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'X-RapidAPI-Host: covid-19-statistics.p.rapidapi.com',
                        'X-RapidAPI-Key: ' . $apiKey
                    ]);

                    $response = curl_exec($ch);
                    curl_close($ch);

                    $data = json_decode($response, true);

                    if (isset($data['data'])) {
                        foreach ($data['data'] as $province) {
                            echo '<tr>';
                            echo '<td>' . $province['province'] . '</td>';
                            echo '<td>' . $province['lat'] . '</td>';
                            echo '<td>' . $province['long'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No data available</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

