<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'image_size' => env('OPENAI_IMAGE_SIZE', '256x256'),
    'generate_summary' => boolval(env('OPENAI_GENERATE_SUMMARY', true)),
    'generate_beat_summary' => boolval(env('OPENAI_GENERATE_BEAT_SUMMARY', true)),
    'generate_images' => boolval(env('OPENAI_GENERATE_IMAGES', true)),

];
