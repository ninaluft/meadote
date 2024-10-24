<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected $clarifaiClient;

    public function __construct()
    {
        $this->clarifaiClient = new Client([
            'base_uri' => 'https://api.clarifai.com',
            'headers' => [
                'Authorization' => 'Key ' . env('CLARIFAI_API_KEY'),
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function uploadImage($filePath, $folder = null)
    {
        $uploadResult = Cloudinary::upload($filePath, ['folder' => $folder]);
        $imageUrl = $uploadResult->getSecurePath();

        // Verifica a imagem com Clarifai
        if ($this->isImageInappropriate($imageUrl)) {
            Cloudinary::destroy($uploadResult->getPublicId());
            return [
                'secure_url' => null,
                'message'    => 'A imagem contém conteúdo impróprio',
            ];
        }

        return [
            'secure_url' => $imageUrl,
            'public_id'  => $uploadResult->getPublicId(),
        ];
    }

    protected function isImageInappropriate($imageUrl)
    {
        try {
            $response = $this->clarifaiClient->post("/v2/models/moderation-recognition/outputs", [
                'json' => [
                    'inputs' => [
                        [
                            'data' => [
                                'image' => ['url' => $imageUrl]
                            ]
                        ]
                    ]
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $concepts = $data['outputs'][0]['data']['concepts'];

            Log::info('Clarifai response: ', $data); // Log da resposta completa para depuração

            foreach ($concepts as $concept) {
                Log::info("Concept: {$concept['name']}, Confidence: {$concept['value']}"); // Log dos conceitos com a pontuação

                // Ajusta o valor de confiança para detectar conteúdo impróprio
                // if (($concept['name'] == 'nsfw' || $concept['name'] == 'explicit') && $concept['value'] > 0.00085) {
                //     Log::info('Conteúdo impróprio detectado.');
                //     return true; // Retorna true se a imagem for imprópria
                // }

                if ($concept['name'] == 'safe' && $concept['value'] < 0.88) {
                    Log::info('Conteúdo impróprio detectado. Imagem não é considerada segura.');
                    return true; // Retorna true se a imagem for considerada insegura
                }

            }

            return false;
        } catch (\Exception $e) {
            Log::error('Erro ao comunicar com Clarifai: ' . $e->getMessage()); // Log dos erros de comunicação
            return false;
        }
    }

    public function deleteImage($publicId)
    {
        if (env('FILESYSTEM_DISK') === 'cloudinary') {
            Cloudinary::destroy($publicId);
        } else {
            Storage::delete($publicId);
        }
    }


}
