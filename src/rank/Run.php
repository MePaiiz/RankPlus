<?php

namespace rank;

use pocketmine\scheduler\Task;

use rank\Main;

class Run extends Task{
    
    public function __construct(Main $main){
		$this->main = $main;
	}
		
	public function onRun($currentTick){
		$this->main->onRepeat();
	}
}