<?php

namespace App\Repository\User;

use App\Http\Resources\UserResource;
use App\Interfaces\User\ProfileInterface;
use App\Models\Profile;
use App\Models\ProfilePrimaryLink;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileRepository implements ProfileInterface
{
    public function store_personal_data($request)
    {
        $user = auth()->user();
        $user->profile()->updateOrCreate(['user_id' => Auth::id()], $request->validated());
        $user->update(['email' => $request->email, 'userName' => ($request->firstName ?? $user->firstName).($request->lastName ?? $user->lastName)]);

        return UserResource::make($user);
    }

    public function store_links($request)
    {
        if (isset($request->primaryLinks)) {
            $primaryLinks = [];
            foreach ($request->primaryLinks as $index => $primaryLink) {
                $primaryLinks[$index] = [
                    'user_id' => Auth::id(),
                    'primary_link_id' => $primaryLink['id'],
                    'value' => $primaryLink['value'],
                ];
            }
            ProfilePrimaryLink::insert($primaryLinks);
        }

        return UserResource::make(Auth::user());

    }

    public function store_other_data($request)
    {
        $user = Auth::user();
        $user->profile()->updateOrCreate(['user_id' => Auth::id()], $request->validated());

        return UserResource::make($user);
    }

    public function store_theme($request)
    {
        $user = Auth::user();
        $user->profile()->updateOrCreate(['user_id' => Auth::id()], $request->validated());

        return UserResource::make($user);
    }

    public function show(User $user)
    {
        return UserResource::make($user);

    }

    public function update($request)
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $profile->update($request->safe()->except('primaryLinks'));
        $user->update(['userName' => ($request->firstName ?? $user->firstName).($request->lastName ?? $user->lastName)]);
        if (isset($request->primaryLinks)) {
            $user->primary()->detach();
            $primaryLinks = [];
            foreach ($request->primaryLinks as $index => $primaryLink) {
                $primaryLinks[$index] = [
                    'user_id' => Auth::id(),
                    'primary_link_id' => $primaryLink['id'],
                    'value' => $primaryLink['value'],
                ];
            }
            ProfilePrimaryLink::insert($primaryLinks);
        }

        return UserResource::make($user);

    }

    public function visit($request)
    {
        DB::statement('CALL insert_profile_address(?, ?)', [$request->profile_id, $request->address]);

        return response()->json(['success' => 'success'], 201);

    }
}
