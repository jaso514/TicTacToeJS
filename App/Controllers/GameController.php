<?php

class GameController extends RestController{
	private $board = [['','',''],['','',''],['','','']];
	
	public function __construct($controllerName, $action, $request) {
		session_start();
		parent::__construct($controllerName, $action, $request);
	}

	public function start () {
		$_SESSION['board'] = $this->board;
		echo $this->response([
				'success' => true
			]);
	}

	/**
	 * GET: receive the x and y position and return the bot move
	 * @param array $x
	 * @param array $y
	 * @param string $userToken
   * @return array
	 */
	public function move ($x, $y, $userToken) {
		// load the board from session
		if (!array_key_exists('board', $_SESSION)) {
			$_SESSION['board'] = $this->board;
		} else {
			$_SESSION['board'][$x][$y] = $userToken;
		}
		
		// call the move
		$botMove = new MoveTicTacToe();
		$move = $botMove->makeMove($_SESSION['board'], $userToken);
		// verify if the move is correctly
		if (count($move)>=3) {
			// update the board
			$_SESSION['board'][$move[0]][$move[1]] = $move[2];
			// convert the response to hash 
			$response = [
					'x'=> $move[0],
					'y'=> $move[1],
					'token'=> $move[2]
				];
			echo $this->response($response);
		} else {
			$message = 'Error. Sorry for the issue. Please restart the game.';
			if (array_key_exists('error', $move)) {
				$message = $move['error'];
			}
			echo $this->response(
				$message,
				500);
		}
	}

}
