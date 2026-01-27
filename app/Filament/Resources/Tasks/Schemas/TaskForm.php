<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Actions\Action;


class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->live()
                    ->hintAction(
                        Action::make('aiAnalyze')
                            ->label('Analisis AI')
                            ->disabled(fn (callable $get) => blank($get('description')))
                            ->icon('heroicon-o-cpu-chip')
                            ->action(function (callable $set, callable $get) {
                                $response = app(\App\Services\AiService::class)
                                    ->analyzeTask($get('description'));

                                $set('category', $response['category']);
                                $set('priority', $response['priority']);
                            })
                    ),
                TextInput::make('category')
                    ->required()
                    ->default(null),
                TextInput::make('priority')
                    ->required(),
            ]);
    }
}
