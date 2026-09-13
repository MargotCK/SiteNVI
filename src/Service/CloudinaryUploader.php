<?php

namespace App\Service;

use Cloudinary\Cloudinary;

class CloudinaryUploader
{
    private Cloudinary $cloudinary;

    public function __construct(string $cloudinaryUrl)
    {
        $this->cloudinary = new Cloudinary($cloudinaryUrl);
    }

    public function upload(string $filePath, string $folder = 'sitenvi'): array
    {
        $result = $this->cloudinary->uploadApi()->upload(
            $filePath,
            [
                'folder' => $folder,
                'resource_type' => 'image',
            ]
        );

        return [
            'url' => $result['secure_url'],
            'publicId' => $result['public_id'],
            'format' => $result['format'] ?? null,
            'width' => $result['width'] ?? null,
            'height' => $result['height'] ?? null,
        ];
    }

    public function delete(string $publicId): void
    {
        $this->cloudinary->uploadApi()->destroy($publicId);
    }
}