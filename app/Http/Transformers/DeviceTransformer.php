<?php

namespace App\Http\Transformers;

use App\Http\Transformers;

class DeviceTransformer extends Transformer 
{
    /**
     * Transform
     * 
     * @param array $data
     * @return array
     */
    public function transform($data) 
    {
        if(is_array($data))
        {
            $data = (object)$data;
        }
        
        return [
            'deviceId'           => (int) $data->id,
            'deviceName'         => $data->name,
            'deviceTitle'        => $data->title,
            'deviceStartDate'    => date('d-m-Y', strtotime($data->start_date)),
            'deviceEndDate'      => date('d-m-Y', strtotime($data->end_date))
        ];
    }

    /*public function createDevice($model = null)
    {
        return [
            'id'            => (int) $model->id,
            'name'          => $model->name,
            'udid'          => $model->title,
            'devicetype'    => date('d-m-Y', strtotime($model->start_date)),
            'token'         => date('d-m-Y', strtotime($model->end_date))
        ];
    }*/
}
