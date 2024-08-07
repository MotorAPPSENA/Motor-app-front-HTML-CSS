<?php

use PHPUnit\Framework\TestCase;

class OperacionTest extends TestCase{
   
    private $op;
    public function setUp():void{
        $this->op = new Operaciones();
    }

    public function testSumWithTwovalues(){
        $this->assertEquals(7,$this->op->sum(2,5));
    }
}
?>

<?php

class Operaciones {
    public function __construct(){

    }

    public function sum($n1, $n2){
        return $n1 + $n2;
    }
}
?>