<?php
include "Rank.php";
// **********************************************
// Author: Guillem Caball� Tom�s
// **********************************************

// Match class is the registry of a played game with a certain ingame account by a Booster
class Match
{
  //unique code
  private $id;
  
  //the website account of the booster
  private $booster;
  
  //rank of the account before and after the match
  private $fromRank;
  private $toRank;
  
  //in-game account
  private $gameAccount;
  
  //integer result: 1 ->win, 0->loss
  private $gameResult;
  
  //timestamp when the game was played
  private $timestamp;
  
  public function __construct($booster_id, $result, $purchase_id, $from, $to) {
      $this->setId(uniqid());
      $this->booster = $booster_id;
      /*
       * Hauria de fer un new Account(); del booster
       */
      $this->setTimestamp(time());
      $this->setGameResult($result);
      //aqui també
      $this->purchase = $purchase_id;
      $this->setFromRank($from);
      $this->setToRank($to);
  }
  
  public function setId($param){
    $this->id = $param;
  }
  
  public function getId(){
      return $this->id;
  }
  
  public function setBooster($param){
    $this->booster = $param;
  }
  
  public function getBooster(){
    return $this->booster;
  }
  
  public function setFromRank($param){
	$this->fromRank = $param;
  }
  
  public function getFromRank(){
    return $this->fromRank;
  }

  public function setToRank($param){
    $this->toRank = $param;
  }
  
  public function getToRank(){
    return $this->toRank;
  }

  public function setGameAccount($param){
    $this->gameAccount = $param;
  }
  
  public function getGameAccount(){
    return $this->gameAccount;
  }

  public function setGameResult($param){
    $this->gameResult = $param;
  }
  
  public function getGameResult(){
    return $this->gameResult;
  }

  public function setTimestamp($param){
    $this->timestamp = $param;
  }
  
  public function getTimestamp(){
    return $this->timestamp;
  }
  
  public function getTimestampString(){
    return gmdate('Y-m-d h:i:s \G\M\T', $this->getTimestamp());
  }

  public function toString(){
      /* $booster hauria de ser $booster->getId()
         el mateix amb $purchase
      */
      return "The booster: $this->booster played with the account (of the purchase id = ".$this->purchase.
             ") the day ".$this->getTimestampString()." and ".($this->gameResult==1?"won":"lost").
             ". Its rank changed from ".$this->fromRank->toString()." to ".$this->toRank->toString(). ".";
  }
	
}
?>