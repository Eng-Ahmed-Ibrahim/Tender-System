<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends Controller
{
    public function translateAndSave(array $inputs, $operation)
    {
        $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];

        foreach ($inputs as $key => $value) {
            if (is_string($value) && !empty($value)) {
                foreach ($languages as $lang) {
                    $translatedText = GoogleTranslate::trans($value, $lang);
                    $this->saveTranslation($lang, $key, $translatedText);
                }
            }
        }
    }

    private function saveTranslation($lang, $key, $translatedText)
    {
        $path = resource_path("lang/{$lang}.json");
        $translations = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        
        // Ensure the translations array structure matches your needs
        $translations[$key] = $translatedText;
        
        file_put_contents($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }}
