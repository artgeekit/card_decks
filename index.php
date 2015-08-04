<?php
session_start();
/**
* @author Arthur Frank <frank.artur0303@gmail.com>
* @date 04/08/2015
* This is class to generate and work with a deck of cards
*/
class CardDeck
{
	private $suits     = array('c', 'd', 'h', 's');
	private $cards     = array('A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K');
	private $deck      = array();
	public  $symbols   = array('c' => '&clubs;', 'd' => '&diams;', 'h' => '&hearts;', 's' => '&spades;');
	public  $color     = array('h', 'd');

	public function __construct()
	{
		$shuffle = true;
		$this->setDeck($shuffle);
	}

	private function setDeck($shuffle = false)
	{
		foreach ($this->suits as $suit) {
			foreach ($this->cards as $card) {
				$this->deck[] = array($suit => $card);
			}
		}
		if ($shuffle) {
			$this->shuffleDeck();
		}
	}

	public function getDeck()
	{
		return $this->deck;
	}

	private function shuffleDeck()
	{
		$bits    = array();
		$newDeck = array();
		
		shuffle($this->deck);
		
		for ($i = 0; $i < 52; $i++) { 
			if ($i % 2 == 0) {
				$bits['even'][] = $this->deck[$i];
			} else {
				$bits['odd'][] = $this->deck[$i];
			}
		}
		shuffle($bits['even']);
		shuffle($bits['odd']);

		$newDeck    = array_merge($bits['odd'], $bits['even']);
		$this->deck = $newDeck;
		
		shuffle($this->deck);
	}
}

class PokerGame extends CardDeck
{
	public $session;
	public $currentDeck = array();
	private $players = array(
		array('name' => 'Lunj', 'cards' => array(), 'chance' => 0),
		array('name' => 'Petr', 'cards' => array(), 'chance' => 0),
		array('name' => 'Arthur', 'cards' => array(), 'chance' => 0),
		array('name' => 'Alex', 'cards' => array(), 'chance' => 0),
		array('name' => 'Eug', 'cards' => array(), 'chance' => 0),
		array('name' => 'Ped', 'cards' => array(), 'chance' => 0),
		);

	public function __construct()
	{
		parent::__construct();

		if (empty($_SESSION['game'])) {
			$this->setSession();
		}
	}

	public function setSession()
	{
		$_SESSION['game']['players'] = $this->players;
		$_SESSION['game']['deck']    = $this->getDeck();
		$_SESSION['game']['status']  = 'pending';
	}

	public function startGame()
	{
		if (isset($_SESSION['game']['status']) AND $_SESSION['game']['status'] == 'pending') {
			$_SESSION['game']['status'] = 'in-progress';
			$pn = count($_SESSION['game']['players']); // Number of players

			foreach ($_SESSION['game']['players'] as $id => $playData) { 
				$_SESSION['game']['players'][$id]['cards'][] = $_SESSION['game']['deck'][$id];
				$_SESSION['game']['players'][$id]['cards'][] = $_SESSION['game']['deck'][$id + $pn];
				
				unset($_SESSION['game']['deck'][$id]);
				unset($_SESSION['game']['deck'][$id + $pn]);
			}
		}
		// $this->updateSession();
	}
}
// unset($_SESSION['game']);
// var_dump($_SESSION['game']['players'][0]);
// var_dump($_SESSION['game']['deck']);

$pokerGame = new PokerGame();
$cards     = new CardDeck();

$pokerGame->startGame();

$style = '';

foreach ($cards->getDeck(true) as $card) {
	foreach ($card as $suit => $value) {
		$style = in_array($suit, $cards->color) ? ' style="color:red;"' : '';
		echo '<strong' . $style . '>' . $cards->symbols[$suit] . $value . ' </strong>';
	}
}
foreach ($_SESSION['game']['players'] as $id => $playData) {
	$c = '';
	
	foreach ($playData['cards'] as $id => $card) {
		foreach ($card as $suit => $value) {
			$style = in_array($suit, $cards->color) ? ' style="color:red;"' : '';
			$c .= '<strong' . $style . '>' . $cards->symbols[$suit] . $value . ' </strong>';
		}
	}
	echo "<p>Player Name: " . $playData['name'] . ", Cards: " . $c . "</p>";
}
?>

<style type="text/css">
	.play1, .play2, .play3, .play4, .play5, .play6 {margin: 10px; width: 100px; height: 100px; display: inline-block; border: 1px solid #000;}
	.table {width: 500px; height: 250px; border: 1px solid #000; display: inline-block;}
	.wrap {width: 750px;}
	.table, .play4 {float: right;}
	.play3 {float: left;}
	.clear {clear: both;}
	.up-line, .bottom-line {text-align: center; overflow: hidden;}
</style>

<div class="wrap">
	<div class="up-line">
		<div class="play1">Player 1</div>
		<div class="play2">Player 2</div>
	</div>
	<div class="left-side">
		<div class="play3">Player 3</div>
	</div>
	<div class="right-side">
		<div class="play4">Player 4</div>
	</div>
	<div class="table">TABLE</div>
	<div class="clear"></div>
	<div class="bottom-line">
		<div class="play5">Player 5</div>
		<div class="play6">Player 6</div>
	</div>
</div>


