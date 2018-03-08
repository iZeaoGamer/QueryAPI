<?php

declare(strict_types=1);

namespace QueryAPI;

use pocketmine\plugin\PluginBase;

class Query extends PluginBase {

    public function onEnable() : void {
        $this->getLogger()->info("QueryAPI Enabled");
    }

    public static function queryServer(string $ip, int $port, int $timeout = 4) {
        $socket = @fsockopen("udp://" . $ip, $port, $errno, $errstr, $timeout);
        if($errno or $socket === false) {
            throw new QueryException($errstr, $errno);
        }
        stream_Set_Timeout($socket, $timeout);
        stream_Set_Blocking($socket, true);
        $requestPacket = "\x01";
        $requestPacket .= pack('Q*', mt_rand(1, 999999999));
        $requestPacket .= "\x00\xff\xff\x00\xfe\xfe\xfe\xfe\xfd\xfd\xfd\xfd\x12\x34\x56\x78";
        $requestPacket .= pack("Q*", 0);
        fwrite($socket, $requestPacket, strlen($requestPacket));
        $response = fread($socket, 4096);
        fclose($socket);
        if(empty($response) or $response === false) {
            return [
                "motd" => "",
                "online" => 0,
                "max" => 0,
                "version" => ""
            ];
        }
        if(substr($response, 0, 1) !== "\x1C") {
            throw new QueryException("An unknown error has occurred", E_WARNING);
        }
        $info = substr($response, 35);
        $info = preg_replace("#§.#", "", $info);
        $info = explode(";", $info);
        return [
            "motd" => $info[1],
            "version" =>  $info[3],
            "online" => $info[4],
            "max" => $info[5]
        ];
    }
}
