<?php

$autoloadFiles = [
	__DIR__.'/../../vendor/autoload.php',
	__DIR__.'/../../../../vendor/autoload.php',
];
$autoloadFileLoaded = false;

foreach ($autoloadFiles as $filename) {
	if (file_exists($filename)) {
		include $filename;;
		$autoloadFileLoaded = true;
	}
}

if (!$autoloadFileLoaded) {
	echo 'Not fount autoload file.', PHP_EOL;
	exit(1);
}
