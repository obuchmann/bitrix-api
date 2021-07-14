<?php


namespace Obuchmann\BitrixApi\Response;


use Obuchmann\BitrixApi\Exceptions\BitrixException;
use Obuchmann\BitrixApi\Request\BitrixRequest;

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
        if ($response instanceof BitrixCollection) {
            $response->total = data_get($jsonResponse, 'total');
            $response->start = $request->getArg('start', 0);
            $response->next = data_get($jsonResponse, 'next');
        }
        return $response;
    }

    public function makeResponse(BitrixRequest $request, $result)
    {
        if ($result instanceof BitrixEntry) {
            return $result;
        }

        if(is_scalar($result)){
            $entry = new BitrixEntry(['result' => $result]);
            $entry->setRequest($request);
            return $entry;
        }

        if (!is_array($result)) {
            throw new BitrixException("Unknown Response $result");
        }

        /** @var BitrixEntry $entity */
        $entry = $this->mapValueToEntry($result);

        $entry->setRequest($request);
        return $entry;
    }

    private function mapValueToEntry($result)
    {
        if (is_scalar($result)) {
            return $result;
        }

        if ($this->isSingle($result)) {
            return new BitrixEntry($result);
        }
        return new BitrixCollection(array_map(function ($entry) {
            if ($entry === null) {
                return null;
            }
            if (is_scalar($entry)) {
                return $entry;
            }
            return $this->mapValueToEntry($entry);
        }, $result));
    }


    private function isSingle($entry)
    {
        foreach ($entry as $item) {
            if (!is_scalar($item)) {
                return false;
            }
        }
        return true;
    }


}
