<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuList extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'key',
        'parent',
        'access',
        'icon_class',
        'order',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get Access From Menu
     *
     */
    public function access()
    {
        return $this->hasMany(AccessList::class, 'menu', 'id');
    }

    /**
     * Get Children of Menu
     *
     */
    public function children()
    {
        return $this->hasMany(MenuList::class, 'parent', 'id');
    }
}
