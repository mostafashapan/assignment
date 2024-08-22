<?php

function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception("The .env file does not exist at the specified path.");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignore comments and empty lines
        if (strpos($line, '#') === 0) {
            continue;
        }

        // Split the line into key and value
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Set the environment variable
        if (!empty($key)) {
            putenv("$key=$value");
            $_ENV[$key] = $value;  // Optional: populate $_ENV array
        }
    }
}
