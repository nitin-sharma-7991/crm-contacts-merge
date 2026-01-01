<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

     // Add Create button as modal
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Contact')
                ->modalHeading('Create Contact')
                ->modalWidth('lg'),
        ];
    }
}
