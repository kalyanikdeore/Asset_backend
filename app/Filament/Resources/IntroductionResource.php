<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntroductionResource\Pages;
use App\Filament\Resources\IntroductionResource\RelationManagers;
use App\Models\Introduction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IntroductionResource extends Resource
{
    protected static ?string $model = Introduction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Home';
    protected static ?string $navigationLabel = 'Introduction Section';
    

    protected static ?string $modelLabel = 'Introduction Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Introduction Section')
                ->schema([
                    Forms\Components\TextInput::make('intro_header')
                        ->label('Header')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\FileUpload::make('intro_image')
                        ->label('Image')
                        ->image()
                        ->disk('public_uploads')
                        ->directory('introduction-section')
                        ->required(),
                        
                    Forms\Components\Repeater::make('intro_description')
                        ->label('Description Bullet Points')
                        ->schema([
                            Forms\Components\Textarea::make('point')
                                ->label('Point')
                                ->required()
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['point'] ?? null)
                        ->collapsible()
                        ->grid(1),   
                        
                    Forms\Components\Repeater::make('intro_investment_insurance')
                        ->label('Investment/Insurance Bullet Points')
                        ->schema([
                            Forms\Components\Textarea::make('point')
                                ->label('Point')
                                ->required()
                        ])
                        ->itemLabel(fn (array $state): ?string => $state['point'] ?? null)
                        ->collapsible()
                        ->grid(1),
                ])
        ]);
                

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('intro_header')
                ->label('Header'),
            Tables\Columns\ImageColumn::make('intro_image')
                ->disk('public_uploads')
                ->label('Image'),
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
            'index' => Pages\ListIntroductions::route('/'),
            'create' => Pages\CreateIntroduction::route('/create'),
            'edit' => Pages\EditIntroduction::route('/{record}/edit'),
        ];
    }
}
