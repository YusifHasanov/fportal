<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSettingsResource\Pages;
use App\Models\HeroSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class HeroSettingsResource extends Resource
{
    protected static ?string $model = HeroSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';
    
    protected static ?string $navigationLabel = 'Hero Video';
    
    protected static ?string $modelLabel = 'Hero Ayarı';
    
    protected static ?string $pluralModelLabel = 'Hero Ayarları';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Video Ayarları')
                    ->description('Ana sayfadaki hero video bölümünü yönetin')
                    ->schema([
                        Forms\Components\Toggle::make('enabled')
                            ->label('Hero Video Aktif')
                            ->helperText('Ana sayfada hero video bölümünü göster/gizle')
                            ->default(true),
                        
                        Forms\Components\FileUpload::make('video_file')
                            ->label('Hero Video Dosyası')
                            ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/webm'])
                            ->disk('public')
                            ->directory('hero-videos')
                            ->maxSize(200 * 1024) // 200MB
                            ->nullable()
                            ->helperText('Maksimum dosya boyutu: 200MB. Önerilen format: MP4')
                            ->deleteUploadedFileUsing(function ($file) {
                                if (Storage::disk('public')->exists($file)) {
                                    Storage::disk('public')->delete($file);
                                }
                            }),
                        
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->default('Futbolun En Heyecanlı Anları'),
                        
                        Forms\Components\Textarea::make('subtitle')
                            ->label('Alt Başlık')
                            ->required()
                            ->rows(3)
                            ->default('En son haberler, analizler ve özel içerikler için bizi takip edin'),
                        
                        Forms\Components\TextInput::make('button_text')
                            ->label('Buton Metni')
                            ->required()
                            ->maxLength(50)
                            ->default('Keşfet'),
                        
                        Forms\Components\TextInput::make('button_url')
                            ->label('Buton URL')
                            ->required()
                            ->maxLength(255)
                            ->default('/haberler')
                            ->helperText('Butona tıklandığında gidilecek sayfa'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('enabled')
                    ->label('Durum')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('video_file')
                    ->label('Video')
                    ->formatStateUsing(fn ($state) => $state ? '📹 Video Yüklü' : '❌ Video Yok')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Son Güncelleme')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
            ])
            ->bulkActions([
                // Bulk actions kaldırıldı çünkü tek kayıt olacak
            ])
            ->paginated(false); // Pagination kaldırıldı
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSettings::route('/'),
            'edit' => Pages\EditHeroSettings::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        // Sadece bir kayıt olmasını sağla
        return HeroSettings::count() === 0;
    }
}
