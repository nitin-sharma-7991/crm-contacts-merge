<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    /* ===================== FORM ===================== */

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->maxLength(255),
            TextInput::make('phone')->maxLength(20),

            Radio::make('gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ])
                ->inline(),

            FileUpload::make('profile_image')->directory('profiles')->image(),
            FileUpload::make('additional_file')->directory('documents'),

            Repeater::make('customValues')
                ->relationship('customValues')
                ->label('Custom Fields')
                ->schema([
                    Select::make('custom_field_id')
                        ->relationship('customField', 'name')
                        ->required(),
                    TextInput::make('value')->required(),
                ])
                ->columns(2),

            Placeholder::make('merge_status')
                ->label('Merge Status')
                ->content(fn ($record) =>
                    $record?->is_merged
                        ? "Merged into Contact ID: {$record->merged_into}"
                        : 'Active Contact'
                )
                ->visible(fn ($record) => filled($record)),
        ]);
    }

    /* ===================== TABLE ===================== */

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\BadgeColumn::make('gender')->colors([
                    'primary' => 'male',
                    'success' => 'female',
                    'warning' => 'other',
                ]),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('gender')->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ]),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('merge')
                    ->label('Merge')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Confirm Merge')
                    ->modalSubheading(
                        'The selected contact will be merged into the master contact. No data will be lost.'
                    )
                    ->form([
                        Select::make('master_id')
                            ->label('Select Master Contact')
                            ->options(fn (Contact $record) =>
                                Contact::where('is_merged', false)
                                    ->where('id', '!=', $record->id)
                                    ->pluck('name', 'id')
                            )
                            ->required(),
                    ])
                    ->action(function (Contact $record, array $data) {

                        $master = Contact::findOrFail($data['master_id']);
                        $secondary = $record;

                        /* ---------- EMAIL MERGE ---------- */
                        $emails = collect(
                            array_filter([
                                ...explode(',', (string) $master->email),
                                ...explode(',', (string) $secondary->email),
                            ])
                        )->map(fn ($e) => trim($e))
                         ->unique()
                         ->implode(', ');

                        /* ---------- PHONE MERGE ---------- */
                        $phones = collect(
                            array_filter([
                                ...explode(',', (string) $master->phone),
                                ...explode(',', (string) $secondary->phone),
                            ])
                        )->map(fn ($p) => trim($p))
                         ->unique()
                         ->implode(', ');

                        $master->update([
                            'email' => $emails,
                            'phone' => $phones,
                        ]);

                        /* ---------- CUSTOM FIELD MERGE ---------- */
                        foreach ($secondary->customValues as $value) {
                            $exists = $master->customValues()
                                ->where('custom_field_id', $value->custom_field_id)
                                ->exists();

                            if (! $exists) {
                                $value->update(['contact_id' => $master->id]);
                            }
                        }

                        /* ---------- MARK SECONDARY ---------- */
                        $secondary->update([
                            'is_merged' => true,
                            'merged_into' => $master->id,
                        ]);
                    }),
            ]);
    }

    /* ===================== QUERY ===================== */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_merged', false)
            ->with(['customValues.customField']);
    }

    /* ===================== PAGES ===================== */

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
