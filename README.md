# Introduction

This script uses the [Linode API](http://www.linode.com/api/) to create a text file backup of your DNS entries.  All you need is an API key from Linode.

## Installation

    $ sudo pear install Net_URL2-0.3.1
    $ sudo pear install HTTP_Request2-0.5.2
    $ sudo pear channel-discover pear.keremdurmus.com
    $ sudo pear install krmdrms/Services_Linode
    
## Usage

There is a built-in backup script you can call via the command line/cron at backup.php.

Usage: 

    > php backup.php --api_key=YOUR_API_KEY --outfile=/path/to/output.file
