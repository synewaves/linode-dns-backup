<?php
/**
 * Linode DNS Backup
 * Copyright 2010 Matthew Vince <matthew.vince@phaseshiftllc.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright (c) 2010, Matthew Vince <matthew.vince@phaseshiftllc.com>
 * @link       http://github.com/synewaves/linode-dns-backup
 * @package    LinodeDnsBackup
 * @author     Matthew Vince <matthew.vince@phaseshiftllc.com>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */
include_once 'renderer.php';
 
/**
 * Plain-text renderer class
 * @package LinodeDnsBackup
 */
class TextLinodeDnsBackupRenderer extends LinodeDnsBackupRenderer
{
	/**
	 * Output text
	 * @var string
	 */
	protected $output = '';
	
	
	/**
	 * Render
	 * @param array $records DNS records hash
	 */
	public function render($records)
	{
		$this->writeLine(sprintf('DNS Backup generated on %s by LinodeDnsBackup (http://github.com/synewaves/linode-dns-backup)', date(DATE_RSS)));
		$this->writeLine();
		
		foreach ($records as $domain => $record) {
			$this->writeLine(sprintf('%s (ID: %s)', $record['INFO']['DOMAIN'], $record['INFO']['DOMAINID']));
			$this->writeLine(sprintf('SOA Email: %s', $record['INFO']['SOA_EMAIL']));
			
			foreach ($record['MX'] as $r) {
				$this->writeLine(sprintf("MX\t%s\t%s", $r['PRIORITY'], $r['TARGET']));
			}
			
			foreach ($record['A'] as $r) {
				$this->writeLine(sprintf("A\t%s\t%s\t%s", $r['NAME'], $r['TTL_SEC'], $r['TARGET']));
			}
			
			foreach ($record['CNAME'] as $r) {
				$this->writeLine(sprintf("CNAME\t%s\t%s", $r['NAME'], $r['TARGET']));
			}
			
			foreach ($record['TXT'] as $r) {
				$this->writeLine(sprintf("TXT\t%s\t%s", $r['NAME'], $r['TARGET']));
			}
			
			foreach ($record['SRV'] as $r) {
				$this->writeLine(sprintf("SRV\t%s\t%s\t%s\t%s\t%s", $r['NAME'], $r['PRIORITY'], $r['WEIGHT'], $r['PORT'], $r['TARGET']));
			}
			
			$this->writeLine();
			$this->writeLine();
		}
		
		file_put_contents($this->output_file, $this->output);
	}
	
	/**
	 * Writes a line to the output - auto appends newline
	 * @param string $line line
	 */
	protected function writeLine($line = '')
	{
		$this->output .= $line . "\n";
	}
}
