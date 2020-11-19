<?php


namespace PcWeb\BitrixApi\Response;


use PcWeb\BitrixApi\Request\BitrixRequest;

class BitrixResponseFactory
{
    public function makeResponse(BitrixRequest $request, array $jsonResponse)
    {
        $result = data_get($jsonResponse, 'result');
        if (!$result) {
            return null;
        }
        if (is_array($result)) {
            $collection = new BitrixCollection(array_map(function ($entry) {
                return new BitrixEntry($entry);
            }, $result));
            $collection->map(function ($entry) {
                return new BitrixEntry($entry);
            });
            $collection->total = data_get($jsonResponse, 'total');
            $collection->start = $request->arg('start', 0);
            $collection->next = data_get($jsonResponse, 'next');
            return $collection;
        }


        return $jsonResponse;
    }
}
