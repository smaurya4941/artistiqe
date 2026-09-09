<?php

namespace App\Http\Controllers\Admin;

use App\Models\CollectorRegister;

class CollectorController extends ArtCommunityController
{
    protected string $profileModel = CollectorRegister::class;
    protected string $userType = 'collector';
    protected string $slug = 'collectors';
    protected string $label = 'Collector';
    protected array $searchColumns = ['first_name', 'last_name', 'email', 'phone', 'city'];
}
