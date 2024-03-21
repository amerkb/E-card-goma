<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EditUserRequest;
use App\Http\Requests\Dashboard\UserRequest;
use App\Interfaces\Dashboard\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->user->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        return $this->user->store($request);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_user_by_number(Request $request)
    {
        return $this->user->store_user_by_number($request);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->user->show($user);

    }

    /**
     * Display the specified resource.
     */
    public function show_by_uuid(User $user)
    {
        return $this->user->show($user);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserRequest $request, User $user)
    {
        return $this->user->update($request, $user);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $this->user->delete($user);
    }
}
