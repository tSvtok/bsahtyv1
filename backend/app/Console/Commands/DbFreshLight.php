<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DbFreshLight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fresh-light {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset database with lightweight seed data (fast iteration for development)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('force') === false && !$this->confirm('This will reset your database. Continue?')) {
            return 1;
        }

        $this->info('Resetting database with lightweight seed data...');

        try {
            // Drop all tables
            Artisan::call('migrate:reset', ['--force' => true]);
            $this->info('✓ Dropped all tables');

            // Run migrations
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✓ Ran migrations');

            // Seed with lightweight data
            Artisan::call('db:seed', [
                '--class' => 'Database\Seeders\LightweightSeeder',
                '--force' => true,
            ]);
            $this->info('✓ Seeded lightweight data');

            $this->info('');
            $this->info('✅ Database reset complete with lightweight data!');
            $this->info('');
            $this->table(
                ['Users', 'Spots', 'Events', 'Questions'],
                [
                    ['2 (admin + athlete)', '5', '3', '5']
                ]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
