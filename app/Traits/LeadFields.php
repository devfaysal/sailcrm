<?php
namespace App\Traits;

use App\Enums\LeadType;
use App\Models\Crop;
use App\Models\Problem;
use App\Models\Product;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;

trait LeadFields
{
    public static function getFields($admin = false)
    {
        $upazilaList = $admin ? Upazila::pluck('bn_name', 'id') : Upazila::whereIn('id', auth()->user()->territory->areas)->pluck('bn_name', 'id');
        $fields = [
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
                ->options($upazilaList)
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
                        return Union::where('upazila_id', $upazilaId)->pluck('bn_name', 'id');
                    }
                    return [];
                })
                ->searchable()
                ->reactive()
                ->preload()
                ->disabled(function (callable $get) {
                    return empty($get('upazila_id'));
                }),
            TextInput::make('address'),
            TextInput::make('post_code'),
            SpatieMediaLibraryFileUpload::make('picture')
                ->collection('picture'),
            Section::make('Farmer Visits')
            ->visible(fn($record) => !$record)
                ->schema(self::getRepeaterVisitFields())
        ];
        if($admin){
            array_unshift(
                $fields ,
                Select::make('territory_id')
                    ->searchable()
                    ->preload()
                    ->relationship('territory', 'name')
            );
        }
        return $fields;
    }

    public static function getRepeaterVisitFields()
    {
        return [
            Repeater::make('solutions')
                ->schema(self::getVisitFields())
                ->columns(2),
        ];
    }

    public static function getVisitFields()
    {
        return [
            Select::make('crop_id')
                ->label('Crop')
                ->placeholder('Select Crop')
                ->options(Crop::pluck('name', 'id'))
                ->searchable(),
            Select::make('problem')
                ->placeholder('Select a problem')
                ->options(Problem::pluck('name', 'name'))
                ->searchable()
                ->required(),
            Select::make('solution')
                ->placeholder('Select one or more soltions')
                ->multiple()
                ->options(Product::pluck('name', 'name'))
                ->required(),
            DatePicker::make('visited_at')
                ->placeholder('Select Date')
                ->native(false)
                ->required(),
        ];
    }
}
