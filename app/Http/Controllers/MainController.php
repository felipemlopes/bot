<?php

namespace App\Http\Controllers;

use App\Bot\Webhook\Entry;
use App\Jobs\BotHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    /*public function receive(Request $request)
    {
        $entries = Entry::getEntries($request);
        Log::info(print_r($entries, true));
        foreach ($entries as $entry) {
            $messagings = $entry->getMessagings();
            foreach ($messagings as $messaging) {
                dispatch(new BotHandler($messaging));
            }
        }
        return response("Hello", 200);
        //return response("Hello", 200);
    }*/

    public function __construct(Request $request) {
        Log::info(print_r($request->all(), true));
    }
    public function receive(Request $request)
    {
        $data = $request->all();
        //get the user id and reply
        $id = $data["entry"][0]["messaging"][0]["sender"]["id"];
        $this->sendTextMessage($id, "Hello");
    }
    private function sendTextMessage($recipientId, $messageText)
    {
        $messageData = [
            "recipient" => [
                "id" => $recipientId
            ],
            "message" => [
                "text" => $messageText
            ]
        ];
        $this->callSendApi($messageData);
    }
    private function callSendApi($messageData)
    {
        $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=' . env("PAGE_ACCESS_TOKEN"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        Log::info(print_r(curl_exec($ch), true));
    }

}
