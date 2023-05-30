<?php

namespace kaleidpixel\Tests;

use PHPUnit\Framework\TestCase;
use kaleidpixel\DomainExpiryChecker;

class DomainExpiryCheckerTest extends TestCase {
	private $checker;

	protected function setUp(): void {
		$this->checker = new DomainExpiryChecker( 'google.com' );
	}

	public function testGetCertificateExpiry() {
		$this->assertMatchesRegularExpression(
			'/^\d{4}-\d{2}-\d{2}$/',
			$this->checker->getExpiryDate()
		);
	}

	public function testGetCertificateRemainingDays() {
		$this->assertMatchesRegularExpression(
			'/^\d{1,4}$/',
			$this->checker->remainingDays()
		);
	}
}
