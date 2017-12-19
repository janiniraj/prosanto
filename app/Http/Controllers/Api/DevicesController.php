<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\DeviceTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Device\EloquentDeviceRepository;

class DevicesController extends BaseApiController
{
    /**
     * Device Transformer
     *
     * @var Object
     */
    protected $deviceTransformer;

    /**
     * Repository
     *
     * @var Object
     */
    protected $repository;

    /**
     * __construct
     *
     * @param DeviceTransformer $deviceTransformer
     */
    public function __construct(EloquentDeviceRepository $repository, DeviceTransformer $deviceTransformer)
    {
        parent::__construct();

        $this->repository       = $repository;
        $this->deviceTransformer = $deviceTransformer;
    }


    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        if(isset($requestData['name']) && $requestData['name'] && isset($requestData['udid']) && $requestData['udid'] && isset($requestData['devicetype']) && $requestData['devicetype'] && isset($requestData['token']) && $requestData['token'])
        {
            $exist = $this->repository->checkforDuplicate($requestData);

            if($exist)
            {
                $error = 'Record Already Exist';
            }
            else
            {
                $model = $this->repository->create($requestData);

                if($model)
                {
                    return $this->successResponse([], 'Record Created Successfully');
                }

                $error = 'Invalid Inputs';    
            }            
        }
        else
        {
            $error = 'Invalid Inputs';
        }        

        return $this->setStatusCode(400)->failureResponse($error, 'Something went wrong !');
    }

}
