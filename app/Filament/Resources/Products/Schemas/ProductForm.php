<?php

namespace App\Filament\Resources\Products\Schemas;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->placeholder('Nama Produk')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Harga Produk')
                    ->placeholder('Harga Produk')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('stock')
                    ->label('Stok Produk')
                    ->placeholder('Stok Produk')
                    ->maxLength(255)
                    ->numeric(),
            ]);
    }
}
