<?php
// Database connection
include '../../../src/db/db_connection.php';

// Barangay to District mapping
$barangayDistrictMapping = [
    'Tankulan' => 'District 1',
    'Tankulan ' => 'District 1',
    'tankulan' => 'District 1',
    'tankulan ' => 'District 1',
    'Diklum' => 'District 1',
    'Diklum ' => 'District 1',
    'diklum' => 'District 1',
    'diklum ' => 'District 1',
    'San Miguel' => 'District 1',
    'San Miguel ' => 'District 1',
    'san Miguel' => 'District 1',
    'san Miguel ' => 'District 1',
    'san miguel' => 'District 1',
    'san miguel ' => 'District 1',
    'Ticala' => 'District 1',
    'Ticala ' => 'District 1',
    'ticala' => 'District 1',
    'ticala ' => 'District 1',
    'Lingion' => 'District 1',
    'Lingion ' => 'District 1',
    'lingion' => 'District 1',
    'lingion ' => 'District 1',
    'Alae' => 'District 2',
    'Alae ' => 'District 2',
    'alae' => 'District 2',
    'alae ' => 'District 2',
    'Damilag' => 'District 2',
    'Damilag ' => 'District 2',
    'damilag' => 'District 2',
    'damilag ' => 'District 2',
    'Mambatangan' => 'District 2',
    'Mantibugao' => 'District 2',
    'Mantibugao ' => 'District 2',
    'mantibugao' => 'District 2',
    'mantibugao ' => 'District 2',
    'Minsuro' => 'District 2',
    'Minsuro ' => 'District 2',
    'minsuro' => 'District 2',
    'minsuro ' => 'District 2',
    'Lunocan' => 'District 2',
    'Lunocan ' => 'District 2',
    'lunocan ' => 'District 2',
    'lunocan' => 'District 2',
    'Agusan canyon ' => 'District 3',
    'Agusan Canyon ' => 'District 3',
    'Agusan-canyon ' => 'District 3',
    'Agusan-Canyon ' => 'District 3',
    'Agusan canyon' => 'District 3',
    'Agusan Canyon' => 'District 3',
    'Agusan-canyon' => 'District 3',
    'Agusan-Canyon' => 'District 3',
    'Mampayag' => 'District 3',
    'Mampayag ' => 'District 3',
    'mampayag' => 'District 3',
    'mampayag ' => 'District 3',
    'Dahilayan' => 'District 3',
    'Dahilayan ' => 'District 3',
    'dahilayan' => 'District 3',
    'dahilayan ' => 'District 3',
    'Sankanan' => 'District 3',
    'Sankanan ' => 'District 3',
    'sankanan' => 'District 3',
    'sankanan ' => 'District 3',
    'Kalugmanan' => 'District 3',
    'Kalugmanan ' => 'District 3',
    'kalugmanan' => 'District 3',
    'kalugmanan ' => 'District 3',
    'Lindaban' => 'District 3',
    'Lindaban ' => 'District 3',
    'lindaban' => 'District 3',
    'lindaban ' => 'District 3',
    'Dalirig' => 'District 4',
    'Dalirig ' => 'District 4',  // Ensure this is added
    'dalirig' => 'District 4',
    'dalirig ' => 'District 4',
    'Maluko' => 'District 4',
    'Maluko ' => 'District 4',
    'maluko' => 'District 4',
    'maluko ' => 'District 4',
    'Santiago' => 'District 4',
    'santiago' => 'District 4',
    'Santiago ' => 'District 4',
    'santiago ' => 'District 4',
    'Guilang2' => 'District 4',
    'Guilang-Guilang' => 'District 4',
    'guilang-guilang' => 'District 4',
    'Guilang-guilang' => 'District 4',
    'Guilang-Guilang ' => 'District 4',
    'guilang-guilang ' => 'District 4',
    'Guilang-guilang ' => 'District 4',
];

// Initialize search variable
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination variables
$itemsPerPage = 10; // Number of items to display per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $itemsPerPage; // Calculate offset for SQL

// Fetch data from the database for individuals with no occupation
$sql = "
    SELECT 
        m.household_members AS Name,
        m.age AS Age,
        b.occupation AS Occupation,
        l.barangay AS Barangay,
        CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) AS Address
    FROM 
        background_tbl AS b
    JOIN 
        members_tbl AS m ON b.member_id = m.member_id
    JOIN 
        location_tbl AS l ON m.record_id = l.record_id
    WHERE 
        b.occupation IN ('NO', 'No', 'no') 
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') 
        OR m.age LIKE '%$searchTerm%'
        OR l.barangay LIKE LOWER('%$searchTerm%') 
        OR CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))
    ORDER BY 
        m.household_members ASC
    LIMIT $offset, $itemsPerPage
";

$result = $conn->query($sql);

// Get total records for pagination
$totalRecordsSql = "
    SELECT COUNT(*) AS total 
    FROM background_tbl AS b
    JOIN members_tbl AS m ON b.member_id = m.member_id
    JOIN location_tbl AS l ON m.record_id = l.record_id
    WHERE 
        b.occupation IN ('NO', 'No', 'no') 
        AND YEAR(l.date_encoded) = YEAR(CURDATE())
        AND (LOWER(m.household_members) LIKE LOWER('%$searchTerm%') 
        OR m.age LIKE '%$searchTerm%'
        OR l.barangay LIKE LOWER('%$searchTerm%') 
        OR CONCAT(l.housenumber, ' ', l.sitio_zone_purok, ', ', l.barangay, ', ', l.city_municipality, ', ', l.province) LIKE LOWER('%$searchTerm%'))
";

$totalRecordsResult = $conn->query($totalRecordsSql);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Occupation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <style>
        /* Custom styles for the table header */
        .table thead th {
            background-color: #f8f9fa; /* Light background for the header */
            color: #343a40; /* Dark text color */
        }
        .table th, .table td {
            vertical-align: middle; /* Center-align text in cells */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">No Occupation</h2>
        
        <!-- Search Form -->
        <form class="mb-4" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Name, Age, Address">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Occupation</th>
                    <th>District</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $district = $barangayDistrictMapping[$row['Barangay']] ?? 'Unknown District';
                        echo "<tr>
                                <td>{$row['Name']}</td>
                                <td>{$row['Age']}</td>
                                <td>{$row['Occupation']}</td>
                                <td>{$district}</td>
                                <td>{$row['Address']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchTerm); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
</body>
</html>
