<?php

namespace mehrbod1gamer;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as T;

class PlayerTag extends PluginBase implements Listener
{
    public $pm = array();

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onChat(PlayerChatEvent $e){
        $player = $e->getPlayer();
        $msg = $e->getMessage();
        $array = (explode(" ", $msg));

        foreach ($array as $name){
            if($this->getServer()->getPlayer($name) instanceof Player){
                if($this->getServer()->getPlayer($name)->getName() == $name) {
                    array_push($this->pm, T::AQUA . $player->getName() . T::GREEN . " >> " . T::WHITE . $msg);
                    $new = str_replace($name, T::GREEN . "#" . $this->getServer()->getPlayer($name)->getName() . T::RESET, $msg);
                    $e->setMessage($new);
                }
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()){
            case "tag":
                if($sender instanceof Player){
                    if(isset($this->pm[0])){
                       $sender->sendMessage(T::GREEN . ">>" . T::YELLOW . "Last Tagged Messages :" . "\n");
                       $this->msgArray($sender);
                    } else {
                        $sender->sendMessage(T::RED . "There Is No Tagged Msg Yet");
                    }
                } else {
                 $sender->sendMessage(T::RED . "Use this command in game!");   
                }
        }
        return true;
    }

    public function msgArray(Player $player){
        $m = count($this->pm);
        if(isset($this->pm[0])) {
            $player->sendMessage(T::RED . "[1] " . $this->pm[$m -1]);
            if(isset($this->pm[$m - 2])) {
                $player->sendMessage(T::RED . "[2]" . $this->pm[$m - 2]);
            }
            if(isset($this->pm[$m - 3])) {
                $player->sendMessage(T::RED . "[3]" . $this->pm[$m - 3]);
            }
        }
    }
}
