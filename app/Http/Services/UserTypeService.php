<?php

namespace App\Http\Services;
use App\Models\UserType;

class UserTypeService
{
      public function getAllTypes()
      {
             return UserType::orderBy('name')->get();
      }
}