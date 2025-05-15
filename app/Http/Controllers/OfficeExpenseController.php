<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\OfficeExpense;
use Exception;
use Illuminate\Http\Request;

class OfficeExpenseController extends Controller
{
    public function getOfficeExpenses()
    {
        try {
            $expenses = OfficeExpense::all();

            return ResponseHelper::success('expenses fetched successfully', $expenses);
        } catch (Exception $ex) {
            return ResponseHelper::error('Request failed. Please try again', $ex->getMessage());
        }
    }
}
