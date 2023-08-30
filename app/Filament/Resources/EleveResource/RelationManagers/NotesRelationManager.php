<?php

namespace App\Filament\Resources\EleveResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('note')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('matiere_id')
                    ->relationship('matiere', 'nom_matiere')
                    ->required()
                    ->modifyQueryUsing(fn (Builder $query) => $query->has('eleve.classe.matieres'))
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('note')
            ->modifyQueryUsing(fn (Builder $query) => $query->has('eleve.classe.matieres'))
            ->columns([
                Tables\Columns\TextColumn::make('note'),
                Tables\Columns\TextColumn::make('matiere.nom_matiere'),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
