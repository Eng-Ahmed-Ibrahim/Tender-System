<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $key;
    protected $value;
    protected $languages;


   public function __construct($key, $value, $languages)
    { 
        $this->key = $key;
        $this->value = $value;
        $this->languages = $languages;
    }


    public function handle()
    {
        foreach ($this->languages as $lang) {
            $translatedText = GoogleTranslate::trans($this->value, $lang);
            $this->saveTranslation($lang, $this->value, $translatedText);
        }
    }

    private function saveTranslation($lang, $value, $translatedText)
    {
        $path = resource_path("lang/{$lang}.json");
        $translations = file_exists($path) ? json_decode(file_get_contents($path), true) : [];

        $translations[$value] = $translatedText;

        file_put_contents($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
