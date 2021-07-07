<?php

return [
    'rentable' => [
        'max_images' => $max = env('RENTABLE_MAX_IMAGES') ? (int) $max : 10
    ]
];
