<?php

namespace App\Console\Commands;

use App\Models\AdPage;
use App\Models\User;
use App\Notifications\Page\PriceChangesEmailNotification;
use App\Services\CrawlService;
use App\Services\PageService;
use Illuminate\Console\Command;

class PriceChangeObserverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:price-change-observer-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a command to check the prices change status for each of the service';

    /**
     * Execute the console command.
     */
    public function handle(CrawlService $crawlService, PageService $pageService): void
    {
        $pages = AdPage::whereHas('users')->get();

        if ($pages->isEmpty()) {
            return;
        }

        foreach ($pages as $page) {
            try {
                $price = $crawlService->getPrice($page->url);

                if ($price === $page->previous_price) {
                    continue;
                }

                $this->sendEmailNotification($page->users()->pluck('user_id')->toArray(), [
                    'new_price' => $price,
                    'previous_price' => $page->previous_price,
                    'url' => $page->url,
                ]);

                $pageService->updatePagePrice($page, $price);
            } catch (\Exception $e) {
                \Log::error('Exception during cron crawling:', [
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * @param array $userIds
     * @param array $data
     * @return void
     */
    private function sendEmailNotification(array $userIds, array $data): void
    {
        $users = User::whereIn('id', $userIds)->get();

        if ($users->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $user->notify(new PriceChangesEmailNotification($data));
        }
    }
}
