<?php
require_once dirname(__FILE__) . "/../Libs/MoveInterface.php";
require_once dirname(__FILE__) . "/../Libs/MoveTicTacToe.php";

class TicTacToeTest extends PHPUnit_Framework_TestCase{
	private $bot;
	protected function setUp() {
      $this->bot = new MoveTicTacToe();
  }

  public function testInitialize() {
  	$board = [['X','',''],['','',''],['','','']];

  	$result = $this->bot->makeMove($board, 'X');
    $this->assertEquals(3, count($result));
  }

  public function testFullBoard() {
  	$board = [['X','X','O'],['O','O','X'],['X','O','X']];

  	$result = $this->bot->makeMove($board, 'X');
    $this->assertEquals(true, array_key_exists('error', $result));
  }

  public function testWinCase() {
  	$board = [
		  	['X','','O'],
		  	['','O','X'],
		  	['','','X']];

  	$result = $this->bot->makeMove($board, 'X');
  	$this->assertEquals([2,0,'O'], $result);
  }

  public function testBlockCase() {
  	$board = [
		  	['X','','O'],
		  	['','','X'],
		  	['','O','X']];

  	$result = $this->bot->makeMove($board, 'X');
  	$this->assertEquals([1,1,'O'], $result);
  }

  public function testBlockCase2() {
  	$board = [
		  	['O','','O'],
		  	['','X',''],
		  	['','X','X']];

  	$result = $this->bot->makeMove($board, 'X');
  	$this->assertEquals([0,1,'O'], $result);
  }

}
