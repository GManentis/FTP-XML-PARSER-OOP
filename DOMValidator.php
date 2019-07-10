<?php
class DOMValidator
{
   
    protected $feedSchema = 'validator.xsd';
	public $jsonedEntries;
    
    public function __construct()
    {
		libxml_use_internal_errors(true);
        $this->handler = new DOMDocument('1.0', 'utf-8');
    }
    
    
    public function validateFeeds($feeds)
    {
        if (!class_exists('DOMDocument')) {
            throw new DOMException("'DOMDocument' class not found!");
           
        }
        if (!file_exists($this->feedSchema)) 
		{
            throw new Exception('Schema is Missing, Please add schema to feedSchema property');
        }
        
               
        $this->handler->load($feeds);
        if (!$this->handler->schemaValidate($this->feedSchema)) 
		{
		   libxml_use_internal_errors(true);
		   $errors = json_encode(libxml_get_errors());
		   
           throw new Exception('Failed to validate XML, please check the structure of the file!<br>The following errors occured:'.$errors);
        } 
		
    }
    	
	public function getValues()
	{
		$names = $this->handler->getElementsbyTagName('name');
		$emails = $this->handler->getElementsbyTagName('email');
		$etcs = $this->handler->getElementsByTagName('etc');
		$namesArray = array();
		$emailsArray = array();
		$etcsArray = array();
		$entriesArray = array();
		
		foreach($names as $name)
		{
				array_push($namesArray,$name->nodeValue);
		}
		
		foreach($emails as $email)
		{
				array_push($emailsArray,$email->nodeValue);
		}
		
		foreach($etcs as $etc)
		{
				array_push($etcsArray,$etc->nodeValue);
		}
		
		
		$entriesArray = array();
		for( $i=0 ; $i < count($namesArray); $i++)
		{				
			if(filter_var($emailsArray[$i], FILTER_VALIDATE_EMAIL))
			{
				
				$entry = new stdClass();
				$entry->name = $namesArray[$i];
				$entry->email = $emailsArray[$i];
				$entry->etc = $etcsArray[$i];
				
				array_push($entriesArray,$entry);
				
			}
			else
			{
				throw new Exception("One or more mail values are invalid in the given XML");
			}
			
			$this->jsonedEntries = json_encode($entriesArray);
				
		}
		
		
	}
}

?>