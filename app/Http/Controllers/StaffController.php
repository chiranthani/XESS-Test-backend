<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\StaffUser;
use Illuminate\Http\Request;
use Exception;

class StaffController extends Controller
{
    public function getStaffMembers()
    {
        try {
            $staff = StaffUser::all();

            return ResponseHelper::success('staff fetched successfully', $staff);
        } catch (Exception $ex) {
            return ResponseHelper::error('Request failed. Please try again', $ex->getMessage());
        }
    }
}
