<?php
namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $imageService;

    // Usar injeção de dependência no construtor para o serviço
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    // Exemplo de uso no Controller para teste
    public function testImageUpload(Request $request)
    {
        // Validar o upload da imagem
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validação básica
        ]);

        // Fazer upload da imagem usando o serviço ImageService
        $filePath = $request->file('image')->getPathname();
        $result = $this->imageService->uploadImage($filePath);

        // Retornar a resposta apropriada
        if ($result['secure_url']) {
            return response()->json(['url' => $result['secure_url'], 'message' => 'Imagem aprovada']);
        } else {
            return response()->json(['message' => $result['message'] ?? 'Erro ao processar a imagem']);
        }
    }
}
