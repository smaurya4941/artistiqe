<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artist;

class ArtistController extends ArtCommunityController
{
    protected string $profileModel = Artist::class;
    protected string $userType = 'artist';
    protected string $slug = 'artists';
    protected string $label = 'Artist';
    protected array $searchColumns = ['first_name', 'last_name', 'email', 'phone', 'college'];
}
