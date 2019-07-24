<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Channel;
use Laratube\Subscription;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel)
    {
        try {
            $subscription = $channel->subscriptions()->create(['user_id' => auth()->id()]);
            return response()->json($subscription, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Channel $channel
     * @param Subscription $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel, Subscription $subscription)
    {
        try {
            $subscription->delete();
            return response()->json($subscription, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
