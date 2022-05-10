<?php

namespace Laith98Dev\NoSpectatorHitSound;

/*  
 *  A plugin for PocketMine-MP.
 *  
 *	 _           _ _   _    ___   ___  _____             
 *	| |         (_) | | |  / _ \ / _ \|  __ \            
 *	| |     __ _ _| |_| |_| (_) | (_) | |  | | _____   __
 *	| |    / _` | | __| '_ \__, |> _ <| |  | |/ _ \ \ / /
 *	| |___| (_| | | |_| | | |/ /| (_) | |__| |  __/\ V / 
 *	|______\__,_|_|\__|_| |_/_/  \___/|_____/ \___| \_/  
 *	
 *	Copyright (C) 2022 Laith98Dev
 *  
 *	Youtube: Laith Youtuber
 *	Discord: Laith98Dev#0695
 *	Github: Laith98Dev
 *	Email: help@laithdev.tk
 *	Donate: https://paypal.me/Laith113
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 	
 */

use pocketmine\event\EventPriority;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\player\GameMode;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvent(DataPacketReceiveEvent::class, function (DataPacketReceiveEvent $event){
            $pk = $event->getPacket();
            $player = $event->getOrigin()->getPlayer();
            if($pk instanceof InventoryTransactionPacket){
                if($pk->trData instanceof UseItemOnEntityTransactionData){
                    if($pk->trData->getActionType() == UseItemOnEntityTransactionData::ACTION_ATTACK){
                        if($player->isSpectator() || $player->getGamemode()->equals(GameMode::SPECTATOR())){
                            // echo __METHOD__ . ", " . __LINE__ . ", Cancelled ....\n";
                            $event->cancel();
                        }
                    }
                }
            }
        }, EventPriority::LOW, $this);
    }
}