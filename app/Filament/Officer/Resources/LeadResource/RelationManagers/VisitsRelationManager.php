<?php

namespace App\Filament\Officer\Resources\LeadResource\RelationManagers;

use App\Models\Crop;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('crop_id')
                    ->label('Crop')
                    ->placeholder('Select Crop')
                    ->options(Crop::pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('problem')
                    ->required(),
                TextInput::make('solution')
                    ->required(),
                DatePicker::make('visited_at')
                    ->placeholder('Select Date')
                    ->native(false)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('crop')
            ->columns([
                TextColumn::make('crop.name'),
                TextColumn::make('problem'),
                TextColumn::make('solution'),
                TextColumn::make('visited_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
