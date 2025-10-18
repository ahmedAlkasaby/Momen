<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MainCollection extends ResourceCollection
{
    protected $key;

    public function __construct($resource, string $key = 'data')
    {
        parent::__construct($resource);
        $this->key = $key;
    }

    public function toArray(Request $request): array
    {
        return [
            $this->key => $this->collection,
        ];
    }
}
