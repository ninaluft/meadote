<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Faz upload de uma imagem para o Cloudinary ou para o armazenamento local, dependendo do driver configurado.
     *
     * @param string $filePath O caminho do arquivo local.
     * @param string|null $folder A pasta opcional no Cloudinary.
     * @return array Contém a URL segura e o public_id da imagem.
     */
    public function uploadImage($filePath, $folder = null)
    {

        if (env('FILESYSTEM_DISK') === 'cloudinary') {
            $uploadResult = Cloudinary::upload($filePath, ['folder' => $folder]);

            return [
                'secure_url' => $uploadResult->getSecurePath(),  // URL segura da imagem
                'public_id'  => $uploadResult->getPublicId(),    // public_id da imagem
            ];
        } else {

            $folder = $folder ? "public/{$folder}" : 'public';

            // Use Storage::putFile() para salvar o arquivo de upload no armazenamento local
            $storedPath = Storage::putFile($folder, new \Illuminate\Http\File($filePath));

            if (!$storedPath) {

                return [
                    'secure_url' => null,
                    'public_id'  => null,
                ];
            }

            $url = Storage::url($storedPath);

            return [
                'secure_url' => $url,  // A URL pública da imagem
                'public_id'  => $storedPath, // Caminho real do arquivo salvo localmente
            ];
        }
    }

    /**
     * Exclui uma imagem, dependendo do driver de armazenamento configurado.
     *
     * @param string $publicId O public_id ou caminho da imagem a ser excluída.
     * @return void
     */
    public function deleteImage($publicId)
    {
        // Exclui do Cloudinary ou do local storage dependendo do disco configurado
        if (env('FILESYSTEM_DISK') === 'cloudinary') {
            Cloudinary::destroy($publicId);
        } else {
            Storage::delete($publicId);
        }
    }
}
