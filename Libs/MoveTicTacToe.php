<?php

class MoveTicTacToe  implements MoveInterface {
	private $moveWeight = []; // load the move weight that could be selected
	
	/**
	 * Search the best next move 
	 * @param array $boardState
	 * @param string $playerUnit
   * @return array
	 */
	public function makeMove($boardState, $playerUnit = 'X') {
		if ($this->completed($boardState)){
			return ['error' => 'The board was completed.'];
		}
	  $boardWeight = $this->setBoardWeight($boardState, $playerUnit);
	  foreach ($boardWeight as $orientation => $values) {
	  	foreach ($values as $i => $value) {
		  	$w = 0;// a simple movement
		    if (abs($value)==2) {
					// if is -2 need to be blocked
					// if is 2 can win with the next move
		    	$w = $value;// could be an line with posible win or lose movement
		    }
				// Set the move weight values to the class array
	      $this->setMove($i, $orientation, $boardState, $w);
	  	}
	  }
	  $move = $this->selectBestMove();
	  $move[] = $playerUnit==='X'?'O':'X';// Adding the symbol to play
	  return $move;
	}
	
	/**
	 * 
	 * @param in $pos : the row or the col that can be iterated
	 * @param string $orientation : the orientation of iteration
	 * @param array $boardState : The current board state to iterate
	 * @param int $value : the value of the orientation
	 * @return type
	 */
	private function setMove($pos, $orientation, $boardState, $value) {
	  // set the wight of the move, if is bigger is a best move
	  // if the middle is empty can begin in this place
	  for ($i=0; $i<=2; $i++) {
	  	$posIdx = ''; // contain the pos (x,y) of the move
	  	$w = 0; // contain the weight of the relationated move
	  	if ($orientation==='H' && 
	  			$boardState[$pos][$i]==='') {
				// row position
	  		$posIdx = $pos.','.$i;
	  	} else if ($orientation==='V' && 
	  			$boardState[$i][$pos]==='') {
				// col position
	  		$posIdx = $i.','.$pos;
	  	} else if ($orientation==='D') {
				// diagonal position
				if ($pos===0) {
		  		if ($boardState[$i][$i]==='') {
		  			$posIdx = $i.','.$i;
		  		}
				} else if($pos===1) {
					if ($boardState[$i][abs($i-2)]==='') {
		  			$posIdx = $i.','.abs($i-2);
		  		}
				}
	  	}

	  	if ($posIdx!=='') {
				$w = $this->getWeight($value);
	  		if (array_key_exists($posIdx, $this->moveWeight)) {
					// add weight if some movement has previous weight
		  		if ($w>=3) {
		  			$this->moveWeight[$posIdx] += $w;
		  		} else {
	  				$this->moveWeight[$posIdx]++;
		  		}
	  		} else {
	  			$this->moveWeight[$posIdx] = $w;
	  		}
	  	}
	  }

	}

	/**
	 * Select the best move weight from moveWeight
	 * @return array
	 */
	private function selectBestMove() {
		$bestWeight = -10;
		$bestPos = null;
		foreach ($this->moveWeight as $pos => $value) {
			if ($value>$bestWeight) {
				$bestWeight = $value;
				$bestPos = $pos;
			}
		}
		return explode(',', $bestPos);
	}

	/**
	 * return the weight related to the value row or cell
	 * @param int $value
	 * @return type
	 */
	private function getWeight($value) {
		if ($value==2) {
			// the movement could lose the game
			$w = 10;
		} else if ($value==-2) {
			// the movement could lose the game
			$w = 3;
		} else {
			$w = 0;
		}
		return $w;
	}

	/**
	 * Set the board weight of the row, col or diagonal match.
	 * Positive weight is best to the bot.
	 * Negative weight is best to the user.
	 * @param array $board
	 * @param string $playerUnit
	 * @return array
	 */
	private function setBoardWeight ($board, $playerUnit) {
		$boardWeight = [
      'H' => [0,0,0],//rows
      'V' => [0,0,0],// cols
      'D' => [0,0] // diagonal
    ];

	  for ($i=0; $i<=2; $i++) {
	    for ($j=0; $j<=2; $j++) {
	      if ($board[$i][$j]===$playerUnit) {
					// weight to the user
	      	$boardWeight['H'][$i]--;
	        $boardWeight['V'][$j]--;
	        if ($i===1 && $i===$j) {
	          $boardWeight['D'][0]--;
	          $boardWeight['D'][1]--;
	        } else if ($i===$j) {
	          $boardWeight['D'][0]--;
	        } else if (abs($j-2)===$i) {
	          $boardWeight['D'][1]--;
	        }
	      } else if($board[$i][$j]!=='') {
					// weight to the bot
	        $boardWeight['H'][$i]++;
	        $boardWeight['V'][$j]++;
	        if ($i===1 && $i===$j) {
	          $boardWeight['D'][0]++;
	          $boardWeight['D'][1]++;
	        } else if ($i===$j) {
	          $boardWeight['D'][0]++;
	        } else if (abs($j-2)===$i) {
	          $boardWeight['D'][1]++;
	        }
	      }
	    }
	  }
	  
	  return $boardWeight;
	}

	/**
	 * Verify if the board was completed
	 * @param array $boardStatus
	 * @return bool
	 */
	private function completed($boardStatus){
		$complete = true;
		for ($i=0; $i<=2; $i++) {
	    for ($j=0; $j<=2; $j++) {
	    	$complete &= $boardStatus[$i][$j]!='';
	  	}
  	}
  	return $complete;
	}
}
