<?php

namespace App\Filament\Officer\Resources;

use App\Enums\LeadType;
use App\Filament\Officer\Resources\LeadResource\Pages;
use App\Filament\Officer\Resources\LeadResource\RelationManagers;
use App\Filament\Officer\Resources\LeadResource\RelationManagers\VisitsRelationManager;
use App\Models\Crop;
use App\Models\Lead;
use App\Models\Problem;
use App\Models\Product;
use App\Traits\LeadFields;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LeadResource extends Resource
{
    use LeadFields;
    
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('territory_id', auth()->user()->territory->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFields());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                ViewAction::make(),
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
            'view' => Pages\ViewLead::route('/{record}'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
