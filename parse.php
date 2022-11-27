<?php

/**
 * HTMLParser
 */
class HTMLParser 
{    
    /**
     * content
     *
     * @var mixed
     */
    private $content;
    
    /**
     * __construct
     *
     * @param  mixed $file
     * @return void
     */
    public function __construct(string $file) 
    { 
        try {
            $this->content = new DomDocument();
            @$this->content->loadHTMLFile($file);    
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }    
    /**
     * getTrackingNumber
     *
     * @return string
     */
    public function getTrackingNumber() : string 
    {
        return $this->content->getElementById('wo_number')->textContent;
    }    
    /**
     * getPoNumber
     *
     * @return string
     */
    public function getPoNumber() : string 
    {
        return $this->content->getElementById('po_number')->textContent;
    }    
    /**
     * getScheduledDate
     *
     * @return string
     */
    public function getScheduledDate() : string 
    {
        $scheduled_date = $this->content->getElementById('scheduled_date')->textContent;
        $scheduled_date = str_replace(array("  ", "\n", "\r"),'',$scheduled_date); // funkcja do powielenie
        $scheduled_date = date("Y-m-d H:i", strtotime($scheduled_date));
        
        return $scheduled_date;
    }    
    /**
     * getCustomer
     *
     * @return string
     */
    public function getCustomer() : string 
    {
        $customer = $this->content->getElementById('customer')->textContent;
        $customer = str_replace(array("  ", "\n", "\r"),'',$customer);
        
        return $customer;
    }    
    /**
     * getTrade
     *
     * @return string
     */
    public function getTrade() : string 
    {
        $trade = $this->content->getElementById('trade')->textContent;
        $trade = str_replace(array("  ", "\n", "\r"),'',$trade);
        
        return $trade;
    }
    
    /**
     * getNTE
     *
     * @return int
     */
    public function getNTE() : int 
    {
        $nte = $this->content->getElementById('nte')->textContent;
        $nte = str_replace(array("$", ","),'',$nte);
        $nte = floatval($nte);
        
        return $nte;
    }
    
    /**
     * getStoreID
     *
     * @return string
     */
    public function getStoreID() : string 
    {
        return $this->content->getElementById('location_name')->textContent;
    }
    
    /**
     * getAddress
     *
     * @return array
     */
    public function getAddress() : array 
    {
        $address = $this->content->getElementById('location_address')->textContent;
        
        $address_array = explode(PHP_EOL, $address);
        foreach($address_array as $address) {
            $address_temp = preg_replace('/\s\s*/', ' ', $address);
            $address_temp = trim($address_temp);
            if(!empty($address_temp)) {$address_array_new[] = $address_temp;}
        }
        
        $second_line = explode(" ", $address_array_new[1]);
        
        $address_item['street'] = $address_array_new[0];     
        $address_item['city'] = $second_line[0];
        $address_item['state'] = $second_line[1];
        $address_item['zip'] = $second_line[2];

        return $address_item;
    }
    
    /**
     * getPhone
     *
     * @return string
     */
    public function getPhone() : string 
    {
        $location_phone = $this->content->getElementById('location_phone')->textContent;
        $location_phone = str_replace('-','',$location_phone);
        
        return $location_phone;
    
    }

}

// example usage
// $HTMLParser = new HTMLParser('wo_for_parse.html');
// var_dump($HTMLParser->getTrackingNumber());