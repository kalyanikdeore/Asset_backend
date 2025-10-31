<?php

namespace App\Filament\Resources;

use App\Models\ContactForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ContactFormResource\Pages;

class ContactFormResource extends Resource
{
    protected static ?string $model = ContactForm::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationGroup = 'Contact Us';
    protected static ?string $navigationLabel = 'Form Submissions';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        // Empty since we don't want edit/create forms
        return $form
            ->schema([
                // No fields here
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('full_name')
                ->searchable()
                ->sortable()
                ->label('Name'),
                
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('service')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('M j, Y g:i A')
                ->sortable()
                ->label('Submitted On'),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            Tables\Filters\SelectFilter::make('service')
                ->options([
                    'Mutual Fund ' => 'Mutual Fund',
                    'Life Insurance' => 'Life Insurance',
                    'Portfolio Management System' => 'Portfolio Management System',
                    'Bonds' => 'Bonds',
                    'Fixed Deposits' => 'Fixed Deposits',
                    'LiquiLoans' => 'LiquiLoans',
                    'Other Inquiry' => 'Other Inquiry',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make()
                ->form([
                    Forms\Components\TextInput::make('full_name')
                        ->disabled(),
                    Forms\Components\TextInput::make('email')
                        ->disabled(),
                    Forms\Components\TextInput::make('phone_number')
                        ->disabled(),
                    Forms\Components\Select::make('service')
                        ->disabled()
                        ->options([
                            'Mutual Fund ' => 'Mutual Fund',
                            'Life Insurance' => 'Life Insurance',
                            'Portfolio Management System' => 'Portfolio Management System',
                            'Bonds' => 'Bonds',
                            'Fixed Deposits' => 'Fixed Deposits',
                            'LiquiLoans' => 'LiquiLoans',
                            'Other Inquiry' => 'Other Inquiry',
                        ]),
                    Forms\Components\Textarea::make('message')
                        ->disabled()
                        ->rows(5)
                        ->columnSpanFull(),
                ]),
            Tables\Actions\DeleteAction::make(), // Delete button added here
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactForms::route('/'),
            // No create/edit routes
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->latest();
    // }
}