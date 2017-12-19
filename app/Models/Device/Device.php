<?php namespace App\Models\Device;

/**
 * Class Device
 *
 * @author Niraj Jani
 */

use App\Models\BaseModel;
use App\Models\Device\Traits\Attribute\Attribute;
use App\Models\Device\Traits\Relationship\Relationship;

class Device extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "devices";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        'name',
        'udid',
        'devicetype',
        'token',
        'created_at',
        'updated_at'
    ];

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}