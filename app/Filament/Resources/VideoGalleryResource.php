<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoGalleryResource\Pages;
use App\Filament\Resources\VideoGalleryResource\RelationManagers;
use App\Models\VideoGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class VideoGalleryResource extends Resource
{
    protected static ?string $model = VideoGallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    
    protected static ?string $navigationLabel = 'Video Galeri';
    
    protected static ?string $modelLabel = 'Video';
    
    protected static ?string $pluralModelLabel = 'Videolar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Video Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->rows(4)
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('video_type')
                            ->label('Video Türü')
                            ->options([
                                'url' => 'Harici Video (YouTube, Vimeo vb.)',
                                'file' => 'Video Dosyası Yükle'
                            ])
                            ->default('url')
                            ->required()
                            ->live()
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('YouTube, Vimeo veya diğer video platformlarının URL\'sini giriniz.')
                            ->visible(fn (Forms\Get $get): bool => $get('video_type') === 'url')
                            ->required(fn (Forms\Get $get): bool => $get('video_type') === 'url')
                            ->dehydrated(fn (Forms\Get $get): bool => $get('video_type') === 'url'),
                        
                        Forms\Components\FileUpload::make('video_file')
                            ->label('Video Dosyası')
                            ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/webm'])
                            ->disk('public')
                            ->directory('videos')
                            ->maxSize(500 * 1024) // 500MB
                            ->helperText('Maksimum dosya boyutu: 500MB. Desteklenen formatlar: MP4, AVI, MOV, WMV, WebM')
                            ->visible(fn (Forms\Get $get): bool => $get('video_type') === 'file')
                            ->required(fn (Forms\Get $get): bool => $get('video_type') === 'file')
                            ->dehydrated(fn (Forms\Get $get): bool => $get('video_type') === 'file'),
                        
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail Resmi')
                            ->image()
                            ->disk('public')
                            ->directory('video-thumbnails')
                            ->helperText('Video için özel thumbnail yükleyebilirsiniz.'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Ek Bilgiler')
                    ->schema([
                        Forms\Components\TextInput::make('duration')
                            ->label('Video Süresi')
                            ->placeholder('3:45')
                            ->helperText('Örnek: 3:45, 12:30'),
                        
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sıra Numarası')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('views')
                            ->label('Görüntülenme Sayısı')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('video_type')
                    ->label('Video Türü')
                    ->formatStateUsing(function (string $state, VideoGallery $record) {
                        return match ($state) {
                            'file' => '📁 Yüklenen Dosya',
                            'url' => $record->youtube_id ? '📺 YouTube' : '🔗 Harici URL',
                            default => '❓ Bilinmiyor'
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'file' => 'success',
                        'url' => 'info',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->formatStateUsing(function (VideoGallery $record) {
                        if ($record->thumbnail) {
                            return '✅ Özel';
                        } elseif ($record->youtube_id) {
                            return '📺 YouTube';
                        }
                        return '❌ Yok';
                    })
                    ->badge()
                    ->color(fn (VideoGallery $record): string => match (true) {
                        $record->thumbnail => 'success',
                        $record->youtube_id => 'info',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('duration')
                    ->label('Süre')
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('views')
                    ->label('Görüntülenme')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => number_format($state)),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Durum')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Durum')
                    ->placeholder('Tümü')
                    ->trueLabel('Aktif')
                    ->falseLabel('Pasif'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Görüntüle')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (VideoGallery $record): string => route('frontend.video-gallery.show', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()
                    ->label('Düzenle'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Seçilenleri Sil'),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListVideoGalleries::route('/'),
            'create' => Pages\CreateVideoGallery::route('/create'),
            'edit' => Pages\EditVideoGallery::route('/{record}/edit'),
        ];
    }
}
