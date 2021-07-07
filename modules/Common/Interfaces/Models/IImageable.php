<?php

namespace Modules\Common\Interfaces\Models;

interface IImageable
{
    /**
     * Salva imagens no disco
     *
     * @param UploadedFile[] $images
     * @param string $disk
     * @param string $relationName
     * @return string[] Lista de paths das imagens salvas
     */
    public function saveImages(array $images, string $disk = 'public', string $relationName = 'images'): array;

    /**
     * Remove imagens do banco de dados e do sistema de arquivos.
     *
     * @param int[] $images IDs das imagens a serem excluídas
     * @param string $relationName
     * @return bool
     */
    public function removeImages(array $images, string $disk = 'public', string $relationName = 'images'): bool;
}
