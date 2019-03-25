<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  /**

  * Users relationship

  */
  public function users()
  {
    return $this->belongsToMany(User::class);
  }

  /**

  * Admin scope
  
  * @param $query 
  
  */
  public function scopeAdmin($query)
  {
    return $query->where('name', 'admin');
  }
}
