<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Filament\Resources\AboutUsResource\RelationManagers;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;
    protected static ?string $navigationGroup = 'Home';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        // Company Description
                        Forms\Components\Section::make('Company Description')
                            ->schema([
                                Forms\Components\RichEditor::make('company_description')
                                    ->required(),
                                Forms\Components\FileUpload::make('company_images')
                                    ->multiple()
                                    ->image()
                                    ->directory('about-us/company')
                                    ->disk('public_uploads')
                                    ->enableOpen()
                                    ->enableDownload()
                                    ->preserveFilenames(),
                            ]),
                        
                        // Why Choose Us
                        Forms\Components\Section::make('Why Choose Us')
                            ->schema([
                                Forms\Components\RichEditor::make('why_choose_us')
                                    ->required(),
                                Forms\Components\Repeater::make('why_choose_us_bullets')
                                    ->schema([
                                        Forms\Components\TextInput::make('bullet')
                                            ->required(),
                                    ])
                                    ->defaultItems(3)
                                    ->createItemButtonLabel('Add Bullet Point')
                                    ->collapsible(),
                            ]),
                        
                        // Additional Text
                        Forms\Components\Section::make('Additional Text')
                            ->schema([
                                Forms\Components\RichEditor::make('additional_text'),
                            ]),
                        
                        // Experience
                        Forms\Components\Section::make('Experience')
                            ->schema([
                                Forms\Components\TextInput::make('experience_years')
                                    ->required(),
                                Forms\Components\FileUpload::make('experience_image')
                                    ->image()
                                    ->directory('about-us/experience')
                                    ->disk('public_uploads')
                                    ->preserveFilenames(),
                            ]),
                        
                        // Key Strengths
                        Forms\Components\Section::make('Key Strengths')
                            ->schema([
                                Forms\Components\Repeater::make('key_strengths')
                                    ->schema([
                                        
                                        Forms\Components\Textarea::make('description')
                                            ->required(),
                                    ])
                                    ->defaultItems(4)
                                    ->createItemButtonLabel('Add Strength')
                                    ->collapsible(),
                            ]),
                        
                        // Areas of Expertise
                        Forms\Components\Section::make('Areas of Expertise')
                            ->schema([
                                Forms\Components\Repeater::make('expertise_areas')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->required(),
                                    ])
                                    ->defaultItems(5)
                                    ->createItemButtonLabel('Add Expertise Area')
                                    ->collapsible(),
                            ]),
                        
                        // Visionary Leaders
                        Forms\Components\Section::make('Visionary Leaders')
                            ->schema([
                                Forms\Components\Repeater::make('leaders')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('about-us/leaders')
                                            ->disk('public_uploads')
                                            ->required(),
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('position')
                                            ->required(),
                                        Forms\Components\Textarea::make('description')
                                            ->required(),
                                    ])
                                    ->defaultItems(2)
                                    ->createItemButtonLabel('Add Leader')
                                    ->collapsible(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}