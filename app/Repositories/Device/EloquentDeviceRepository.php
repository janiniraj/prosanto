<?php namespace App\Repositories\Device;

use App\Models\Device\Device;
use App\Models\Access\User\User;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentDeviceRepository extends DbRepository implements DeviceRepositoryContract
{
	/**
	 * Device Model
	 * 
	 * @var Object
	 */
	public $model;

	/**
	 * Module Title
	 * 
	 * @var string
	 */
	public $moduleTitle = 'Device';

	/**
	 * Table Headers
	 *
	 * @var array
	 */
	public $tableHeaders = [
		'name' 			=> 'Device Name',
		'udid' 			=> 'Device UDID',
		'devicetype' 	=> 'Device Type',
		'token' 		=> 'Token',
		'created_at' 	=> 'Created Date'
	];

	/**
	 * Table Columns
	 *
	 * @var array
	 */
	public $tableColumns = [
		'name' =>	[
			'data' 			=> 'name',
			'name' 			=> 'name',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'udid' => [
			'data' 			=> 'udid',
			'name' 			=> 'udid',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'devicetype' => [
			'data' 			=> 'devicetype',
			'name' 			=> 'devicetype',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'token' => [
			'data' 			=> 'token',
			'name' 			=> 'token',
			'searchable' 	=> true, 
			'sortable'		=> true
		],
		'created_at' => [
			'data' 			=> 'created_at',
			'name' 			=> 'created_at',
			'searchable' 	=> false, 
			'sortable'		=> false
		]
	];

	/**
	 * Is Admin
	 * 
	 * @var boolean
	 */
	protected $isAdmin = false;

	/**
	 * Admin Route Prefix
	 * 
	 * @var string
	 */
	public $adminRoutePrefix = 'admin';

	/**
	 * Client Route Prefix
	 * 
	 * @var string
	 */
	public $clientRoutePrefix = 'frontend';

	/**
	 * Admin View Prefix
	 * 
	 * @var string
	 */
	public $adminViewPrefix = 'backend';

	/**
	 * Client View Prefix
	 * 
	 * @var string
	 */
	public $clientViewPrefix = 'frontend';

	/**
	 * Module Routes
	 * 
	 * @var array
	 */
	public $moduleRoutes = [
		'listRoute' 	=> 'device.index',
		'createRoute' 	=> 'device.create',
		'storeRoute' 	=> 'device.store',
		'editRoute' 	=> 'device.edit',
		'updateRoute' 	=> 'device.update',
		'deleteRoute' 	=> 'device.destroy',
		'dataRoute' 	=> 'device.get-list-data'
	];

	/**
	 * Module Views
	 * 
	 * @var array
	 */
	public $moduleViews = [
		'listView' 		=> 'device.index',
		'createView' 	=> 'device.create',
		'editView' 		=> 'device.edit',
		'deleteView' 	=> 'device.destroy',
	];

	/**
	 * Construct
	 *
	 */
	public function __construct()
	{
		$this->model 		= new Device;
		$this->userModel 	= new User;
	}

	/**
	 * Create Device
	 *
	 * @param array $input
	 * @return mixed
	 */
	public function create($input)
	{
		$input = $this->prepareInputData($input, true);
		$model = $this->model->create($input);

		if($model)
		{
			return $model;
		}

		return false;
	}	

	public function checkforDuplicate($input)
	{
		$checkCount = $this->model->where('udid', $input['udid'])->count();
		
		if($checkCount > 0)
		{
			return true;
		}	

		return false;
	}

	/**
	 * Update Device
	 *
	 * @param int $id
	 * @param array $input
	 * @return bool|int|mixed
	 */
	public function update($id, $input)
	{
		$model = $this->model->find($id);

		if($model)
		{
			$input = $this->prepareInputData($input);		
			
			return $model->update($input);
		}

		return false;
	}

	/**
	 * Destroy Device
	 *
	 * @param int $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function destroy($id)
	{
		$model = $this->model->find($id);
			
		if($model)
		{
			return $model->delete();
		}

		return  false;
	}

	/**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAll($orderBy = 'id', $sort = 'asc')
    {
        return $this->model->all();
    }

	/**
     * Get by Id
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id = null)
    {
    	if($id)
    	{
    		return $this->model->find($id);
    	}
        
        return false;
    }   

    /**
     * Get Table Fields
     * 
     * @return array
     */
    public function getTableFields()
    {
    	return [
			$this->model->getTable().'.id as id',
			$this->model->getTable().'.name',
			$this->model->getTable().'.udid',
			$this->model->getTable().'.devicetype',
			$this->model->getTable().'.token',
			$this->model->getTable().'.created_at'
		];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
    	return  $this->model->select($this->getTableFields())
    			->get();
        
    }

    /**
     * Set Admin
     *
     * @param boolean $isAdmin [description]
     */
    public function setAdmin($isAdmin = false)
    {
    	$this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Prepare Input Data
     * 
     * @param array $input
     * @param bool $isCreate
     * @return array
     */
    public function prepareInputData($input = array(), $isCreate = false)
    {
    	return $input;
    }

    /**
     * Get Table Headers
     * 
     * @return string
     */
    public function getTableHeaders()
    {
    	if($this->isAdmin)
    	{
    		return json_encode($this->setTableStructure($this->tableHeaders));
    	}

    	$clientHeaders = $this->tableHeaders;

    	unset($clientHeaders['username']);

    	return json_encode($this->setTableStructure($clientHeaders));
    }

	/**
     * Get Table Columns
     *
     * @return string
     */
    public function getTableColumns()
    {
    	if($this->isAdmin)
    	{
    		return json_encode($this->setTableStructure($this->tableColumns));
    	}

    	$clientColumns = $this->tableColumns;

    	unset($clientColumns['username']);
    	
    	return json_encode($this->setTableStructure($clientColumns));
    }
}