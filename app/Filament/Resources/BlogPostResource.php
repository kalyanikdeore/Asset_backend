<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Filament\Resources\BlogPostResource\RelationManagers;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $navigationGroup = 'Blog Page';
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(function ($state, $set) {
        $set('slug', Str::slug($state));
    }),
Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('excerpt')->required(),
                Forms\Components\RichEditor::make('content')->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->options([
                        // Core Service Categories
                        "Wealth Management",
                        "Tax Planning",
                        "Retirement Planning",
                        "Investment",
                        "Insurance",
                        
                        // // Technical Categories
                        // 'Process Design' => 'Process Design',
                        // 'Hydraulic Engineering' => 'Hydraulic Engineering',
                        // 'Wastewater Treatment' => 'Wastewater Treatment',
                        // 'Water Treatment' => 'Water Treatment',
                        // 'Pumping Stations' => 'Pumping Stations',
                        // 'Zero Liquid Discharge' => 'Zero Liquid Discharge',
                        // 'Rainwater Harvesting' => 'Rainwater Harvesting',
                        
                        // // // Project Types
                        // // 'Municipal Projects' => 'Municipal Projects',
                        // // 'Industrial Projects' => 'Industrial Projects',
                        // // 'Healthcare Facilities' => 'Healthcare Facilities',
                        // // 'Educational Institutions' => 'Educational Institutions',
                        // // 'Commercial Complexes' => 'Commercial Complexes',
                        // // 'Residential Townships' => 'Residential Townships',
                        
                        // // // Regulatory & Compliance
                        // // 'Pollution Control' => 'Pollution Control',
                        // // 'Environmental Impact Assessment' => 'Environmental Impact Assessment',
                        // // 'SPCB Consents' => 'SPCB Consents',
                        // // 'Cess Returns' => 'Cess Returns',
                        
                        // // // Sustainability
                        // // 'Sustainable Technologies' => 'Sustainable Technologies',
                        // // 'Circular Economy' => 'Circular Economy',
                        // // 'Resource Optimization' => 'Resource Optimization',
                        // // 'Energy Efficiency' => 'Energy Efficiency',
                        
                        // // // Case Studies
                        // // 'Project Case Studies' => 'Project Case Studies',
                        // // 'Technical Papers' => 'Technical Papers',
                        // // 'Research & Development' => 'Research & Development',
                        
                        // // // Industry Updates
                        // // 'Regulatory Updates' => 'Regulatory Updates',
                        // // 'Industry Trends' => 'Industry Trends',
                        // // 'New Technologies' => 'New Technologies',
                    ])
                    ->required()
                    ->searchable()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_url')
                    ->label('Featured Image')
                    ->image()
                    ->directory('blog')
                    ->disk('public_uploads')
                    ->preserveFilenames()
                    ->required()
                    ->disk('public_uploads')
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('published_date')->required(),
                Forms\Components\Toggle::make('is_published')
    ->default(true)
    ->required(),
                Forms\Components\TextInput::make('author_name')->required(),
                Forms\Components\FileUpload::make('author_avatar')
                    ->label('Author Avatar')
                    ->image()
                    ->directory('authors')
                    ->preserveFilenames()
                    ->required()
                    ->disk('public_uploads')
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('author_role')->required(),
                Forms\Components\Repeater::make('related_products')
                    ->schema([
                        Forms\Components\TextInput::make('id'),
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\TextInput::make('link'),
                    ])
            ]);
    }
    
    
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image_url')
                ->label('Image')
                ->disk('public_uploads')
                ->url(fn ($record) => asset('uploads/' . $record->image_url)),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('category'),
            Tables\Columns\TextColumn::make('published_date')->date(),
            Tables\Columns\IconColumn::make('is_published')
    ->boolean()
    ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category')
                ->options([
                    // Core Service Categories
                    "Wealth Management",
                    "Tax Planning",
                    "Retirement Planning",
                     "Investment",
                     "Insurance",
                    
                //     // Technical Categories
                //     'Process Design' => 'Process Design',
                //     'Hydraulic Engineering' => 'Hydraulic Engineering',
                //     'Wastewater Treatment' => 'Wastewater Treatment',
                //     'Water Treatment' => 'Water Treatment',
                //     'Pumping Stations' => 'Pumping Stations',
                //     'Zero Liquid Discharge' => 'Zero Liquid Discharge',
                //     'Rainwater Harvesting' => 'Rainwater Harvesting',
                    
                //     // Project Types
                //     'Municipal Projects' => 'Municipal Projects',
                //     'Industrial Projects' => 'Industrial Projects',
                //     'Healthcare Facilities' => 'Healthcare Facilities',
                //     'Educational Institutions' => 'Educational Institutions',
                //     'Commercial Complexes' => 'Commercial Complexes',
                //     'Residential Townships' => 'Residential Townships',
                    
                //     // Regulatory & Compliance
                //     'Pollution Control' => 'Pollution Control',
                //     'Environmental Impact Assessment' => 'Environmental Impact Assessment',
                //     'SPCB Consents' => 'SPCB Consents',
                //     'Cess Returns' => 'Cess Returns',
                    
                //     // Sustainability
                //     'Sustainable Technologies' => 'Sustainable Technologies',
                //     'Circular Economy' => 'Circular Economy',
                //     'Resource Optimization' => 'Resource Optimization',
                //     'Energy Efficiency' => 'Energy Efficiency',
                    
                //     // Case Studies
                //     'Project Case Studies' => 'Project Case Studies',
                //     'Technical Papers' => 'Technical Papers',
                //     'Research & Development' => 'Research & Development',
                    
                //     // Industry Updates
                //     'Regulatory Updates' => 'Regulatory Updates',
                //     'Industry Trends' => 'Industry Trends',
                //     'New Technologies' => 'New Technologies',
                 ])
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}