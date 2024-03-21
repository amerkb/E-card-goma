<?php

namespace App\Interfaces\Dashboard;

use App\Models\User;

interface UserInterface
{
    public function index();

    public function show(User $user);

    public function show_by_uuid(User $user);

    public function store($request);

    public function store_user_by_number($request);

    public function update($request, User $user);

    public function delete(User $user);
}
