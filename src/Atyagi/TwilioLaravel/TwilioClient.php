<?php namespace Atyagi\TwilioLaravel;

use Illuminate\Foundation\Application;
use Services_Twilio;

class TwilioClient {

    /** @var  Application */
    protected $app;

    /** @var  Services_Twilio */
    protected $client;

    public function __construct(Application $app, Services_Twilio $client)
    {
        $this->app = $app;
        $this->client = $client;
    }

    /**
     * @param $toNumber
     * @param $message
     * @return mixed
     */
    public function sendSMS($toNumber, $message)
    {
        $sentMessage = $this->client->account->messages->sendMessage(
            $this->app->make('config')->get('twilio-laravel::from_number'),
            $toNumber,
            $message
        );

        return $sentMessage->sid;
    }

    /**
     * @param $toNumber
     * @param $twiML
     * @return mixed
     */
    public function makeCall($toNumber, $twiML)
    {
        $call = $this->client->account->calls->create(
            $this->app->make('config')->get('twilio-laravel::from_number'),
            $toNumber,
            $twiML
        );

        return $call;
    }

    /**
     * @param $number
     * @return mixed
     */
    public function validateNumber($number)
    {
        $response = $this->client->account->outgoing_caller_ids->create($number);
        return $response->validation_code;
    }



} 