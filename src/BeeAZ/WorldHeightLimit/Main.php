<?php

namespace BeeAZ\WorldHeightLimit;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;

class Main extends PluginBase implements Listener{
  
  public function onEnable(): void{
   $this->getServer()->getPluginManager()->registerEvents($this, $this);
   $this->saveDefaultConfig();
  }
  
  public function onPlace(BlockPlaceEvent $event){
   $player = $event->getPlayer();
   $blockTransaction = $event->getTransaction()->getBlocks();
   $blocks = null;
   foreach ($blockTransaction as [$x, $y, $z, $block]) {
      $blocks = $block;
   }
   $pos = $blocks->getPosition();
   $world = $player->getWorld()->getFolderName();
   $config = $this->getConfig()->getAll();
     if(in_array($world, $config["Worlds"])){
       if($pos->y > $config["Height"]){
         $player->sendMessage($config["Message"]);
         $event->cancel();
    }
   }
  }
 }
