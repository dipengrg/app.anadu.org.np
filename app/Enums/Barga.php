<?php

namespace App\Enums;

enum Barga: int
{
    case मुसा = 1;
    case गाई = 2;
    case बाघ = 3;
    case बिरालो = 4;
    case गिद्ध = 5;
    case सर्प = 6;
    case घोडा = 7;
    case भेडा = 8;
    case बादर = 9;
    case चरा = 10;
    case कुकुर = 11;
    case मृग = 12;

    public function label(): string
    {
        return match($this) {
            self::मुसा => 'मुसा (च्यु)',
            self::गाई => 'गाई (ल्वों)',
            self::बाघ => 'बाघ (तो)',
            self::बिरालो => 'बिरालो (हि)',
            self::गिद्ध => 'गिद्ध (मुप्रि)',
            self::सर्प => 'सर्प (सप्रि)',
            self::घोडा => 'घोडा (त)',
            self::भेडा => 'भेडा (ल्हु)',
            self::बादर => 'बादर (प्र)',
            self::चरा => 'चरा (च्य)',
            self::कुकुर => 'कुकुर (खी)',
            self::मृग => 'मृग (फो)',
        };
    }
}
