<?php

class Greeting
{
    private $greeting;
    

    public function __construct($greeting)
    {
        $this->greeting = $greeting;
        
    }

    public function getGreeting()
    {
        return $this->greeting;
    }
}

class Greeter
{
    public static function create($greeting)
    {
        return new Greeting($greeting);
    }
}

class decorate {
	public function greet($greeting){
		return $greeting."!";
	}
}

?>