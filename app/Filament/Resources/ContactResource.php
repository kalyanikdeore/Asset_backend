<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationGroup = 'Contact Us';
    protected static ?string $navigationIcon = 'heroicon-o-phone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('tagline')
                    ->required()
                    ->maxLength(500),
                
                Forms\Components\Repeater::make('phone_numbers')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->tel()
                            ->required(),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Repeater::make('emails')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('whatsapp_number')
                    ->tel(),
                
                Forms\Components\Repeater::make('working_hours')
                    ->schema([
                        Forms\Components\TextInput::make('hours')
                            ->required(),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('appointment_info')
                    ->maxLength(500),
                
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\Fieldset::make('Social Links')
                    ->schema([
                        Forms\Components\TextInput::make('social_links.facebook')
                            ->url(),
                        Forms\Components\TextInput::make('social_links.twitter')
                            ->url(),
                        Forms\Components\TextInput::make('social_links.linkedin')
                            ->url(),
                        Forms\Components\TextInput::make('social_links.instagram')
                            ->url(),
                    ]),
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}