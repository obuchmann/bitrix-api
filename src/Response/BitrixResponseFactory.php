<?php


namespace PcWeb\BitrixApi\Response;


use PcWeb\BitrixApi\Request\BitrixRequest;

class BitrixResponseFactory
{

    public function responseFromJson(BitrixRequest $request, array $jsonResponse)
    {
        $result = data_get($jsonResponse, 'result');
        if (!$result) {
            return null;
        }
        // TODO: Check if result_error
        // TODO: capture batch Request (result_total, result_next, result_time)
        $response = $this->makeResponse($request, $result);
        if($response instanceof BitrixCollection){
            $response->total = data_get($jsonResponse, 'total');
            $response->start = $request->getArg('start', 0);
            $response->next = data_get($jsonResponse, 'next');
        }
        return $response;
    }

    public function makeResponse(BitrixRequest $request, array $result)
    {
        if (is_array($result)) {
            $collection = new BitrixCollection(array_map(function ($entry) {
                return new BitrixEntry($entry);
            }, $result));
            $collection->map(function ($entry) {
                return new BitrixEntry($entry);
            });
            $collection->setRequest($request);
            return $collection;
        }

        throw new \Exception("Not yet implemented!");
        return $jsonResponse;
    }


}
