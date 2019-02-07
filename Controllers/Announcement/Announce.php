<?php

namespace App\Http\Controllers\Announcement;

use App\Http\Requests\Announcement\AnnouncementCreationForm;
use App\Http\Transformers\Transformer;
use App\Services\ApiResponse;
use Ep\Announcement\Services\AnnouncementCreationService;
use Ep\Authentication\Entities\LoggedInUser;
use Ep\Announcement\Events\AnnouncementCreated;
use Illuminate\Foundation\Application;
use Ep\Services\Exception\ResponseableException;

class Announce
{
    public function __invoke(LoggedInUser $user, ApiResponse $response, AnnouncementCreationForm $request, Application $application)
    {
        try {
            $announcementCreationService = $application->make(AnnouncementCreationService::class, [
                'content' => $request->get('content'),
                'title' => $request->get('title'),
                'mustRead' => $request->get('is_must_read'),
                'hr' => $user,
            ]);

            event(new AnnouncementCreated($announcementCreationService));

            return $response->respondWithItem($announcementCreationService->extract(), new Transformer());
        } catch (ResponseableException $exception) {
            $response->fail($exception->getResponseMessage());

            return $response;
        }
    }
}
