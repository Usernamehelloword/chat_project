<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Allowed chat attachment extensions (images, videos, audio/voice notes).
     */
    protected const CHAT_MEDIA_MIMES = 'jpg,jpeg,png,gif,webp,mp4,webm,mov,mp3,wav,ogg,m4a,aac,weba,oga';

    /**
     * Max chat attachment size in kilobytes (20 MB).
     */
    protected const CHAT_MEDIA_MAX_KB = 20480;

    /**
     * Validation rules shared by private and group message endpoints.
     * A message may be text only, media only, or both.
     */
    protected function chatMessageRules(): array
    {
        return [
            'media'   => [
                'nullable',
                'file',
                'mimes:' . self::CHAT_MEDIA_MIMES,
                'max:' . self::CHAT_MEDIA_MAX_KB,
            ],
            'message' => ['nullable', 'string', 'max:5000', 'required_without:media'],
        ];
    }

    /**
     * Store an uploaded chat attachment on the public disk.
     *
     * @return array{media_path: ?string, media_type: ?string}
     */
    protected function storeChatMedia(Request $request, string $folder): array
    {
        if (!$request->hasFile('media')) {
            return ['media_path' => null, 'media_type' => null];
        }

        $file = $request->file('media');
        $mime = (string) $file->getMimeType();
        $clientMime = (string) $file->getClientMimeType();
        $origName = $file->getClientOriginalName();
        $origExt = strtolower($file->getClientOriginalExtension());

        if (
            str_starts_with($mime, 'audio/') ||
            str_starts_with($clientMime, 'audio/') ||
            str_starts_with($origName, 'voice_') ||
            str_starts_with($origName, 'audio_') ||
            in_array($origExt, ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'weba', 'oga'])
        ) {
            $type = 'audio';
        } elseif (str_starts_with($mime, 'video/') || in_array($origExt, ['mp4', 'mov'])) {
            $type = 'video';
        } else {
            $type = 'image';
        }

        return [
            'media_path' => $file->store("chat_media/{$folder}", 'public'),
            'media_type' => $type,
        ];
    }
}
