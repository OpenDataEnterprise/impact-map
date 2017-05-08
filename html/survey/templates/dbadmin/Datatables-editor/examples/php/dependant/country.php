<?php

$data = [
    'options' => [
        'org_country_info.org_hq_country' => [
            "Kosovo",
            "Liberia"
        ]
    ],

    'values': [
        'org_country_info.org_hq_country' => "Kosovo",
        'org_country_info.org_hq_country_income' => "Higher Test"
    ]
];

echo json_encode($data);

?>