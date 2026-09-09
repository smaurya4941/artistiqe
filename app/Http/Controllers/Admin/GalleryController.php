<?php

namespace App\Http\Controllers\Admin;

use App\Models\GalleryRegister;

class GalleryController extends ArtCommunityController
{
    protected string $profileModel = GalleryRegister::class;
    protected string $userType = 'gallery';
    protected string $slug = 'galleries';
    protected string $label = 'Gallery';
    protected array $searchColumns = ['owner_name', 'owner_surname', 'email', 'phone', 'gallery_name'];
}
