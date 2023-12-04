<?php

namespace Valres\AntiPearlZone\Listener;

use pocketmine\entity\projectile\EnderPearl;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;

use pocketmine\player\Player;
use Valres\AntiPearlZone\Main;

class playerListener implements Listener
{
    public function __construct(public Main $plugin) {}

    public function onLaunch(ProjectileLaunchEvent $event): void
    {
        $entity = $event->getEntity();
        $player = $event->getEntity()->getOwningEntity();
        $config = $this->plugin->config();

        if($entity instanceof EnderPearl and $player instanceof Player){
            if(!$player->hasPermission("antipearl.bypass")){
                if($this->isPealZone($player)){
                    $event->cancel();
                    $player->sendMessage($config->get("message"));
                }
            }
        }
    }

    public function isPealZone(Player $player): bool
    {
        $config = $this->plugin->config();

        foreach($config->get("zones") as $world => ["min" => $min, "max" => $max]){
            if($player->getWorld()->getFolderName() === $world){
                if($player->getPosition()->x >= $min[0] and $player->getPosition()->x <= $max[0]){
                    if($player->getPosition()->y >= $min[1] and $player->getPosition()->y <= $max[1]){
                        if($player->getPosition()->z >= $min[2] and $player->getPosition()->z <= $max[2]){
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
