<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DbFreshFull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fresh-full {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset database with full seed data (comprehensive testing with realistic data)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('force') === false && !$this->confirm('This will reset your database. Continue?')) {
            return 1;
        }

        $this->info('Resetting database with full seed data...');

        try {
            // Drop all tables
            Artisan::call('migrate:reset', ['--force' => true]);
            $this->info('✓ Dropped all tables');

            // Run migrations
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✓ Ran migrations');

            // Seed with full data
            Artisan::call('db:seed', ['--force' => true]);
            $this->info('✓ Seeded full data');

            $this->info('');
            $this->info('✅ Database reset complete with full seed data!');
            $this->info('');
            $this->table(
                ['Users', 'Spots', 'Events', 'Questions', 'Comments'],
                [
                    ['32', '25', '30', '60', '150']
                ]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
