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
    'diclum ' => 'District 1',
    'Diclum ' => 'District 1',
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

// Prepare the SQL query based on the search term
$sql = "
    SELECT 
        l.barangay AS Barangay,
        l.housenumber AS HouseNumber,
        l.estimated_family_income AS EstimatedIncome,
        COUNT(m.member_id) AS HouseholdMembers
    FROM 
        location_tbl AS l
    JOIN 
        members_tbl AS m ON l.record_id = m.record_id
    WHERE 
        l.estimated_family_income < 20000
";

if (!empty($searchTerm)) {
    // Add search conditions for barangay and housenumber
    $sql .= " AND (l.barangay LIKE '%$searchTerm%' OR l.housenumber LIKE '%$searchTerm%')";
}

$sql .= " 
    GROUP BY 
        l.barangay, l.housenumber
    ORDER BY 
        l.barangay ASC
    LIMIT $offset, $itemsPerPage
";

$result = $conn->query($sql);

// Get total records for pagination
$totalRecordsSql = "
    SELECT COUNT(DISTINCT l.housenumber) AS total 
    FROM 
        location_tbl AS l
    WHERE 
        l.estimated_family_income < 20000
";

if (!empty($searchTerm)) {
    // Update total records SQL to include search conditions
    $totalRecordsSql .= " AND (l.barangay LIKE '%$searchTerm%' OR l.housenumber LIKE '%$searchTerm%')";
}

$totalRecordsResult = $conn->query($totalRecordsSql);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Below 20,000</title>
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
        <h2 class="mb-4">Households with Income Below 20,000</h2>

        <!-- Search Form -->
        <form class="mb-4" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Barangay or House Number">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>District</th>
            <th>Barangay</th>
            <th>House Number</th>
            <th>Estimated Family Income</th>
            <th>Household Members Count</th>
            <th>Action</th> <!-- Added Action Column -->
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $district = $barangayDistrictMapping[$row['Barangay']] ?? 'Unknown District';

                // Query to get a single member_id for the same house number
                $memberIdQuery = "
                    SELECT 
                        m.member_id 
                    FROM 
                        members_tbl AS m
                    JOIN 
                        location_tbl AS l ON m.record_id = l.record_id
                    WHERE 
                        l.housenumber = '{$row['HouseNumber']}'
                    LIMIT 1
                ";
                $memberIdResult = $conn->query($memberIdQuery);
                $memberIdRow = $memberIdResult->fetch_assoc();
                $memberId = $memberIdRow['member_id']; // Get a single member ID

                echo "<tr>
                        <td>{$district}</td>
                        <td>{$row['Barangay']}</td>
                        <td>{$row['HouseNumber']}</td>
                        <td>{$row['EstimatedIncome']}</td>
                        <td>{$row['HouseholdMembers']}</td>
                        <td>
                            <a href='incomebelow20,000.php?member_id={$memberId}' class='btn btn-primary'>View Info</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
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