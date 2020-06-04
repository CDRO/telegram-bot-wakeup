<?php

namespace Cdro\TelegramBotWakeup;

use \Cdro\TelegramBotCore\Client\Client;
use \Cdro\TelegramBotCore\Registry\BasicRegistry;
use \Cdro\TelegramBotCore\Helper\WebhookRegistry;
use \Cdro\TelegramBotCore\Security\SimpleLayer as SecurityLayer;

class Application
{

    /**
     *
     */
    public function __construct(Client $client, callable $securityLayerCallback)
    {
        (new SecurityLayer)->check($securityLayerCallback);

        $this->client = $client;
        $this->registry = (new BasicRegistry($client, dirname(dirname(dirname(__DIR__))) . '/wakeup_static.json'))->load();
    }

    /**
     * Run the Application
     *
     */
    public function runWebhook()
    {
        (new WebhookRegistry($this->registry))->handle();
    }

    /**
     * Run the 2FA distribution
     */
    public function run()
    {
        $data = $this->registry->get();

        if(!empty($data->{$_POST['chat_id']})) {
            $this->client->sendMessage($_POST['chat_id'], $_POST['text']);
        }
    }
}
