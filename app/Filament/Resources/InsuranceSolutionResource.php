<?php

namespace App\Filament\Resources;

use App\Models\InsuranceSolution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InsuranceSolutionResource extends Resource
{
    protected static ?string $model = InsuranceSolution::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Insurance Solution Details')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('insurance-solutions')
                            ->disk('public_uploads')
                            ->imageEditor()
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                            
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                ->disk('public_uploads'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => \App\Filament\Resources\InsuranceSolutionResource\Pages\ListInsuranceSolutions::route('/'),
            'create' => \App\Filament\Resources\InsuranceSolutionResource\Pages\CreateInsuranceSolution::route('/create'),
            'edit' => \App\Filament\Resources\InsuranceSolutionResource\Pages\EditInsuranceSolution::route('/{record}/edit'),
        ];
    }
}