<?php
// barangay_district_map.php

function getDistrict($barangay) {
    $mapping = [
        // District 1
        'Tankulan' => 'District 1',
        'Diklum' => 'District 1',
        'San Miguel' => 'District 1',
        'Ticala' => 'District 1',
        'Lingion' => 'District 1',

        // District 2
        'Alae' => 'District 2',
        'Damilag' => 'District 2',
        'Mambatangan' => 'District 2',
        'Mantibugao' => 'District 2',
        'Minsuro' => 'District 2',
        'Lunocan' => 'District 2',

        // District 3
        'Agusan canyon' => 'District 3',
        'Mampayag' => 'District 3',
        'Dahilayan' => 'District 3',
        'Sankanan' => 'District 3',
        'Kalugmanan' => 'District 3',
        'Lindaban' => 'District 3',

        // District 4
        'Dalirig' => 'District 4',
        'Maluko' => 'District 4',
        'Santiago' => 'District 4',
        'Guilang2' => 'District 4',
    ];

    // Normalize the barangay name for matching
    $barangay_normalized = trim(strtolower($barangay));
    foreach ($mapping as $key => $district) {
        if (strtolower($key) === $barangay_normalized) {
            return $district;
        }
    }
    return 'Unknown District';
}
