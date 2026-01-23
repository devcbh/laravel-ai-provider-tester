<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AiTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:test {prompt=Hello? : The prompt to send to the AI} {--driver= : The driver to use (openai, gemini, claude, etc.)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the Laravel AI Provider';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prompt = $this->argument('prompt');
        $driverName = $this->option('driver') ?: config('ai.default');

        $this->info("Using driver: {$driverName}");
        $this->info("Sending prompt: {$prompt}");

        try {
            $response = \Devcbh\LaravelAiProvider\Facades\Ai::driver($driverName)
                ->role('You are a helpful assistant.')
                ->ask($prompt);

            $this->success("Response:");
            $this->line($response);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    protected function success($message)
    {
        $this->output->writeln("<info>{$message}</info>");
    }
}
