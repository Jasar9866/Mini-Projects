<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Horizon Students</title>

    <style>
        body {
            background-color: #f7f7f7;
        }

        h1 {
            font-family: 'Times New Roman';
            text-align: center;
            color: #333;
        }

        .container {
            padding: 20px;
        }

        .card {
            margin: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.9);
            background-color: #fff;
        }

        .table {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f7f7f7;
        }

        .table tbody tr:nth-child(even) {
            background-color: #e3e3e3;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <?php
        // Include the db and index php files.
        include_once 'db.php';
        include_once 'student.php';

        $database = new Database();
        $db = $database->getConnection();
        $student = new Student($db);

        // Get HTTP method (GET, POST, PUT, DELETE)
        $method = $_SERVER['REQUEST_METHOD'];

        // Handle requests based on the HTTP method
        switch ($method) {
            case 'GET':
                // Handle GET request to retrieve all Horizon students information.
                $result = $student->getStudents();

                if ($result) {
                    echo '<div class="container mt-4">';
                    echo '<h1><b>Horizon Students Details</b></h1>';
                    echo '<table class="table table-bordered">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Index Number</th>';
                    echo '<th>First Name</th>';
                    echo '<th>Last Name</th>';
                    echo '<th>City</th>';
                    echo '<th>District</th>';
                    echo '<th>Province</th>';
                    echo '<th>Email Address</th>';
                    echo '<th>Mobile Number</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    if (is_array($result)) {
                        foreach ($result as $studentData) {
                            echo '<tr>';
                            echo '<td>' . $studentData['Index_No'] . '</td>';
                            echo '<td>' . $studentData['First_Name'] . '</td>';
                            echo '<td>' . $studentData['Last_Name'] . '</td>';
                            echo '<td>' . $studentData['City'] . '</td>';
                            echo '<td>' . $studentData['District'] . '</td>';
                            echo '<td>' . $studentData['Province'] . '</td>';
                            echo '<td>' . $studentData['Email_Address'] . '</td>';
                            echo '<td>' . $studentData['Mobile_Number'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No students found."));
                }
                break;

            case 'POST':
                // Handle POST request to create a new student
                $data = json_decode(file_get_contents("php://input"));

                if (
                    !empty($data->Index_No) &&
                    !empty($data->First_Name) &&
                    !empty($data->Last_Name) &&
                    !empty($data->City) &&
                    !empty($data->District) &&
                    !empty($data->Province) &&
                    !empty($data->Email_Address) &&
                    !empty($data->Mobile_Number)
                ) {
                    $student->index_no = $data->Index_No;
                    $student->first_name = $data->First_Name;
                    $student->last_name = $data->Last_Name;
                    $student->city = $data->City;
                    $student->district = $data->District;
                    $student->province = $data->Province;
                    $student->email = $data->Email_Address;
                    $student->mobile_number = $data->Mobile_Number;

                    if ($student->create()) {
                        http_response_code(201);
                        echo json_encode(array("Student created successfully."));
                    } else {
                        http_response_code(503);
                        echo json_encode(array("Unable to create student."));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("Incomplete data, Please provide all student's details."));
                }
                break;

                // Other cases for PUT and DELETE can remain the same as in your original code.

            case 'PUT':
                // Handle PUT request to update a student
                $data = json_decode(file_get_contents("php://input"));

                if (
                    !empty($data->Index_No) &&
                    !empty($data->First_Name) &&
                    !empty($data->Last_Name) &&
                    !empty($data->City) &&
                    !empty($data->District) &&
                    !empty($data->Province) &&
                    !empty($data->Email_Address) &&
                    !empty($data->Mobile_Number)
                ) {
                    $student->index_no = $data->Index_No;
                    $student->first_name = $data->First_Name;
                    $student->last_name = $data->Last_Name;
                    $student->city = $data->City;
                    $student->district = $data->District;
                    $student->province = $data->Province;
                    $student->email = $data->Email_Address;
                    $student->mobile_number = $data->Mobile_Number;

                    if ($student->update()) {
                        http_response_code(200);
                        echo json_encode(array("Student updated successfully."));
                    } else {
                        http_response_code(503);
                        echo json_encode(array("Unable to update student."));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("Incomplete data, please check."));
                }
                break;

            case 'DELETE':
                // Handle DELETE request to delete a student
                $data = json_decode(file_get_contents("php://input"));

                if (!empty($data->Index_No)) {
                    if ($student->delete($data->Index_No)) {
                        http_response_code(200);
                        echo json_encode(array("Student deleted successfully."));
                    } else {
                        http_response_code(503);
                        echo json_encode(array("Unable to delete student."));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("Missing student Index Number."));
                }
                break;

            default:
                // Invalid request method
                http_response_code(405);
                echo json_encode(array("Method not allowed."));
                break;
        }
        ?>
    </div>
</body>

</html>