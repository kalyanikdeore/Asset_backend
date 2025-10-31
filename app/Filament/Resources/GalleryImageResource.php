<?php
// app/Filament/Resources/GalleryImageResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use App\Models\GalleryCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Gallery';

    protected static ?string $modelLabel = 'Gallery Image';

    protected static ?string $pluralModelLabel = 'Gallery Images';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Image Information')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->required()
                            ->label('Image')
                            ->image()
                            ->directory('gallery')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->maxSize(5120) // 5MB
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->imagePreviewHeight('200')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->helperText('Maximum file size: 5MB. Recommended aspect ratio: 16:9')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Image Title')
                            ->maxLength(255)
                            ->placeholder('Enter a descriptive title for the image')
                            ->helperText('Optional title for the image')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Category & Settings')
                    ->schema([
                        Forms\Components\Select::make('gallery_category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->label('Category')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                                        $set('slug', \Illuminate\Support\Str::slug($state))
                                    ),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $category = GalleryCategory::create($data);
                                return $category->getKey();
                            })
                            ->editOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('is_active'),
                            ])
                            ->helperText('Select a category or create a new one'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active')
                            ->helperText('Whether this image is visible on the website'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public_uploads')
                    ->size(80)
                    ->square()
                    ->grow(false),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->title;
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->color('primary')
                    ->url(fn ($record) => 
                        GalleryCategoryResource::getUrl('edit', ['record' => $record->gallery_category_id])
                    ),

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
                    ->label('Uploaded')
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
                Tables\Filters\SelectFilter::make('gallery_category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('gray'),

                    Tables\Actions\EditAction::make()
                        ->color('primary'),

                    Tables\Actions\Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($record) {
                            // This would open a modal or redirect to preview
                            Notification::make()
                                ->info()
                                ->title('Image Preview')
                                ->body('Preview functionality would open here.')
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->color('danger')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Image deleted')
                                ->body('The gallery image has been deleted successfully.')
                        )
                        ->before(function ($record, Tables\Actions\DeleteAction $action) {
                            // Delete the actual image file
                            if ($record->image_path && Storage::disk('public_uploads')->exists($record->image_path)) {
                                Storage::disk('public_uploads')->delete($record->image_path);
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
                                ->title('Images Activated')
                                ->body($records->count() . ' images have been activated.')
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
                                ->title('Images Deactivated')
                                ->body($records->count() . ' images have been deactivated.')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->before(function (Collection $records, Tables\Actions\DeleteBulkAction $action) {
                            // Delete the actual image files
                            $records->each(function ($record) {
                                if ($record->image_path && Storage::disk('public_uploads')->exists($record->image_path)) {
                                    Storage::disk('public_uploads')->delete($record->image_path);
                                }
                            });
                        })
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Images deleted')
                                ->body('Selected images have been deleted successfully.')
                        ),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->label('Upload Image'),
            ])
            ->emptyStateDescription('No gallery images found. Upload your first image!')
            ->emptyStateIcon('heroicon-o-photo')
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'asc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSizesInSession()
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('category');
    }
}