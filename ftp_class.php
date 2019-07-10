<?php

class ftpClass 
{

    private $host;
    private $user;
    private $pass;
    public $conn;
	public $local_file = "test1.xml";//the name of the file in the local directory
	private $server_file = "test1.xml";//the file that the program searches
	
    
	
	public function __construct($host,$user,$pass)
	{
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
		
		if(!$this->conn = ftp_connect($this->host))
		{
			throw new Exception("Could not connect to specific server");
		}
    }
	
		
	public function logIn()
	{
		if(!ftp_login($this->conn,  $this->user,  $this->pass))
		{
			throw new Exception("Could not login to server! Please check Username and PAssword for connection!");
		}
		
    }

	public function downloadFiles()
	{
		  if(ftp_get($this->conn, $this->local_file, $this->server_file, FTP_ASCII))
		  {
			echo "Successfully written to $this->local_file<br>";
		  }
		  else
		  {
			ftp_close($this->conn);
			throw new Exception("Error downloading $this->server_file. The file does not exist in ftp!Connection Terminated!");
		  }
		ftp_close($this->conn);
		echo "Conncetion closed<br>";
	}

	
	
}

?>