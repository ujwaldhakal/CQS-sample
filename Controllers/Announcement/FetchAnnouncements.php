<?php

namespace App\Http\Controllers\Announcement;


use App\Http\Requests\Announcement\AnnouncementCreationForm;
use App\Http\Transformers\CollectionTransformer;
use App\Services\ApiResponse;
use Ep\Announcement\Queries\Filters\AnnouncementFilter;
use Ep\Authentication\Entities\LoggedInUser;
use Illuminate\Foundation\Application;
use Ep\Services\Exception\ResponseableException;
use Illuminate\Http\Request;

class FetchAnnouncements
{
    public function __invoke(LoggedInUser $user, ApiResponse $response, Request $request, Application $application)
    {
        $filter = new AnnouncementFilter($request->all());

        try {
            $query = $application->make(\Ep\Announcement\Queries\FetchAnnouncements::class, [
                'companyId' => $user->getCompanyId(),
                'filter' => $filter
            ]);


            return $response->respondWithCollection($query, new CollectionTransformer());
        } catch (ResponseableException $exception) {

            $response->fail($exception->getResponseMessage());

            return $response;
        }
    }
}
