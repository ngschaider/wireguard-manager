<?php



class Client {

    public $name;
    public $publicKey;
    public $privateKey;
    public $allowedIPs;

    public static function findAll() {
        $clients = [];

        $config = FileHelper::getServerConfig();
        $blocks = FileHelper::getBlocks($config);
        foreach($blocks as $block) {
            $clients[] = FileHelper::parseClientBlock($block);
        }

        return $clients;
    }

    public static function delete($name) {
        $config = FileHelper::getServerConfig();
        $newConfig = FileHelper::replaceBlock($config, $name, "");
        FileHelper::setServerConfig($newConfig);

        FileHelper::deleteClientFiles($name);
    }

    public function validate() {
        if(!$this->name) {
            return false;
        }
        if(!$this->allowedIPs) {
            return false;
        }

        return true;
    }

    public function save() {
        FileHelper::createClientKeys($this->name);
        $this->publicKey = FileHelper::getClientPublicKey($this->name);
        $this->privateKey = FileHelper::getClientPrivateKey($this->name);


        FileHelper::createClientConfig($this);
        FileHelper::generateQR($this->name);

        $config = FileHelper::getServerConfig();
        $newConfig = FileHelper::addClient($config, $this);
        FileHelper::setServerConfig($newConfig);
    }

}
