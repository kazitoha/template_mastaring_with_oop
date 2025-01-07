<?php
function autoload($className)
{
    // Convert the namespace to a file path (for other classes)
    $className = str_replace('\\', '/', $className);

    // Define the full file path for other classes
    $file = __DIR__ . '/' . $className . '.php';

    echo "Attempting to load class: $file<br>";  // Debugging output

    // Check if the file exists, if so, include it
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "Class '$className' not found!<br>";  // Debugging output if class not found
    }
}

// Register the autoloader
spl_autoload_register('autoload');
