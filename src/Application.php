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
    public function __construct(Client $client callable $securityLayerCallback)
    {
        (new SecurityLayer)->check($securityLayerCallback);

        $this->client = $client;
        $this->registry = new BasicRegistry($client, dirname(__DIR__) . '/static.json';
    }

    /**
     * Run the Application
     *
     */
    public function runWebhook()
    {
        $handler = new WebhookRegistry($this->registry);

        $handler->handle();
    }
}
