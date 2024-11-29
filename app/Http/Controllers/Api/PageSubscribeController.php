<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\Page\PageUnsubscribeRequest;
use App\Services\PageService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PageSubscribeController extends Controller
{
    /**
     * @param PageService $service
     */
    public function __construct(
        protected PageService $service
    ) {}

    /**
     * @param PageCreateRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(PageCreateRequest $request): JsonResponse
    {
        return $this->service->createPage(new UserService(), $request);
    }

    /**
     * @param PageUnsubscribeRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function delete(PageUnsubscribeRequest $request): JsonResponse
    {
        return $this->service->unsubscribePage(new UserService(), $request);
    }
}
