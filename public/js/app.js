var myApp = ( function(){

	var board = [
		["","",""],
		["","",""],
		["","",""]
	];
	var boardWeight = {
			H:[0,0,0],
			V:[0,0,0],
			D:[0,0]
		};
	var turn = 1;
	var start = false;
	var finished = false;
	var user = "X";
	var bot = "O";

	function validateStatus(symbol){
		
		var fullBoard = 0;
	  for (var i=0; i<=2; i++) {
	    for (var j=0; j<=2; j++) {
	      if (board[i][j]!=='') {
	        fullBoard++;
	      }
	    }
	  }
console.log(boardWeight);
	  for (var idx in boardWeight) {
	  	for (var pos in boardWeight[idx]) {
	  		if (boardWeight[idx][pos]===3 || boardWeight[idx][pos]===-3) {
	  			finished = true;
	  			break;
	  		}
	  	}
	  }
	  
		if (fullBoard===9 || finished) {
			$("h3").addClass("alert alert-success text-center")
					.text("The game is over");
			finished = true;
			start = false;
			turn = 1;
			for (var i=0; i<3; i++) {
				for (var j=0; j<3; j++) {
					board[i][j] = '';
				}
			}
			for (var idx in boardWeight) {
		  	for (var pos in boardWeight[idx]) {
		  		boardWeight[idx][pos]=0;
		  	}
		  }
			$('.start-btn')
					.removeClass('btn-default')
					.addClass('btn-success');
			return false;
		}
		return true;
	}

	$(".cell").click(function(event){
		event.preventDefault();
		if (!start) return;
		if (finished || turn != 1) return;

		var x = $(this).data("x");
		var y = $(this).data("y");

		if (fillBoard(x, y, user)) {
			$(this).text(user);
			if(!finished)
				callBotMove(x, y);
		}
	});

	function fillBoard(x, y, symbol) {
		if(board[x][y] == ""){
			turn = (turn == 1)?2:1;
			board[x][y] = symbol;
			
			if (symbol==user) {
				boardWeight['H'][x]++;
				boardWeight['V'][y]++;
			} else {
				boardWeight['H'][x]--;
				boardWeight['V'][y]--;
			}
			if (x==1 && x==y) {
        boardWeight['D'][0] = symbol==user?
        		boardWeight['D'][0]+1:boardWeight['D'][0]-1;
        boardWeight['D'][1] = symbol==user?
        		boardWeight['D'][1]+1:boardWeight['D'][1]-1;
      } else if (x==y) {
        boardWeight['D'][0] = symbol==user?
        		boardWeight['D'][0]+1:boardWeight['D'][0]-1;
      } else if (Math.abs(y-2)==x) {
        boardWeight['D'][1] = symbol==user?
        		boardWeight['D'][1]+1:boardWeight['D'][1]-1;
      }
			
			validateStatus(symbol);
			return true;
		}
		return false;
	}

	function callBotMove (x, y) {
		var call = $.ajax({
			url: 'game/move/'+x+'/'+y+'/'+user,
			method: 'GET'
		});
		call.done(function(msg){
			var x = msg.x;
			var y = msg.y;
			var token = msg.token;
			if (fillBoard(x, y, token)) {
				$('.'+x+'_'+y).text(token);
			}
		});
		call.fail(function(){
			turn = (turn == 1)?2:1;
		});
	}

	$('.start-btn').click(function(ev){
		ev.preventDefault();
		if (start) return;
		var call = $.ajax({
			url: 'game/start',
			method: 'POST',
			data: {userToken:user}
		});

		call.done(function(msg){
				if (msg) {
					start = true;
					finished = false;
					turn = 1;
					$('.start-btn')
							.removeClass('btn-success')
							.addClass('btn-default');
					$('.cell').each(function(){
							$(this).text('');
						});
					$("h3").removeClass("alert alert-success text-center")
							.text("");
				}
			});

		call.fail(function(){
				start = false;
			});
	});

  return this; 

})();
