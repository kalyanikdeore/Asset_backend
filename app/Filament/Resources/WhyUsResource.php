<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyUsResource\Pages;
use App\Filament\Resources\WhyUsResource\RelationManagers;
use App\Models\WhyUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WhyUsResource extends Resource
{
    protected static ?string $model = WhyUs::class;
    protected static ?string $navigationGroup = 'About Us';
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
              
                Forms\Components\TextInput::make('highlighted_name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Repeater::make('features')
                    ->schema([
                        Forms\Components\TextInput::make('feature')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('description_1')
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('description_2')
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('cta_text')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('investment_title')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Repeater::make('investment_features')
                    ->schema([
                        Forms\Components\TextInput::make('feature')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('investment_cta_text')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->directory('why-us-images')
                    ->disk('public_uploads')
                    ->required(),
                
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_path'),
                Tables\Columns\ToggleColumn::make('is_active'),
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
            'index' => Pages\ListWhyUs::route('/'),
            'create' => Pages\CreateWhyUs::route('/create'),
            'edit' => Pages\EditWhyUs::route('/{record}/edit'),
        ];
    }
}