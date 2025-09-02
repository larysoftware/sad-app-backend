<?php

namespace App\HomePage\View\Controllers;

use App\HomePage\Application\Queries\GetWelcomeMessageQuery;
use Illuminate\Http\JsonResponse;

class HomeController
{
    public function __construct(
        private GetWelcomeMessageQuery $getWelcomeMessageQuery
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->getWelcomeMessageQuery->execute()
        );
    }
}
