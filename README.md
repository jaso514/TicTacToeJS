# TicTacToeJS
## Install & Requirements
**Requirements**:
(The application was testing with the next versions)
- PHP 5.6 
- PHPUnit 5.6
- Apache 2

**Install**:
Clone the application in the web directory.
Access with path: localhost/TicTacToeJs (or the folder with you download the game)

## How to Play
+ To start the game is necesary access to the previous url.
+ In the main page press the green start button and begin the game (after clicked, the button, pass to disabled) . The default token is "X" for the user.
+ When the game finished the start burros pass to enabled again and can begin a new match.

## File Description
- *index.php*: Load the application.
- *Libs/BaseController*: is the parent class of the controller views.
- *Libs/Template*: search and display the template.
- *Libs/RestController*: Manage the REST services, verifing if the rout is configured and redirecting to the action.
- *Libs/MoveTicTacToe*: Class that select the best option to move the token in the game
- *Core/Main*: Match the url with the appropriate class, methos and attributes, if the url is invalid send and 404 exception.
- *Core/config*: Has the config array with the defaultController and the routes of the rest Api with the related methods.
- *App/Controller/TicTacToeController*: The controller is the Main class to show the game interface. 
- *App/Controller/GameController*: Has the REST API methods to move the bot, this class call MoveTicTacToe to decide the movement.
- *public/js/app.js*: has all the jquery function to show and move the boar game.
- *phpunit/TicTacToeTest*: Class test to verify the cases of the bot move.

## Unit Test
Use phpunit phar to visualize the five test making to the application.
```./phpunit.phar phpunit/TicTacToeTest.php```
