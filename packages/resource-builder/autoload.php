<?php

// Defined all autoload files.
$autoloadFiles = [
	__DIR__.'/../../vendor/autoload.php',
	__DIR__.'/../../../../vendor/autoload.php',
];

// is autoload file loaded.
$autoloadFileLoaded = false;

// include autoload files.
foreach ($autoloadFiles as $filename) {
	if (file_exists($filename)) {
		include $filename;;
		$autoloadFileLoaded = true;
	}
}

// Not Fount autoload file.
if (!$autoloadFileLoaded) {
	echo 'Not fount autoload file.', PHP_EOL;

	// Send exit error code.
	exit(1);
}
