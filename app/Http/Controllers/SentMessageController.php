<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Message;
use App\Services\MessageSendingService;

class SentMessageController extends Controller
{
    //
    public function store($id,StoreRequest $request)
    {
        $listing=Listing::where('uuid',$id)->first();
        if(!$listing)
        {

          return  response()->json(['message'=>'not found'],404);
        }

        //check validations for message
        $validated = $request->validate([
            'message' => 'required',
        ]);



        //send message
        $message=Message::create(['listing_id'=>$listing->uuid,'body'=>$request->message]);
        (new MessageSendingService())->send($message);
        return response()->json(['message'=>'Message'],200);
    }
}
