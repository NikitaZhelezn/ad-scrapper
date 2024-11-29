<?php

namespace App\Services;

use App\Models\AdPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageService
{
    /**
     * @param UserService $userService
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createPage(UserService $userService, Request $request): JsonResponse
    {
        if (! $page = AdPage::where('url', $request->page_url)->first()) {
            $price = (new CrawlService())->getPrice($request->page_url);
            $page = AdPage::create([
                'url' => $request->page_url,
                'previous_price' => $price,
            ]);
        }

        $user = $userService->getUser($request->email);
        $userService->attachPage($user, $page);

        return response()->json([
            'message' => __('Price change notification successfully created'),
            'status' => __('Success'),
        ]);
    }

    /**
     * @param AdPage $page
     * @param int $price
     * @return void
     */
    public function updatePagePrice(AdPage $page, int $price): void
    {
        $page->update([
            'previous_price' => $price,
        ]);
    }

    /**
     * @param UserService $userService
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function unsubscribePage(UserService $userService, Request $request): JsonResponse
    {
        $user = $userService->getUser($request->email);
        $page = AdPage::where('url', $request->page_url)->first();

        if (! $user->pages()->where('page_id', $page->id)->exists()) {
            throw ValidationException::withMessages([
                'error' => __('You have not subscribed to this page notification.')
            ]);
        }

        $user->pages()->detach($page);

        if (! $page->users()->exists()) {
            $page->delete();
        }

        return response()->json([
            'message' => __('You have been successfully described from price change notification.'),
            'status' => __('Success'),
        ]);
    }
}
