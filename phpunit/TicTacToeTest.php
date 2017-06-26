<?php
require_once dirname(__FILE__) . "/../Libs/MoveInterface.php";
require_once dirname(__FILE__) . "/../Libs/MoveTicTacToe.php";

class TicTacToeTest extends PHPUnit_Framework_TestCase{
	private $bot;
	
	protected function setUp() {
      $this->bot = new MoveTicTacToe();
  }

	/**
	 * Test the first movement fo the bot
	 * need to return an array with 3 items
	 */
  public function testInitialize() {
  	$board = [['X','',''],['','',''],['','','']];

  	$result = $this->bot->makeMove($board, 'X');
    $this->assertEquals(3, count($result));
  }

	/**
	 * Test the response if the board don't have empty cells
	 */
  public function testFullBoard() {
  	$board = [['X','X','O'],['O','O','X'],['X','O','X']];

  	$result = $this->bot->makeMove($board, 'X');
    $this->assertEquals(true, array_key_exists('error', $result));
  }

	/**
	 * Test the case if the bot can win in one movement
	 */
  public function testWinCase() {
  	$board = [
		  	['X','','O'],
		  	['','O','X'],
		  	['','','X']];

  	$result = $this->bot->makeMove($board, 'X');
  	$this->assertEquals([2,0,'O'], $result);
  }

	/**
	 * Test the case if the bot can block a posible winner movement of the user
	 */
  public function testBlockCase() {
  	$board = [
		  	['X','','O'],
		  	['','','X'],
		  	['','O','X']];

  	$result = $this->bot->makeMove($board, 'X');
  	$this->assertEquals([1,1,'O'], $result);
  }

	/**
	 * Test the of the priority between block or win in the next move
	 */
  public function testBlockOrWinCase() {
  	$board = [
		  	['O','','O'],
		  	['','X',''],
		  	['','X','X']];

  	$result = $this->bot->makeMove($board, 'X');
  	$this->assertEquals([0,1,'O'], $result);
  }

}
