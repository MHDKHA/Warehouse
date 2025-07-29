<?php

namespace App\Filament\Resources\CrownBlock;

use App\ChecklistRepeater;
use App\Models\CrownBlock\Main as CrownBlock;
use App\Models\CrownBlock\Checklist;
use App\Models\CrownBlock\ChecklistDetail;
use App\Models\CrownBlock\ReadingCL;
use App\Models\CrownBlock\ReadingFL;
use App\Models\CrownBlock\ReadingSL;
use App\Models\WorkOrder;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;
use Filament\Forms\Set;

class MainResource extends Resource
{
    protected static ?string $model = CrownBlock::class;

//    protected static ?string $navigationGroup = 'Drilling';
//    protected static ?string $navigationIcon = 'heroicon-o-cube';
//    protected static ?string $label = 'Crown Block';
    protected static ?string $pluralLabel = 'Crown Blocks Log';

    public static function form(Forms\Form $form): Forms\Form
    {
        $items = \App\Models\ChecklistDetail::query()
            ->where('checklist_id', 212)
            ->orderBy('sortorder')
            ->get();

        return $form
            ->schema([
                Section::make('Certificate Information')
                    ->columns(4)
                    ->schema([

                        TextInput::make('work_location')->required(),
                        DatePicker::make('test_date')->required(),
                        DatePicker::make('next_test_date')->required(),

                        Select::make('status')
                            ->options([
                                '1' => 'Accepted',
                                '2' => 'Rejected',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if ($state == '1') {
                                    $set('mpi_results', "CARRIED PUT CROWN BLOCK INSPECTION ON THE AVAILABLE & ACCESSIBLE CRITICAL AREA OF THE ABOVE DESCRIBED ITEM AND FOUND IT'S FREE FROM SURFACE CRACKS AT THE TIME OF INSPECTION. <br>(ACCEPTED)");
                                    $set('dim_results', "DIMENSIONS HAVE BEEN RECORDED, AND FOUND WITHIN ALLOWABLE WEAR TOLERANCE, VISUAL INSPECTION FOUND SATISFACTORY. <br>(ACCEPTED)");
                                } elseif ($state == '2') {
                                    $set('mpi_results', "CARRIED PUT CROWN BLOCK INSPECTION ON THE AVAILABLE & ACCESSIBLE CRITICAL AREA OF THE ABOVE DESCRIBED ITEM AND FOUND IT'S FREE FROM SURFACE CRACKS AT THE TIME OF INSPECTION. <br>(REJECTED)");
                                    $set('dim_results', "DIMENSIONS HAVE BEEN RECORDED, AND FOUND WITHIN ALLOWABLE WEAR TOLERANCE, VISUAL INSPECTION FOUND SATISFACTORY. <br>(REJECTED)");
                                }
                            }),
                        Checkbox::make('standard_type_api')->label('Specification API'),
                        TextInput::make('standard_name_api'),
                        Checkbox::make('standard_type_astm')->label('Specification ASTM'),
                        TextInput::make('standard_name_astm'),

                        Select::make('inspection_method')
                            ->options(['1' => 'Visible', '2' => 'Fluorescent'])
                            ->required(),

                        Select::make('insp_type')
                            ->options(['1' => 'Cat III', '2' => 'Cat IV'])
                            ->required(),

                        Select::make('mpi_type')
                            ->options(['1' => 'Wet', '2' => 'Dry'])
                            ->required(),

                        Select::make('mg_eq_used')
                            ->options(['1' => 'AC', '2' => 'DC', '3' => 'Permanent'])
                            ->required(),

                        TextInput::make('mg_eq_manuf')->required(),
                        TextInput::make('magnet_no')->required(),
                        DatePicker::make('manuf_date')->required(),
                        TextInput::make('model')->required(),
                        Textarea::make('description')->columnSpanFull(),
                        TextInput::make('manufacturer')->required(),

                        TextInput::make('sheaves_od'),
                        TextInput::make('drill_line_dia')->numeric()->required(),
                        TextInput::make('rated_loading')->required(),
                        TextInput::make('equipment_no')->required(),
                        TextInput::make('fl_sheave_sn')->required(),
                        TextInput::make('sand_line_sheave_sn'),
                        TextInput::make('cluster_sheaves_sn')->required(),

                        TextInput::make('contrast_media')->required(),
                        TextInput::make('contrast_media_batch')->required(),
                        TextInput::make('contrast_media_manuf')->required(),

                        TextInput::make('indicator')->required(),
                        TextInput::make('indicator_batch')->required(),
                        TextInput::make('indicator_manuf')->required(),

                        Select::make('cal_test_weight')
                            ->options(['0' => 'N/A', '1' => '10 LBS', '2' => '40 LBS'])
                            ->required(),

                        TextInput::make('pole_spacing')->numeric()->required(),
                        TextInput::make('light_intensity_value')->required(),
                        TextInput::make('light_meter_no')->required(),
                        TextInput::make('surface_condition')->required(),
                        TextInput::make('temprature')->required(),
                        TextInput::make('sheave_gauge_no')->required(),
                        TextInput::make('caliper_no')->columnSpan(3)->required(),

                        Textarea::make('dim_results')->rows(3)->columnSpan(2)->required(),
                        Textarea::make('mpi_results')->rows(3)->columnSpan(2)->required(),
                        ChecklistRepeater::make('checklist', 212),



                        FileUpload::make('crown_photo')->directory('crown_block')->image(),
                        FileUpload::make('cluster_wear_photo')->directory('crown_block')->image(),
                        FileUpload::make('fast_line_wear_photo')->directory('crown_block')->image(),
                        FileUpload::make('cluster_photo')->directory('crown_block')->image(),
                        FileUpload::make('fast_line_photo')->directory('crown_block')->image(),

                    ]),




            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('wo_id'),
                Tables\Columns\TextColumn::make('test_date'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                // Filters here
            ])
            ->actions([
                Tables\Actions\Action::make('Readings')
                    ->label('Readings')
                    ->color(fn ($record) => \App\Models\CrownBlock\ReadingCL::where('certification_id', $record->certification_id)->exists() ? 'success' : 'gray')
                    ->icon('heroicon-o-clipboard-document')
                    ->url(fn ($record) => MainResource::getUrl('readings', ['record' => $record]))
                    ->openUrlInNewTab(),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => MainResource\Pages\ListMains::route('/'),
            'create' => MainResource\Pages\CreateMain::route('/create/{wo_id?}'),
            'edit' => MainResource\Pages\EditMain::route('/{record}/edit'),
            'readings' => MainResource\Pages\ManageReadings::route('/{record}/readings'),
        ];
    }



}
