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
 
/**
 * Base renderer class
 * @package LinodeDnsBackup
 */
abstract class LinodeDnsBackupRenderer
{
	/**
	 * Output file
	 * @var string
	 */
	protected $output_file = null;
	
	
	/**
	 * Constructor
	 * @param string $output_file output file
	 */
	public function __construct($output_file)
	{
		$this->output_file = $output_file;
	}
	
	/**
	 * Render
	 * @param array $records DNS records hash
	 */
	abstract public function render($records);
}
