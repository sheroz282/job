<?php 
class file
{	
	/** @var string */
	private $file_name;
	
	/** @var array */
	private $array_sifri = [];
	
	public function set_file_name($file_name){
		$this->file_name = $file_name;
	}
	
	public function set_array_sifri($array_sifr){
		$this->array_sifri = $array_sifr;
	}
	
	public function readfile():array{
		$file = file_get_contents($this->file_name);
		$files = explode(PHP_EOL, $file);
		
		foreach($files as $fs){
			$par = array_map('intval', explode(' ',$fs));
			$this->array_sifri[] = $par;
		}
		return $this->array_sifri;
	}
	
	public function write_file(){
		$polozhitelniy_sif = [];
		$otresatelniy_sif = [];
		
		foreach($this->array_sifri as $nomer){
			if($nomer > 0){
				$polozhitelniy_sif[] = $nomer;
			}
			else{$otresatelniy_sif[] = $nomer;}
		}
		
		file_put_contents('polozhitelniy.txt', implode(PHP_EOL, $polozhitelniy_sif));
		file_put_contents('otresatelniy.txt', implode(PHP_EOL, $otresatelniy_sif));
	}
}

class Calc
{
	/** @var array */
	private $array_sifri;
	
	/** @var array */
	private $result = [];
	
	/** @var string */
	private $sabity;
	
	public function __construct($array_sifr, $sabity){
		$this->array_sifri = $array_sifr;
		$this->sabity = $sabity;
		
		foreach($array_sifr as $par){
			if($this->sabity === 'sum'){
				$this->result[] = $par[0] + $par[1];
			}
			if($this->sabity === 'minus'){
				$this->result[] = $par[0] - $par[1];
			}
			if($this->sabity === 'umnozh'){
				$this->result[] = $par[0] * $par[1];
			}
			if($this->sabity === 'deleniy'){
				$this->result[] = $par[0] / $par[1]; 
			}
		}
	}
	
	public function Result(){
		return $this->result;
	}
}

function Sabity($file_name, $sabity){
	$file = new file();
	$file->set_file_name($file_name);
	$data = $file->readfile();
	
	$new_calc = new Calc($data, $sabity);
	$result = $new_calc->Result();
	
	$new_data = new file();
	$new_data->set_array_sifri($result);
	$new_data->write_file();
	
	echo "Получилось";
}
Sabity('sifr.txt', 'umnozh');