<?php
/**
 * This class provides the functionality of the Auerswald PBX-API
 * 
 * @author Sascha Markwardt <sascha.markwardt@web.de>
 * @link https://github.com/smarkwardt/Auerswald-PBX-Control-SDK-PHP
 * @link http://www.smarkwardt.de/
 * @link http://www.auerswald.de/
 *
 * @package Auerswald\API
 * @subpackage PBX
 */

namespace Auerswald\API\PBX;

use \stdClass;

class PBXDevice
{
    /**
     * The URI (Uniform Resource Identifier) the the device
     * @var string
     */
    protected $rootUri = '';
    
    /**
     * Authentication Name 
     * @var string
     */
    protected $username = '';
    
    /**
     * Authentication Password 
     * @var string
     */
    protected $password = '';
    
    /**
     * Description is missing
     * @param string $address
     * @param string $username
     * @param string $password
     * @return void
     */
    public function __construct($address, $username, $password)
    {
        $this->rootUri = $address;
        $this->username = $username;
        $this->password = $password;
        
        if (substr($this->rootUri, strlen($this->rootUri)-1, 1) == "/")
        {
            $this->rootUri = substr($this->rootUri, 0, strlen($this->rootUri)-1);
        }
    }
    
    /**
     * Description is missing
     * @return stdClass|bool
     */
    public function getInfo()
    {
        $info = new stdClass();
        
        $data = $this->getHttpPageFromPbx("/app_about");
        
        $info = json_decode($data);
        
        return $info;
    }
    
    /**
     * Description is missing
     * @return stdClass|bool
     */
    public function getPhoneBook()
    {
        $phoneBookList = array();
                
        $data = $this->getHttpPageFromPbx("/app_telefonbuch");
            
        $phoneBookList = json_decode($data);
            
        return $phoneBookList;
    }
    
    /**
     * Description is missing
     * @return stdClass|bool
     */
    public function getCallDataList($offset=0, $limit=0)
    {
        $phoneBookList = array();
                
        $data = $this->getHttpPageFromPbx("/app_gespr_list");
            
        $phoneBookList = json_decode($data);
            
        return $phoneBookList;
    }
    
    /**
     * Description is missing
     * @return string|bool
     */
    protected function getHttpPageFromPbx($page)
    {
        $responseContent = "";
        
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $this->rootUri.$page);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curlSession, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($curlSession, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST); 
            
        $responseContent = curl_exec($curlSession);
        
        // TODO :: integrate error handling...
        
        curl_close($curlSession);
            
        return $responseContent;
    }
}