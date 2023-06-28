<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Listing;
use App\Models\Message;
use App\Services\MessageSendingService;

class SentMessageController extends Controller
{
    //
    public function store($id,StoreRequest $request,MessageSendingService $mss)
    {
        $listing=Listing::where('uuid',$id)->first();

        if(!$listing)
        {
          return  response()->json(['message'=>'not found'],404);
        }

        //send message
        $message=Message::create(['listing_id'=>$listing->uuid,'body'=>$request->message]);
        $mss->send($message);

        return response()->json(['message'=>'message sent successfully'],200);
    }
}
