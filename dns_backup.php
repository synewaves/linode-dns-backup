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
require_once 'Services/Linode.php';
require_once 'renderers/renderer.php';
require_once 'renderers/text_renderer.php';


/**
 * Backup class
 * @package LinodeDnsBackup
 */
class LinodeDnsBackup
{
	/**
	 * Renderer
	 * @var LinodeDnsRenderer
	 */
	public $renderer = null;
	
	/**
	 * API class
	 * @var Services_Linode
	 */
	protected $api = null;
	
	/**
	 * DNS records
	 * @var array
	 */
	protected $records = array();
	
	
	/**
	 * Constructor
	 * @param string $api_key Linode API Key
	 */
	public function __construct($api_key)
	{
		$this->api = new Services_Linode($api_key);
	}
	
	/**
	 * Generate
	 */
	public function generate()
	{
		if (is_null($this->renderer)) {
			throw new Exception('No output renderer specified');
		}
		
		try {
			$domains = $this->api->domain_list();
			foreach ($domains['DATA'] as $domain) {
				$domain_name = $domain['DOMAIN'];
				$this->records[$domain_name] = array(
					'INFO' => $domain,
					'MX' => array(),
					'A'  => array(),
					'CNAME' => array(),
					'TXT' => array(),
					'SRV' => array(),
				);
				
				$resources = $this->api->domain_resource_list($domain['DOMAINID']);
				foreach ($resources['DATA'] as $resource) {
					$type = $resource['TYPE'];
					if ($type != 'MX') {
						$this->records[$domain_name][$type][$resource['NAME']] = $resource;
					} else {
						$this->records[$domain_name][$type][] = $resource;
					}
				}
				
				ksort($this->records[$domain_name]['A']);
				ksort($this->records[$domain_name]['CNAME']);
			}
			
			ksort($this->records);
			
			$this->renderer->render($this->records);
			
		} catch (Services_Linode_Exception $e) {
			echo $e->getMessage();
		}
	}
}
