Data Scraper Helpers - July 2014

Updated to include basic Data Gather class, which acts as a wrapper for Snoopy class.

Basic Usage:

$DG = new DataGather();
$DG->setURL('http://www.php.net');

Default method of retrieval is file_get_contents, but you can use Snoopy too!

$DG->setSnoopy(true);

To get HTML, run: $DG->getHTML();

To get XML, run:  $DG->getXML();



Data Scraper Helpers - May 2014

A collection of functions developed over time to help with personal scraping projects.

(The PHP class makes use of the Snoopy class. This isn't contained in the repo, but can add if requested enough)