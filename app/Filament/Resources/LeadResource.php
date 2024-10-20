<?php

namespace App\Filament\Resources;

use App\Enums\LeadType;
use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Filament\Resources\LeadResource\RelationManagers\VisitsRelationManager;
use App\Models\Lead;
use App\Traits\LeadFields;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadResource extends Resource
{
    use LeadFields;

    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFields(admin: true));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('territory.name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('shop_name')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('post_code')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('address')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('union.name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('upazila.name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('district.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('division.name')
                    ->searchable()
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
            VisitsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
