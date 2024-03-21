<?php

namespace App\Repository\User;

use App\Interfaces\User\StatisticInterface;
use App\Models\View;
use App\Models\ViewLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticRepository implements StatisticInterface
{
    public function number_of_visits(Request $request)
    {
        $profile = auth()->user()->profile;
        $user = auth()->user();
        $count_links_views = $user->count_links_views($request->start_date, $request->end_date);
        $count_profile_views = $profile->count_views($request->start_date, $request->end_date);

        return response([
            'count_profile_views' => $count_profile_views ?? 0,
            'links_views' => $count_links_views,
        ]);
    }

    public function locations_for_link(Request $request)
    {
        if ($request->id_link) {
            return ViewLink::CountLinkByAddress($request->start_date, $request->end_date, Auth::id(), $request->id_link)->get();
        } else {
            return View::CountByAddress(Auth::id(), $request->start_date, $request->end_date)->get();

        }
    }
}
