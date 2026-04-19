<?php

namespace App\Services;

use App\Models\Feedback;

class FeedbackService
{
    public static function punteggioInsegnante(): float
    {
        return (float) Feedback::avg('punteggio') ?? 0;
    }
}
