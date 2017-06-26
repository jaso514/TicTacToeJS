<?php

class TicTacToeController extends BaseController{
	public function index() {
		$c = new MoveTicTacToe();
		$this->_template->render('index');
	}
}
