<?php

namespace App\Filament\Resources\VideoGalleryResource\Pages;

use App\Filament\Resources\VideoGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoGallery extends EditRecord
{
    protected static string $resource = VideoGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view')
                ->label('Frontend\'de Görüntüle')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('frontend.video-gallery.show', $this->record))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make()
                ->label('Sil'),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Video başarıyla güncellendi!';
    }
}
