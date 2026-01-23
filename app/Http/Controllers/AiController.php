<?php

namespace App\Http\Controllers;

use Devcbh\LaravelAiProvider\Facades\Ai;
use Devcbh\LaravelAiProvider\Templates\CodeReviewTemplate;
use Devcbh\LaravelAiProvider\Templates\PredictionTemplate;
use Devcbh\LaravelAiProvider\DTOs\Message;
use Illuminate\Support\Facades\File;
use Devcbh\LaravelAiProvider\Templates\SummarizationTemplate;
use Illuminate\Support\Facades\Process;

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



    public function analyzeDirectory()
    {
        $files = File::allFiles(app_path('Http/Controllers'));
        $reviews = [];

        foreach ($files as $file) {
            $content = $file->getContents();

            $reviews[$file->getFilename()] = Ai::template(new CodeReviewTemplate(), [
                'code' => $content,
                'language' => 'PHP'
            ])->ask('Analyze this file for best practices and security.');
        }

        return response()->json($reviews);
    }

    public function explainCommit(string $commitHash = 'HEAD')
    {
        // Retrieve the commit diff using git
        $result = Process::run("git show {$commitHash}");

        if ($result->failed()) {
            return response()->json(['error' => 'Commit not found or git error.'], 404);
        }

        $commitDiff = $result->output();

        // Use the AI to explain the commit changes
        $explanation = Ai::template(new SummarizationTemplate(), [
            'content' => substr($commitDiff, 0, 10000),
            'max_length' => '5 sentences'
        ])->ask("Explain what changes were made in this commit and why they might be important.");

        return response()->json([
            'commit' => $commitHash,
            'explanation' => $explanation
        ]);
    }
}
