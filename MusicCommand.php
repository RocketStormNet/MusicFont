<?php

namespace Longman\TelegramBot\Commands\UserCommands;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\TelegramLog;
use Medoo\Medoo;

/**
 * User "/music" command
 */
class MusicCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'music';
    /**
     * @var string
     */
    protected $description = 'Get free music from Telegram Bot';
    /**
     * @var string
     */
    protected $usage = '/music <genre>';
    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    
    /**
     * Using Medoo as database framework
     */
    public function getData()
    {
        return new Medoo([
        	'database_type' => 'mysql',
        	'database_name' => 'database_name',
        	'server' => 'localhost',
        	'username' => 'username',
        	'password' => 'password',
    	]);    
    }
     
    public function execute()
    {
        $index = rand(0,5);
        $datas = $this->getData();
        $track = $datas->select("musicdb", "*");
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        /**
         * Creating a string with track metadata for caption in message
         */
        $text = $track[$index]["artist"] . " - " . $track[$index]["name"] . " 🎵 " . "License: " . $track[$index]["license"];

        /**
         * Saving array of data
         */
        $data = [
            'chat_id' => $chat_id,
            'caption' => $text,
        ];

        /**
         * Sending audio file with caption to user
         */
        return Request::sendAudio($data, "https://sitename.com" . $track[$index]["link"]);
    }
}

