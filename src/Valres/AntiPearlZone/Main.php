<?php

namespace Valres\AntiPearlZone;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Valres\AntiPearlZone\Listener\playerListener;

class Main extends PluginBase
{
    use SingletonTrait;

    protected function onEnable(): void
    {
        $this->getLogger()->info("by Valres est lancé !");
        $this->getServer()->getPluginManager()->registerEvents(new playerListener($this), $this);
        $this->saveDefaultConfig();
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    public function config(): Config
    {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }
}
