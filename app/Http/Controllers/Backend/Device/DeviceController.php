<?php

namespace App\Http\Controllers\Backend\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Device\EloquentDeviceRepository;

/**
 * Class DeviceController
 */
class DeviceController extends Controller
{
	/**
	 * Device Repository
	 * 
	 * @var object
	 */
	public $repository;

    /**
     * Create Success Message
     * 
     * @var string
     */
    protected $createSuccessMessage = "Device Created Successfully!";

    /**
     * Edit Success Message
     * 
     * @var string
     */
    protected $editSuccessMessage = "Device Edited Successfully!";

    /**
     * Delete Success Message
     * 
     * @var string
     */
    protected $deleteSuccessMessage = "Device Deleted Successfully";

	/**
	 * __construct
	 * 
	 * @param EloquentDeviceRepository $deviceRepository
	 */
	public function __construct(EloquentDeviceRepository $deviceRepository)
	{
		$this->repository = $deviceRepository;
	}

    /**
     * Device Listing 
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->repository->setAdmin(true)->getModuleView('listView'))->with([
            'repository' => $this->repository
        ]);
    }

    /**
     * Device View
     * 
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view($this->repository->setAdmin(true)->getModuleView('createView'))->with([
            'repository' => $this->repository
        ]);
    }

    /**
     * Store View
     * 
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->createSuccessMessage);
    }

    /**
     * Device View
     * 
     * @return \Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $device = $this->repository->findOrThrowException($id);

        return view($this->repository->setAdmin(true)->getModuleView('editView'))->with([
            'item'          => $device,
            'repository'    => $this->repository
        ]);
    }

    /**
     * Device Update
     * 
     * @return \Illuminate\View\View
     */
    public function update($id, Request $request)
    {
        $requestData = $request->all();

        $exist = $this->repository->checkforDuplicate($requestData, $id);
        if($exist)
        {
            return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashWarning("Record with same UDID already exist.");
        }

        $status = $this->repository->update($id, $requestData);
        
        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->editSuccessMessage);
    }

    /**
     * Device Update
     * 
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $status = $this->repository->destroy($id);
        
        return redirect()->route($this->repository->setAdmin(true)->getActionRoute('listRoute'))->withFlashSuccess($this->deleteSuccessMessage);
    }

  	/**
     * Get Table Data
     *
     * @return json|mixed
     */
    public function getTableData()
    {
     	return Datatables::of($this->repository->getForDataTable())
		    ->escapeColumns(['name', 'sort'])
            ->escapeColumns(['udid', 'sort'])
            ->escapeColumns(['devicetype', 'sort'])
            ->escapeColumns(['token', 'sort'])
            ->addColumn('created_at', function ($device) {
                return date('m-d-Y', strtotime($device->created_at));
            })
		    ->escapeColumns(['created_at', 'sort'])
            ->addColumn('actions', function ($event) {
                return $event->action_buttons;
            })
		    ->make(true);
    }

    /**
     * @param User              $user
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function show(Request $request)
    {
        die("dfdf");
    }
}
