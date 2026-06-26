<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{

    public function generateContent(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $prompt = "Actúa como un asistente de escritura para una aplicación de notas llamada NoteAI.\n" .
            "El usuario ha escrito el siguiente título para su nota: \"{$request->title}\".\n" .
            "Instrucciones:\n" .
            "1. Evalúa si el título tiene sentido. Si son letras al azar, un error de tipeo evidente o texto incomprensible (ej. 'asdasd', 'jvdshg'), 
            responde ÚNICAMENTE con: 'Parece que el título no tiene mucho sentido. Por favor, intenta con un título más descriptivo para que pueda ayudarte mejor.'\n" .
            "2. Si el título tiene sentido, escribe un desarrollo o contenido breve, útil y conciso (máximo 4 renglones) para esa nota.\n" .
            "Devuelve ÚNICAMENTE el resultado final (ya sea el texto de la nota o el mensaje de error), sin saludos, sin introducciones y sin explicaciones adicionales.";


        $res = Http::withToken(config('services.huggingface.key'))
            ->post("https://router.huggingface.co/v1/chat/completions", [
                'model' => config('services.huggingface.model'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7
            ]);

        if ($res->failed()) {
            return response()->json(['error' => 'Error al conectar con la IA'], 500);
        }

        $aiText = $res->json('choices.0.message.content');

        return response()->json(['suggestion' => trim($aiText)]);
    }



    public function improveContent(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $prompt = "Actúa como un asistente de escritura avanzado para una aplicación de notas llamada NoteAI.\n" .
            "El usuario ha escrito el siguiente contenido para su nota: \"{$request->content}\".\n" .
            "Instrucciones:\n" .
            "1. Evalúa si el contenido tiene sentido. Si son letras al azar o texto incomprensible (ej. 'asdasd'), responde ÚNICAMENTE con: 'El contenido no es claro. Por favor, proporciona más detalles para poder mejorarlo.'\n" .
            "2. Si el texto tiene sentido, mejóralo para que sea más claro, conciso y profesional.\n" .
            "3. Mantén el sentido original, pero corrige gramática, ortografía y redacción.\n" .
            "4. Si el texto es muy corto o vago, enriquécelo con detalles lógicos que aporten valor sin cambiar el tema principal.\n" .
            "Devuelve ÚNICAMENTE el texto mejorado (o el mensaje de advertencia), sin comillas que lo envuelvan, sin saludos y sin explicaciones.";


        $res = Http::withToken(config('services.huggingface.key'))
            ->post("https://router.huggingface.co/v1/chat/completions", [
                'model' => config('services.huggingface.model'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7
            ]);

        if ($res->failed()) {
            return response()->json(['error' => 'Error al conectar con la IA'], 500);
        }

        $aiText = $res->json('choices.0.message.content');

        return response()->json(['suggestion' => trim($aiText)]);
    }
}
