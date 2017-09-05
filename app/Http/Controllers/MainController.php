<?php

namespace App\Http\Controllers;

use App\Bot\Webhook\Entry;
use App\Jobs\BotHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function receive(Request $request)
    {
        /*$entries = Entry::getEntries($request);
        Log::info(print_r($entries, true));
        foreach ($entries as $entry) {
            $messagings = $entry->getMessagings();
            foreach ($messagings as $messaging) {
                dispatch(new BotHandler($messaging));
            }
        }
        return response("", 200);*/


        $data = $request->all();

        //get the user’s id
        $id = $data["entry"][0]["messaging"][0]["sender"]["id"];

        $this->sendTextMessage($id, "Hello");
    }

}
