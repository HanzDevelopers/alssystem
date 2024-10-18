<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV File</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Upload CSV File</h2>
            </div>
            <div class="card-body">
                <form action="form_upload_csv_process.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Choose CSV file:</label>
                        <input type="file" class="form-control-file" name="file" accept=".csv" required>
                    </div>
                    <button type="submit" name="upload" class="btn btn-success btn-block">Upload</button>
                </form>

                <!-- Example CSV format table -->
                <div class="mt-4">

                    <h4 class="text-center">Example CSV Format</h4>
                <p class="text-center">Make sure to follow the CSV format below to ensure successful file upload and data processing.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>encoder_name</th>
                                    <th>date_encoded</th>
                                    <th>province</th>
                                    <th>city_municipality</th>
                                    <th>barangay</th>
                                    <th>sitio_zone_purok</th>
                                    <th>housenumber</th>
                                    <th>estimated_family_income</th>
                                    <th>notes</th>
                                    <th>household_members</th>
                                    <th>relationship_to_head</th>
                                    <th>birthdate</th>
                                    <th>age</th>
                                    <th>gender</th>
                                    <th>civil_status</th>
                                    <th>person_with_disability</th>
                                    <th>ethnicity</th>
                                    <th>religion</th>
                                    <th>highest_grade_completed</th>
                                    <th>currently_attending_school</th>
                                    <th>grade_level_enrolled</th>
                                    <th>reasons_for_not_attending_school</th>
                                    <th>can_read_write_simple_messages_inanylanguage</th>
                                    <th>occupation</th>
                                    <th>work</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>2023-09-28</td>
                                    <td>Province A</td>
                                    <td>City B</td>
                                    <td>Barangay C</td>
                                    <td>Zone 1</td>
                                    <td>123</td>
                                    <td>10000</td>
                                    <td>Sample note</td>
                                    <td>Jane Doe</td>
                                    <td>Spouse</td>
                                    <td>1990-01-01</td>
                                    <td>33</td>
                                    <td>Female</td>
                                    <td>Married</td>
                                    <td>No</td>
                                    <td>Ethnic Group A</td>
                                    <td>Religion X</td>
                                    <td>High School</td>
                                    <td>Yes</td>
                                    <td>Grade 10</td>
                                    <td>N/A</td>
                                    <td>Yes</td>
                                    <td>Yes</td>
                                    <td>Teacher</td>
                                    <td>No</td>
                                </tr>
                                <!-- You can add more example rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
