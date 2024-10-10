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
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('territory_id', auth()->user()->territory->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options(LeadType::class)
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('shop_name'),
                TextInput::make('phone_number')
                    ->required()
                    ->length(11)
                    ->unique('leads', 'phone_number', ignorable: fn($record) => $record),
                Select::make('upazila_id')
                    ->required()
                    ->options(Upazila::where('district_id', auth()->user()->territory->district_id)->pluck('name','id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('union_id', null);
                    }),
                Select::make('union_id')
                    ->placeholder('Select Union')
                    ->options(function (callable $get) {
                        $upazilaId = $get('upazila_id');
                        if ($upazilaId) {
                            return Union::where('upazila_id', $upazilaId)->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->searchable()
                    ->reactive()
                    ->preload()
                    ->disabled(function (callable $get) {
                        return empty($get('upazila_id'));
                    }),
                TextInput::make('address')
                    ->required(),
                TextInput::make('post_code')
                    ->required(),
                Section::make('Solutions')
                    ->visible(fn($record) => !$record)
                    ->columns(2)
                    ->schema([
                        Select::make('crop_id')
                            ->label('Crop')
                            ->placeholder('Select Crop')
                            ->options(Crop::pluck('name', 'id'))
                            ->searchable(),
                        Select::make('problem')
                            ->placeholder('Select a problem')
                            ->options(Problem::pluck('name'))
                            ->searchable()
                            ->required(),
                        Select::make('solution')
                            ->placeholder('Select one or more soltions')
                            ->multiple()
                            ->options(Product::pluck('name'))
                            ->required(),
                        DatePicker::make('visited_at')
                            ->placeholder('Select Date')
                            ->native(false)
                            ->required(),
                    ])
            ]);
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
