<?php
namespace App\model;
class productClass 
{
    private $sif;
    private $name;
    private $price;
    private $count;
    private $description;

    public function __construct($sif, $name,$price,$count,$description){
        $this->sif=$sif;
        $this->name = $name;
        $this->price = $price;
        $this->count = $count;
        $this->description = $description;
        
    }
    public function getSif(){
        return $this->sif;
    }
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    public function getCount()
    {
        return $this->count;
    }
    
    public function setCount($count)
    {
        $this->count = $count;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getSumPrice(){
        return (float)$this->price * (float)$this->count;
    }
    public function display(){
        echo "Product: ".$this->sif." ".$this->name." ".$this->price." ".$this->description."<br>";
    }
    
    
}



?>