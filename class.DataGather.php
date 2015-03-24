<?php
include_once("Snoopy.class.php");

/**
 * Specify how you want to retrieve
 * HTML from a page when instantiating
 * object. The class handles the processing
 * Methods prefixed with _ are for internal
 * use by class methods.
 */

class DataGather
{

    protected $html = "";
    protected $method = "file_get_contents";
    protected $snoopy = false;
    protected $retryMaxLimit = 10;
    protected $url;
    protected $snoopyObj = "";

    function __construct($method="file_get_contents")
    {
        $this->setMethod($method); //set the method that this class will use
    }

    /**
     * Set the method that HTML will be
     * retrieved
     * @param method
     */
    function setMethod($method)
    {
        $this->method = $method;
        if ($this->method=="Snoopy"|| $this->method == "snoopy"){
            $this->snoopyObj = new Snoopy(); //instantiate new Snoopy object
        }
    }

    /**
     * Declare Snoopy as method of HTML retrieval
     * @param boolean
     */
    function setSnoopy($status)
    {
        if ($status){
            $this->snoopy = true;
            $this->setMethod('snoopy');
        }
    }

    /**
     * Set the URL
     * @param url
     */
    function setURL($url)
    {
        $this->url = $url;
    }

    /**
     * Set the max retry limit
     * @param limit
     */
    function setRetryMaxLimit($limit)
    {
        $this->retryMaxLimit = $limit;
    }

    /**
     * Pass in a link and use file_get_contents
     * to retrieve HTML from a given page URL
     * @return string
     */


   function _getHTMLFromURL_fgc()
   {
        for($i=0;$i<$this->retryMaxLimit;$i++){
            $html = file_get_contents($this->url);
            if ($html) break;
            sleep($i);//pause before retrying
        }

        return $html;
   }

   /**
    * Pass in a link and use Snoopy's built in
    * method to retrieve the HTML from a given
    * page URL
    * @return string
    */

    function _getHTMLFromURL_snoopy()
    {
        for($i=0;$i<$this->retryMaxLimit;$i++){
            $this->snoopyObj->fetch($this->url);
            if ($this->snoopyObj->results){
                break;
            }
            sleep($i); //pause before retrying
        }
        return $this->snoopyObj->results;
    }

    /**
     * Generate simplexml object using
     * supplied HTML
     * @param HTML
     * @return string
     */
    function _getXMLFromHTML($html)
    {
        $doc = new DomDocument();
        @$doc->loadHTML($html);
        $xml = simplexml_import_dom($doc);

        if ($xml) return $xml;
    }


    /**
     * Get HTML based on how the
     * retrieval method has been
     * configured
     * @return HTML
     */
    function getHTML()
    {
        switch($this->method){
            case "snoopy":
                return $this->_getHTMLFromURL_snoopy();
                break;
            case "file_get_contents":
                return $this->_getHTMLFromURL_fgc();
                break;
            default:
                return $this->_getHTMLFromURL_fgc();

        }
    }


    /**
     * Get XML based on how the retrieval
     * methods have been configured
     * @return HTML
     */
    function getXML()
    {
        $html = $this->getHTML();
        $doc = new DomDocument();
        @$doc->loadHTML($html);
        $xml = simplexml_import_dom($doc);

        if ($xml){
            return $xml;
        }
    }

}

?>




