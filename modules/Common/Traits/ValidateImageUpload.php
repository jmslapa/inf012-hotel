<?php

namespace Modules\Common\Traits;

trait ValidateImageUpload
{
    public function getSingleImageRules(
        bool $required = true,
        int $maxSize = 2048,
        int $minWidth = 320,
        int $maxWidth = 800,
        int $minHeight = 180,
        int $maxHeight = 450,
        string $ratio = '16/9'
    ): array {
        return [
            ($required ? 'required' : 'nullable'),
            'image',
            "max:{$maxSize}",
            'mimetypes:image/png,image/jpeg',
            "dimensions:".
                "min_width={$minWidth},min_height={$minHeight},".
                "max_width={$maxWidth},max_height={$maxHeight},".
                "ratio={$ratio}"
        ];
    }

    public function getImageArrayRules(int $maxImages = null): array
    {
        $rules = ['required', 'array', 'min:1'];
        return $maxImages !== null && $maxImages > 0 ? $rules : [...$rules, "max:{$maxImages}"];
    }
}
