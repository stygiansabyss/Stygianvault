<?php

class User_Permission_Role extends BaseModel 
{
    /**
     * Table declaration
     *
     * @var string $table The table this model uses
     */
    protected $table = 'roles';

    protected $guarded = array();

    public static $rules = array();

    const DEVELOPER = 12;

    public function actions()
    {
        return $this->belongsToMany('User_Permission_Action', 'action_roles', 'role_id', 'action_id');
    }

    public function users()
    {
        return $this->belongsToMany('User', 'role_users', 'role_id', 'user_id');
    }
}