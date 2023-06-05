<?php
namespace rank;
use pocketmine\{Player, Server};
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\{Listener, player\PlayerDeathEvent, player\PlayerJoinEvent, entity\EntityDamageByEntityEvent, player\PlayerChatEvent};
use pocketmine\command\{Command, CommandSender};
class Main extends PluginBase implements Listener{
    ##ตั้งค่า text ข่้อความ
    public $tag = "§8[§6R§ea§6n§ek §6P§el§6u§es§8]§r";
    ##ตั้งค่าชื่อยศ
    public $rank1 = "§2B§ar§2o§an§2z§ae";
    public $rank2 = "§7S§fl§7i§fv§7e§fr";
    public $rank3 = "§6G§eo§6l§ed";
    public $rank4 = "§5P§dl§5a§dt§5i§dn§5u§dm";
    public $rank5 = "§3D§bi§3a§bm§3o§bn§3d";
    public $rank6 = "§cC§6o§em§am§ba§dn§cd§6e§er";
    ##ตั้งค่าแต้มในการอัพยศ
    public $rank1point = 0;
    public $rank2point = 100;
    public $rank3point = 225;
    public $rank4point = 350;
    public $rank5point = 475;
    public $rank6point = 600;
    ##สุ่มลบแต้มตอนตาย
    public $deathmin = 3;
    public $deathmax = 7;
    ##สุ่มเพิ่มแต้มตอนฆ่าคน
    public $killmin = 20;
    public $killmax = 20;
    function onLoad(){
        $this->getServer()->getLogger()->info("[RankPlus] ปลั๊กอินกำลังโหลด!");
    }
    function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Run($this), 20 * 1);
        $this->getServer()->getLogger()->info("[RankPlus] ปลั๊กอินทำงานแล้ว!");
        @mkdir($this->getDataFolder());
        $this->rank = new Config($this->getDataFolder()."rank.yml", Config::YAML);
        $this->point = new Config($this->getDataFolder()."point.yml", Config::YAML);
    }
    function onRepeat(){
        foreach($this->getServer()->getOnlinePlayers() as $p){
            $rank = $this->myRank($p);
            $point = $this->myPoint($p);
            $p->sendTip("Rank: ".$rank." Point: ".$point);
            if($this->myRank($p) == $this->rank1){
                if($this->myPoint($p) >= $this->rank2point){
                    $this->setPoint($p, 0);
                    $this->setRank($p, $this->rank2);
                    $p->sendMessage($this->tag." §fยินดีด้วยยศของคุณอัพเกรดเป็น ".$this->rank2." §fแล้ว!");
                }
            }
            if($this->myRank($p) == $this->rank2){
                if($this->myPoint($p) >= $this->rank3point){
                    $this->setPoint($p, 0);
                    $this->setRank($p, $this->rank3);
                    $p->sendMessage($this->tag." §fยินดีด้วยยศของคุณอัพเกรดเป็น ".$this->rank3." §fแล้ว!");
                }
            }
            if($this->myRank($p) == $this->rank3){
                if($this->myPoint($p) >= $this->rank4point){
                    $this->setPoint($p, 0);
                    $this->setRank($p, $this->rank4);
                    $p->sendMessage($this->tag." §fยินดีด้วยยศของคุณอัพเกรดเป็น ".$this->rank4." §fแล้ว!");
                }
            }
            if($this->myRank($p) == $this->rank4){
                if($this->myPoint($p) >= $this->rank5point){
                    $this->setPoint($p, 0);
                    $this->setRank($p, $this->rank5);
                    $p->sendMessage($this->tag." §fยินดีด้วยยศของคุณอัพเกรดเป็น ".$this->rank5." §fแล้ว!");
                }
            }
            if($this->myRank($p) == $this->rank5){
                if($this->myPoint($p) >= $this->rank6point){
                    $this->setPoint($p, 0);
                    $this->setRank($p, $this->rank6);
                    $p->sendMessage($this->tag." §fยินดีด้วยยศของคุณอัพเกรดเป็น ".$this->rank6." §fแล้ว!");
                }
            }
            if($this->myRank($p) == $this->rank6){
                switch(rand(0, 9)){
                    case 0:
	                    $p->setNameTag("§4".$p->getName());
	                break;
                    case 1:
	                    $p->setNameTag("§c".$p->getName());
	                break;
                    case 2:
	                    $p->setNameTag("§6".$p->getName());
	                break;
                    case 3:
	                    $p->setNameTag("§e".$p->getName());
	                break;
                    case 4:
	                    $p->setNameTag("§2".$p->getName());
	                break;
                    case 5:
	                    $p->setNameTag("§a".$p->getName());
	                break;
                    case 6:
	                    $p->setNameTag("§3".$p->getName());
	                break;
                    case 7:
	                    $p->setNameTag("§b".$p->getName());
	                break;
                    case 8:
	                    $p->setNameTag("§5".$p->getName());
	                break;
                    case 9:
	                    $p->setNameTag("§d".$p->getName());
	                break;
                }
            }
        }
    }
    function onCommand(CommandSender $p, Command $cmd, $label, array $args){
        if($cmd->getName() == "setrank"){
            if($args[1] == "1"){
                $rank = $this->rank1;
            }
            if($args[1] == "2"){
                $rank = $this->rank2;
            }
            if($args[1] == "3"){
                $rank = $this->rank3;
            }
            if($args[1] == "4"){
                $rank = $this->rank4;
            }
            if($args[1] == "5"){
                $rank = $this->rank5;
            }
            if($args[1] == "6"){
                $rank = $this->rank6;
            }
            if(!$p->isOp()){
                $p->sendMessage($this->tag." ไม่สามารถใช้คำสั่งนี้ได้");
                return true;
            }
            $player = $this->getServer()->getPlayer($args[0]);
            if(!$player){
                $p->sendMessage($this->tag." ขออภัย ไม่พบผู้เล่น!!");
                return true;
            }else{
                $p->sendMessage($this->tag."คุณได้เซ็ตยศให้ §e".$player->getName()." §fเป็นยศ§r ".$rank);
                $player->sendMessage($this->tag."แอดมินได้เซ็ตยศของคุณเป็น §r".$rank);
                $this->setPoint($player, 0);
                $this->setRank($player, $rank);
                return true;
            }
        }
    }
    function myPoint($p){
        return $this->point->get($p->getName());
    }
    function setPoint($p, $count){
        $this->point->set($p->getName(), $count);
        $this->point->save();
    }
    function addPoint($p, $count){
        $this->point->set($p->getName(), $this->point->get($p->getName()) + $count);
        $this->point->save();
    }
    function delPoint($p, $count){
        $this->point->set($p->getName(), $this->point->get($p->getName()) - $count);
        $this->point->save();
    }
    function myRank($p){
        return $this->rank->get($p->getName());
    }
    function setRank($p, $rank){
        $this->rank->set($p->getName(), $rank);
        $this->rank->save();
    }
    function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		if(!$this->rank->get($player->getName())){
            $this->rank->set($player->getName(), $this->rank1);
            $this->rank->save();
        }
        if(!$this->point->get($player->getName())){
            $this->point->set($player->getName(), 0);
            $this->point->save();
        }
	}
    function onChat(PlayerChatEvent $ev){
	    $p = $ev->getPlayer();
	    $group = $this->myRank($p);
	    $name = $p->getName();
	    $msg = $ev->getMessage();
	    $ev->setFormat("§8[§fยศ: §r".$group."§8] §r".$name." §7: §r".$msg);
	}
    function onDeath(PlayerDeathEvent $ev){
        $p = $ev->getPlayer();
        if($this->myPoint($p) != 0){
            $this->delPoint($p, rand($this->deathmin, $this->deathmax));
        }
        if($p->getLastDamageCause() instanceof EntityDamageByEntityEvent){
			if($p->getLastDamageCause()->getDamager() instanceof Player){
				$killer = $p->getLastDamageCause()->getDamager();
		        $this->addPoint($killer, rand($this->killmin, $this->killmax));
			}
		}
    }
    function onDisable(){
        $this->getServer()->getLogger()->info("[RankPlus] ปลั๊กอินปิดการใช้งานแล้ว!");
    }
}