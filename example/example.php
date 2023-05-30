<?php
require dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use kaleidpixel\DomainExpiryChecker;

try {
	$checker = new DomainExpiryChecker( '996sezaki.com' );

	echo "Domain Expiry: " . $checker->getExpiryDate() . PHP_EOL;
	echo "Domain Remind: " . $checker->remainingDays() . PHP_EOL;
} catch ( Exception $e ) {
	echo $e->getMessage() . PHP_EOL;
}
