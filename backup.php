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
require_once 'Console/Getopt.php';
require_once 'dns_backup.php';


// get args
$cg = new Console_Getopt();
$args = $cg->readPHPArgv();
array_shift($args);
$args = $cg->getopt2($args, array(), array('api_key==', 'outfile=='));
$params = array();
foreach ($args[0] as $param) {
	$params[$param[0]] = $param[1];
}


// validate args
if (!isset($params['--api_key']) || trim($params['--api_key']) == '') {
	echo 'Error: --api_key parameter was mising.';
	exit(1);
}
if (!isset($params['--outfile']) || trim($params['--outfile']) == '') {
	$params['--outfile'] = realpath(dirname(__FILE__)) . '/outfile.txt';
}


// run
$backup = new LinodeDnsBackup($params['--api_key']);
$backup->renderer = new TextLinodeDnsBackupRenderer($params['--outfile']);
$backup->generate();
