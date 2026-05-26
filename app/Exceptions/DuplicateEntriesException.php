<?php

namespace App\Exceptions;

use Exception;

class DuplicateEntriesException extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => 'Duplicate entry found'
        ], 409);
    }
}
