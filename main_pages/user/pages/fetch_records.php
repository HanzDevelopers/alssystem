<?php
include '../../../src/db/db_connection.php';

$search = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

$sql = "SELECT * FROM osy_tbl
        WHERE household_members LIKE ? OR birthdate LIKE ? OR age LIKE ? OR
        CONCAT(city_municipality, ' ', barangay, ' ', sitio_zone_purok) LIKE ?
        LIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $search, $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();

$output = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $full_address = $row['city_municipality'] . ' ' . $row['barangay'] . ' ' . $row['sitio_zone_purok'];
        $output .= "<tr>
                        <td>{$row['household_members']}</td>
                        <td>{$row['birthdate']}</td>
                        <td>{$row['age']}</td>
                        <td>{$full_address}</td>
                        <td><button class='btn btn-primary'>View Info</button></td>
                    </tr>";
    }
} else {
    $output .= "<tr><td colspan='5'>No records found</td></tr>";
}

$stmt->close();
$conn->close();

echo $output;
?>
