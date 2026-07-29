<?php

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SecureImageUpload
{
    public const ACCEPTED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    public const ALLOWED_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'webp',
    ];

    public const MAX_SIZE_KILOBYTES = 2048;

    public static function make(string $name, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->image()
            ->disk('public')
            ->directory($directory)
            ->visibility('public')
            ->acceptedFileTypes(self::ACCEPTED_MIME_TYPES)
            ->rules(['extensions:'.implode(',', self::ALLOWED_EXTENSIONS)])
            ->maxSize(self::MAX_SIZE_KILOBYTES)
            ->getUploadedFileNameForStorageUsing(
                fn (TemporaryUploadedFile $file): string => Str::uuid().'.'.self::safeExtension($file),
            );
    }

    private static function safeExtension(TemporaryUploadedFile $file): string
    {
        $extension = strtolower((string) $file->extension());

        return match ($extension) {
            'jpeg' => 'jpg',
            'jpg', 'png', 'webp' => $extension,
            default => 'jpg',
        };
    }
}
