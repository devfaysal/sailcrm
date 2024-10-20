<?php

namespace App\Filament\Resources\LeadResource\RelationManagers;

use App\Traits\LeadFields;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitsRelationManager extends RelationManager
{
    use LeadFields;
    
    protected static string $relationship = 'visits';

    public function form(Form $form): Form
    {
        return $form
            ->schema(self::getVisitFields());
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
