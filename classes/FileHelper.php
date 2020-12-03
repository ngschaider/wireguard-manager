<?php


class FileHelper {

    public static function getServerConfig() {
        return file_get_contents(App::$app->basePath . "/output/wg0.conf");
    }
    public static function setServerConfig($config) {
        $handle = fopen(App::$app->basePath . "/output/wg0.conf", "w");
        fwrite($handle, $config);
        fclose($handle);
    }

    public static function getBlocks($content) {
        $blocks = [];

        $lines = explode("\n", $content);

        $currentBlockLines = [];
        $insideOfBlock = false;
        foreach($lines as $line) {
            $begin3 = trim(substr($line, 0, 3));
            $begin4 = trim(substr($line, 0, 4));

            if($begin3 === "###") {
                $insideOfBlock = true;
            }

            if($insideOfBlock) {
                $currentBlockLines[] = $line;
            }

            if($begin4 === "###/") {
                $blocks[] = implode("\n", $currentBlockLines);
                $insideOfBlock = false;
                continue;
            }

        }

        return $blocks;
    }

    public static function replaceBlock($content, $name, $newBlock) {
        $lines = explode("\n", $content);
        $start = -1;
        $end = -1;

        foreach($lines as $i => $line) {
            $withoutWhitespace = preg_replace('/\s+/', '', $line);
            if($withoutWhitespace === "###" . $name) {
                if(isset($lines[$i-1]) && trim($lines[$i-1]) === "") {
                    $start = $i - 1;
                } else {
                    $start = $i;
                }
            }
            if($withoutWhitespace === "###/") {
                $end = $i + 1;
            }
        }

        // remove old block and add new one
        $newBlockLines = explode("\n", $newBlock);
        array_splice($lines, $start, $end - $start, $newBlockLines);

        return implode("\n", $lines);
    }

    public static function deleteClientFiles($name) {
        unlink(App::$app->basePath . "/output/clients/" . $name . "-publickey");
        unlink(App::$app->basePath . "/output/clients/" . $name . "-privatekey");
        unlink(App::$app->basePath . "/output/clients/" . $name . ".conf");
    }

    public static function parseClientBlock($block) {
        $blockLines = explode("\n", $block);
        $client = new Client();
        foreach($blockLines as $line) {
            $withoutWhitespace = preg_replace('/\s+/', '', $line);
            if(substr($withoutWhitespace, 0, 3) === "###" && substr($withoutWhitespace, 0, 4) !== "###/") {
                $client->name = substr($withoutWhitespace, 3, strlen($withoutWhitespace));
            } else if(substr($withoutWhitespace, 0, 9) === "PublicKey") {
                $client->publicKey = substr($withoutWhitespace, 10);
            } else if(substr($withoutWhitespace, 0, 10) === "AllowedIPs") {
               $client->allowedIPs = substr($withoutWhitespace, 11);
           }
        }
        return $client;
    }

    public static function createClientKeys($name) {
        exec("wg genkey | tee '" . App::$app->basePath . "/output/clients/" . $name . "-privatekey' | wg pubkey > '" . App::$app->basePath . "/output/clients/" . $name . "-publickey'");
    }

    public static function getClientPublicKey($name) {
        return trim(file_get_contents(App::$app->basePath . "/output/clients/" . $name . "-publickey"));
    }

    public static function getClientPrivateKey($name) {
        return trim(file_get_contents(App::$app->basePath . "/output/clients/" . $name . "-privatekey"));
    }

    public static function getServerPublicKey() {
        return trim(file_get_contents(App::$app->basePath . "/output/server-publickey"));
    }

    public static function createClientConfig($client) {
        $lines = [
            "[Interface]",
            "PrivateKey = " . $client->privateKey,
            "Address = " . $client->allowedIPs,
            "ListenPort = 51820",
            "",
            "[Peer]",
            "PublicKey = " . self::getServerPublicKey(),
            "AllowedIPs = 192.168.0.0/24",
            "Endpoint = ngschaider.duckdns.org:51820",
        ];

        $config = implode("\n", $lines);

        $handle = fopen(App::$app->basePath . "/output/clients/" . $client->name . ".conf", "w");
        fwrite($handle, $config);
        fclose($handle);
    }

    public static function generateQR($name) {
        $ret = exec("qrencode -o '" . App::$app->basePath . "/assets/qr/" . $name . ".png' < '" . App::$app->basePath . "/output/clients/" . $name . ".conf'");
    }

    public static function addClient($config, $client) {
        $lines = [
            "",
            "###" . $client->name,
            "[Peer]",
            "PublicKey = " . $client->publicKey,
            "AllowedIPs = " . $client->allowedIPs . "/32",
            "###/",
        ];

        return $config . implode("\n", $lines);
    }

}
?>
