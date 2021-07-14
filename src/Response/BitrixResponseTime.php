<?php


namespace Obuchmann\BitrixApi\Response;


use Carbon\Carbon;

class BitrixResponseTime
{
    protected float $start;
    protected float $finish;
    protected float $duration;
    protected float $processing;
    protected Carbon $date_start;
    protected Carbon $date_end;

    /**
     * BitrixResponseTime constructor.
     * @param float $start
     * @param float $finish
     * @param float $duration
     * @param float $processing
     * @param Carbon $date_start
     * @param Carbon $date_end
     */
    public function __construct(float $start, float $finish, float $duration, float $processing, Carbon $date_start, Carbon $date_end)
    {
        $this->start = $start;
        $this->finish = $finish;
        $this->duration = $duration;
        $this->processing = $processing;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }


    protected static function fromResponse($response){
        if($time = data_get($response, 'time')){
            return new static(
                $time['start'],
                $time['finish'],
                $time['duration'],
                $time['processing'],
                $time['date_start'],
                $time['date_end']
            );
        }
        return null;
    }
}
