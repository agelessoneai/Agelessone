<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PhotoVerificationService
{
    /**
     * Lightweight visual similarity check. This is not biometric face recognition.
     * It detects identical or visually very similar registered/punch photos.
     */
    public function compare(?string $registeredPath, ?string $punchPath): array
    {
        if (!$registeredPath) {
            return ['status' => 'review_required', 'score' => null, 'reason' => 'Registered profile photo is missing.'];
        }

        if (!$punchPath) {
            return ['status' => 'review_required', 'score' => null, 'reason' => 'Punch photo is missing.'];
        }

        try {
            $registered = Storage::disk('public')->get($registeredPath);
            $punch = Storage::disk('public')->get($punchPath);
        } catch (\Throwable $e) {
            return ['status' => 'review_required', 'score' => null, 'reason' => 'Photo file could not be read.'];
        }

        if (hash('sha256', $registered) === hash('sha256', $punch)) {
            return ['status' => 'matched', 'score' => 100.0, 'reason' => null];
        }

        if (!function_exists('imagecreatefromstring')) {
            return ['status' => 'review_required', 'score' => null, 'reason' => 'Server image comparison extension is unavailable.'];
        }

        $hashA = $this->averageHash($registered);
        $hashB = $this->averageHash($punch);

        if ($hashA === null || $hashB === null) {
            return ['status' => 'review_required', 'score' => null, 'reason' => 'This image format requires manual Admin review.'];
        }

        $different = 0;
        for ($i = 0; $i < 64; $i++) {
            if ($hashA[$i] !== $hashB[$i]) $different++;
        }

        $score = round((1 - ($different / 64)) * 100, 2);
        $status = $score >= 82 ? 'matched' : 'mismatch';

        return [
            'status' => $status,
            'score' => $score,
            'reason' => $status === 'mismatch' ? 'Punch photo is not sufficiently similar to the registered profile photo.' : null,
        ];
    }

    private function averageHash(string $bytes): ?array
    {
        $image = @imagecreatefromstring($bytes);
        if (!$image) return null;

        $small = imagecreatetruecolor(8, 8);
        imagecopyresampled($small, $image, 0, 0, 0, 0, 8, 8, imagesx($image), imagesy($image));

        $values = [];
        $sum = 0;
        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $rgb = imagecolorat($small, $x, $y);
                $r = ($rgb >> 16) & 255;
                $g = ($rgb >> 8) & 255;
                $b = $rgb & 255;
                $gray = (int) round(($r * 0.299) + ($g * 0.587) + ($b * 0.114));
                $values[] = $gray;
                $sum += $gray;
            }
        }

        imagedestroy($small);
        imagedestroy($image);
        $average = $sum / 64;

        return array_map(fn ($value) => $value >= $average ? 1 : 0, $values);
    }
}
