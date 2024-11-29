<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Symfony\Component\DomCrawler\Crawler;

class CrawlService
{
    /**
     * @param string $url
     * @return int
     * @throws ValidationException
     */
    public function getPrice(string $url): int
    {
        try {
            $crawler = new Crawler(file_get_contents($url));

            $priceText = $crawler->filter('[data-testid="ad-price-container"] .css-90xrc0')->first()->text();

            if (! $priceText) {
                throw ValidationException::withMessages([
                    'error' => __('Price not found')
                ]);
            }

            $priceText = str_replace(' ', '', $priceText);

            $price = preg_replace('/(\d+).*$/', '$1', $priceText);

            return $price * 100;
        } catch (\Exception $e) {
            \Log::error('Crawl Site:', [
                'error' => $e->getMessage(),
            ]);

            throw ValidationException::withMessages([
                'error' => __('Something went wrong during price check. Please try again')
            ]);
        }
    }
}
