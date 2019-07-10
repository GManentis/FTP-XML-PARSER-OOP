<?php

class DataEntry
{
	private $conn;
	public $entry;
	private $response = '';
	private $elements;
	private $entriesArray;
	private $count;
	
	public function __construct(PDO $pdo, $entr) 
	{
        $this->conn = $pdo;
		$this->entry = $entr;
    }

		public function enterData()
		{  
			$this->entriesArray = json_decode($this->entry);
			
			foreach($this->entriesArray as $this->elements)
			{			
				$email = $this->elements->email;
				$getdata_PRST = $this->conn->prepare("SELECT * FROM test WHERE email = :email");
				$getdata_PRST -> bindValue(":email", $email);
				$getdata_PRST -> execute() or die($CONNPDO->errorInfo());
				$this->counts = $getdata_PRST->rowCount();
				
					if($this->counts > 0)	
					{
						
						$this->updateEntry();
						
					}
					else
					{
						$this->insertEntry();
					}
					
					
			}
			
			echo $this->response;
		}
				
		private function updateEntry()
		{
			$updata_PRST = $this->conn->prepare("UPDATE test SET  name = :name, etc = :etc  WHERE email = :email");
			$updata_PRST->bindValue(":name",$this->elements->name);
			$updata_PRST->bindValue(":email",$this->elements->email);
			$updata_PRST->bindValue(":etc",$this->elements->etc);
			$updata_PRST->execute() or die($CONNPDO->errorInfo());
			$this->response .= "Entry with email ".$this->elements->email." already exists!The rest of info will be updated accordingly!<br>";
		}
		
		private function insertEntry()
		{
			
			$adddata_PRST = $this->conn->prepare("INSERT INTO test(name, email, etc) VALUES (:name, :email, :etc)");
			$adddata_PRST->bindValue(":name",$this->elements->name);
			$adddata_PRST->bindValue(":email",$this->elements->email);
			$adddata_PRST->bindValue(":etc",$this->elements->etc);
			$adddata_PRST->execute() or die($CONNPDO->errorInfo());
			$this->response .= "New entry with email".$this->elements->email."has been successfully registered to the database!<br>";
		}
		
		
}
?>			