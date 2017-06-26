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

	public function move ($x, $y, $userToken) {
		if (!array_key_exists('board', $_SESSION)) {
			$_SESSION['board'] = $this->board;
		} else {
			$_SESSION['board'][$x][$y] = $userToken;
		}
		
		$botMove = new MoveTicTacToe();
		$move = $botMove->makeMove($_SESSION['board'], $userToken);
		if (count($move)>=3) {
			$_SESSION['board'][$move[0]][$move[1]] = $move[2];
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
