<?php
namespace App\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Response
{
    public static function getUid() {
        return (string) Str::uuid();
    }

    public static function ok(string $message, $data = null, int $httpStatusCode = 200)
    {
        $uuid = self::getUid();
        $reasonPhrase = self::getSatusText($httpStatusCode);

        return response()->json(
            compact('uuid', 'reasonPhrase', 'message', 'data'),
            $httpStatusCode
        );
    }

    /**
     * getSatusText
     *
     * @param integer $httpStatusCode
     * @return string
     */
    public static function getSatusText(int $httpStatusCode): string
    {
        return HttpFoundationResponse::$statusTexts[$httpStatusCode];
    }
}
