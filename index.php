<?php
/**
* AF: comment edited from git bash
*/
class Deck
{
	private $suits = array('Clubs', 'Diamonds', 'Hearts', 'Spades');
	private $cards = array('Ace', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King');
	private $deck  = array();

	public function __construct()
	{
		$this->setDeck();
	}

	private function setDeck()
	{
		foreach ($this->suits as $suit) {
			$this->deck[$suit] = $this->cards;
		}
	}

	public function getDeck($shuffle = false)
	{
		if ($shuffle) {
			// Thendo some algo here to shuffle the deck
		}
	}

	public function shuffleDeck()
	{

	}
}
