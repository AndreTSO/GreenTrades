<?php
	class greenTest extends \PHPUnit\Framework\TestCase{
		public function testAdd(){
			require_once('includes/configT.php');
			include ('classes/user.php');
			$handler=new user($db);

			$resultado = $handler->getUserIdByEmail('lrt.random@gmail.com');
			$this->assertEquals("124288456",$resultado);
			
		}


	}

?>



