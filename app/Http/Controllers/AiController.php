<?php

namespace App\Http\Controllers;

use Devcbh\LaravelAiProvider\Facades\Ai;
use Devcbh\LaravelAiProvider\Templates\PredictionTemplate;
use Devcbh\LaravelAiProvider\DTOs\Message;

class AiController extends Controller
{
    public function test()
    {
        $response = Ai::ask('What is the capital of France?');
        return response()->json(['data' => $response]);
    }

    public function ask()
    {
        $response = Ai::role('You are a helpful assistant.')
            ->ask('What is the capital of France?');

        return response()->json([
            'answer' => $response
        ]);
    }

    public function testTemplate()
    {
        $response = Ai::template(new PredictionTemplate(), [
            'data' => [10, 20, 30, 40],
            'target' => 'the next number in the sequence'
        ])->ask('Analyze and predict. Format the explanation in json');
        return $response;
    }

    public function testWithContext(){
        $response = Ai::lastContext([
            Message::user('My name is Arjhen.'),
            Message::assistant('Hello Arjhen! How can I help you today?'),
            Message::user('I am sad.'),
            Message::assistant('I am sorry to hear that from you but no luck'),
        ])->ask('what do you mean?');
        return response()->json(['data' => $response]);
    }
}
