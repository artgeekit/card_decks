<?php
/**
* AF: cloned to home pc
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
		// var_dump(count($this->deck));
		// var_dump($this->deck);
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

$cards = new CardDeck();
$style = '';

foreach ($cards->getDeck(true) as $card) {
	foreach ($card as $suit => $value) {
		$style = in_array($suit, $cards->color) ? ' style="color:red;"' : '';
		echo '<strong' . $style . '>' . $cards->symbols[$suit] . $value . ' </strong>';
	}
}
