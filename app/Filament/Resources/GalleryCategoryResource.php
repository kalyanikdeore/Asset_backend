<?php
// app/Filament/Resources/GalleryCategoryResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryCategoryResource\Pages;
use App\Models\GalleryCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class GalleryCategoryResource extends Resource
{
    protected static ?string $model = GalleryCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gallery';

    protected static ?string $modelLabel = 'Gallery Category';

    protected static ?string $pluralModelLabel = 'Gallery Categories';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Information')
                    ->description('Basic information about the gallery category')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') {
                                    // Only update slug if it's empty or similar to name
                                    $currentSlug = request()->old('slug') ?? '';
                                    if (empty($currentSlug) || Str::slug($currentSlug) === Str::slug($state)) {
                                        $set('slug', Str::slug($state));
                                    }
                                } else {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->placeholder('Enter category name')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('category-slug')
                            ->helperText('URL-friendly version of the name')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Optional description for this category')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active')
                            ->helperText('Whether this category is visible on the website'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Lower numbers appear first'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->slug),

                Tables\Columns\TextColumn::make('images_count')
                    ->label('Images')
                    ->counts('images')
                    ->sortable()
                    ->color('gray')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->trueColor('success')
                    ->falseIcon('heroicon-o-x-circle')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->label('Status'),

                Tables\Filters\Filter::make('has_images')
                    ->label('Has Images')
                    ->query(fn (Builder $query) => $query->has('images')),

                Tables\Filters\Filter::make('no_images')
                    ->label('No Images')
                    ->query(fn (Builder $query) => $query->doesntHave('images')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('gray'),

                    Tables\Actions\EditAction::make()
                        ->color('primary'),

                    Tables\Actions\Action::make('images')
                        ->label('View Images')
                        ->icon('heroicon-o-photo')
                        ->color('success')
                        ->url(fn ($record) => GalleryImageResource::getUrl('index', [
                            'tableFilters' => [
                                'gallery_category_id' => [
                                    'value' => $record->id,
                                ],
                            ],
                        ])),

                    Tables\Actions\DeleteAction::make()
                        ->color('danger')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Category deleted')
                                ->body('The gallery category has been deleted successfully.')
                        )
                        ->before(function ($record, Tables\Actions\DeleteAction $action) {
                            // Check if category has images
                            if ($record->images()->count() > 0) {
                                Notification::make()
                                    ->danger()
                                    ->title('Cannot Delete Category')
                                    ->body('This category contains images. Please delete or move the images first.')
                                    ->send();
                                
                                $action->cancel();
                            }
                        }),
                ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm')
                ->color('gray')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each->update(['is_active' => true]);
                            
                            Notification::make()
                                ->success()
                                ->title('Categories Activated')
                                ->body($records->count() . ' categories have been activated.')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each->update(['is_active' => false]);
                            
                            Notification::make()
                                ->success()
                                ->title('Categories Deactivated')
                                ->body($records->count() . ' categories have been deactivated.')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->before(function (Collection $records, Tables\Actions\DeleteBulkAction $action) {
                            // Check if any category has images
                            $categoriesWithImages = $records->filter(function ($record) {
                                return $record->images()->count() > 0;
                            });

                            if ($categoriesWithImages->count() > 0) {
                                Notification::make()
                                    ->danger()
                                    ->title('Cannot Delete Categories')
                                    ->body($categoriesWithImages->count() . ' categories contain images and cannot be deleted.')
                                    ->send();
                                
                                $action->cancel();
                            }
                        })
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Categories deleted')
                                ->body('Selected categories have been deleted successfully.')
                        ),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->label('New Category'),
            ])
            ->emptyStateDescription('No gallery categories found. Create your first one!')
            ->emptyStateIcon('heroicon-o-rectangle-stack')
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'asc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSizesInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryCategories::route('/'),
            'create' => Pages\CreateGalleryCategory::route('/create'),
            'edit' => Pages\EditGalleryCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('images');
    }
}