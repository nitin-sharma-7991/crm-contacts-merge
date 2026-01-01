<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Resources\Pages\Page;

class CustomPageName extends Page
{
    protected static string $resource = ContactResource::class;

    protected static string $view = 'filament.resources.contact-resource.pages.custom-page-name';
}
