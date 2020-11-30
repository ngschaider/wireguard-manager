<?php



class Client {

    public $name;
    public $publicKey;
    public $allowedIPs;

    public static function findAll() {
        $content = file_get_contents(App::$app->basePath . "/output/wg0.conf");
        $lines = explode("\n", $content);

        $clients = [];
        $blockLines = [];
        $insideOfBlock = false;
        foreach($lines as $k => $v) {
            $lines[$k] = trim($v);
        }
        foreach($lines as $line) {
            if(substr($line, 0, 3) === "###") {
                if($insideOfBlock) {
                    $clients[] = $this->parseBlock($blockLines);
                    $blockLines = [];
                }
                $insideOfBlock = true;
            }

            if($insideOfBlock) {
                $blockLines[] = $line;
            }
        }
        $clients[] = self::parseBlock($blockLines);

        return $clients;
    }

    private static function parseBlock($blockLines) {
        $client = new Client();
        foreach($blockLines as $line) {
            if(substr($line, 0, 3) === "###") {
                $client->name = substr($line, 3, strlen($line));
            } else if(strpos($line, "PublicKey") !== false) {
                $pos = strpos($line, "=");
                $client->publicKey = trim(substr($line, $pos));
            } else if(substr($line, 0, 10) === "AllowedIPs") {
               $splits = explode("=", $line);
               $client->allowedIPs = trim($splits[1]);
           }
        }
        return $client;
    }

}
