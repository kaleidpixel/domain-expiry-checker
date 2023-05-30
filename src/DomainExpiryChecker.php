<?php
/**
 * PHP 7.3 or later
 *
 * @package    KALEIDPIXEL
 * @author     KAZUKI Otsuhata
 * @copyright  2023 (C) Kaleid Pixel
 * @license    MIT License
 * @version    0.0.1
 **/

namespace kaleidpixel;

use Iodev\Whois\Factory;
use Iodev\Whois\Exceptions\ConnectionException;
use Iodev\Whois\Exceptions\ServerMismatchException;
use Iodev\Whois\Exceptions\WhoisException;

class DomainExpiryChecker {
	private $whois;
	private $domain;
	private $expiry;

	public function __construct( string $domain ) {
		$this->whois  = Factory::get()->createWhois();
		$this->domain = $domain;
		$this->expiry = $this->__getExpiryDate();
	}

	/**
	 * @param string $date YYYY-mm-dd
	 *
	 * @return false|int
	 * @throws \Exception
	 */
	private function __getIntervalDays( $date ) {
		$now        = new \DateTime();
		$targetDate = new \DateTime( $date );
		$interval   = $now->diff( $targetDate );

		return $interval->days + 1;
	}

	/**
	 * @return false|string
	 * @throws \Exception
	 */
	private function __getExpiryDate() {
		try {
			$domainInfo = $this->whois->loadDomainInfo( $this->domain );

			if ( !$domainInfo ) {
				throw new \Exception( 'Unable to get WHOIS information.' );
			}

			return date( 'Y-m-d', $domainInfo->expirationDate );
		} catch ( ConnectionException $e ) {
			return 'Disconnect or connection timeout';
		} catch ( ServerMismatchException $e ) {
			return 'TLD server (.com for google.com) not found in current server hosts';
		} catch ( WhoisException $e ) {
			return "Whois server responded with error: {$e->getMessage()}";
		}
	}

	/**
	 * @return mixed
	 */
	public function getExpiryDate() {
		return $this->expiry;
	}

	/**
	 * @return false|int
	 * @throws \Exception
	 */
	public function remainingDays() {
		return $this->__getIntervalDays( $this->expiry );
	}
}
