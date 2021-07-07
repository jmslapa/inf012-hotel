<?php

namespace Modules\Common\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FilesystemException;

trait Imageable
{
    private function getDirectory()
    {
        $classSimpleName = collect(explode('\\', self::class))->last();
        return 'images'.DIRECTORY_SEPARATOR.Str::kebab($classSimpleName);
    }

    private function validateImages(array $images)
    {
        $typeHint = UploadedFile::class;
        $isValid = collect($images)->every(fn($e) => $e instanceof UploadedFile && $e->isValid());

        if (!$isValid) {
            throw new InvalidArgumentException("Arg 1 must be an iterable with only instances of valid {$typeHint}");
        }
    }

    /**
     * Salva imagens no disco
     *
     * @param UploadedFile[] $images
     * @param string $disk
     * @param string $relationName
     * @return string[] Lista de paths das imagens salvas
     */
    public function saveImages(array $images, string $disk = 'local', string $relationName = 'images'): array
    {
        $_ = DIRECTORY_SEPARATOR;
        $temps = [];
        $saveds = [];
        $this->validateImages($images);

        foreach ($images as $img) {
            $temps[] = Storage::disk('temp')->putFile($this->getDirectory(), $img);
        }

        foreach ($temps as $path) {
            if (!Storage::disk($disk)->move("temp{$_}{$path}", "public{$_}{$path}")) {
                throw new FilesystemException("Unable to move file {$path}.");
            }
            $saveds[] = $path;
        }
        
        $saveds = array_map(fn($path) => ['path' => $path], $saveds);

        DB::transaction(function () use ($relationName, $saveds) {
            return $this->$relationName()->createMany($saveds);
        });

        return array_values($saveds);
    }

    /**
     * Remove imagens do banco de dados e do sistema de arquivos.
     *
     * @param int[] $images IDs das imagens a serem excluídas
     * @param string $relationName
     * @return bool
     */
    public function removeImages(array $images, string $disk = 'public', string $relationName = 'images'): bool
    {
        $_ = DIRECTORY_SEPARATOR;
        $query = $this->$relationName()->whereIn('id', $images);
        $paths = $query->get()->pluck('path');
        $query->delete();
        return $paths->map(fn($p) => Storage::disk($disk)->exists($p) ? Storage::disk($disk)->delete($p) : false)
            ->every(fn($p) => $p);
    }
}
