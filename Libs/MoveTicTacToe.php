<?php

class MoveTicTacToe  implements MoveInterface {
	private $moveWeight = [];
	
	public function makeMove($boardState, $playerUnit = 'X') {
		if ($this->completed($boardState)){
			return ['error' => 'The board was completed.'];
		}
	  $boardWeight = $this->setBoardWeight($boardState, $playerUnit);
	  foreach ($boardWeight as $orientation => $values) {
	  	foreach ($values as $i => $value) {
		  	$w = 0;// a simple movement
		    if (abs($value)==2) {
		    	$w = $value;// could be an line with posible win or lose movement
		    }
	      $this->setMove($i, $orientation, $boardState, $w);
	  	}
	  }
	  $move = $this->selectBestMove();
	  $move[] = $playerUnit==='X'?'O':'X';
	  return $move;
	}

	private function setMove($pos, $orientation, $boardState, $value) {
	  // set the wight of the move, if is bigger is a best move
	  // if the middle is empty can begin in this place
	  for ($i=0; $i<=2; $i++) {
	  	$posIdx = '';
	  	$w = 0;
	  	if ($orientation==='H' && 
	  			$boardState[$pos][$i]==='') {
	  		$posIdx = $pos.','.$i;
	  	} else if ($orientation==='V' && 
	  			$boardState[$i][$pos]==='') {
	  		$posIdx = $i.','.$pos;
	  	} else if ($orientation==='D') {
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

	// Block the move when a user can win
	private function setBoardWeight ($board, $playerUnit) {
		$boardWeight = [
      'H' => [0,0,0],
      'V' => [0,0,0],
      'D' => [0,0]
    ];

	  for ($i=0; $i<=2; $i++) {
	    for ($j=0; $j<=2; $j++) {
	      if ($board[$i][$j]===$playerUnit) {
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
