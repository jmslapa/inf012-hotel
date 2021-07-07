<?php

namespace Support\Behaviors;

use Illuminate\Http\JsonResponse;
use Support\Interfaces\Behaviors\IBecomeJsonResponseBehavior;

class BecomeAIlluminateJsonResponseBehavior implements IBecomeJsonResponseBehavior
{
    /**
     * @return JsonResponse
     */
    public function perform(array $data = [], int $status = 200, array $headers = []): object
    {
        return response()->json($data, $status, $headers);
    }
}
