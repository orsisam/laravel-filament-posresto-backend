<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->label('Product image')
                    ->image()
                    ->avatar()
                    ->imageEditor(2)
                    ->circleCropper(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Category name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->autosize(),
                    ])
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->inputMode('decimal')
                    ->currencyMask()
                    ->required(),
                TextInput::make('stock')
                    ->numeric()
                    ->inputMode('number'),
                Textarea::make('description')
                    ->autosize(),
                Toggle::make('status')
                    ->label('Available')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default('checked')
                    ->accepted(),
                Toggle::make('is_favorite')
                    ->label('Favorite')
                    ->onColor('success')
                    ->offColor('danger')
                    ->declined(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->size(64)
                    ->circular(),
                TextColumn::make('name')
                    ->description(fn (Product $product): string => ($product->description) ? $product->description : 'no description')
                    ->searchable(),
                TextColumn::make('category.name'),
                TextColumn::make('price')
                    ->currency('IDR')
                    ->sortable(),
                TextColumn::make('stock')
                    ->sortable(),
                ToggleColumn::make('status')
                    ->label('Availablity'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
