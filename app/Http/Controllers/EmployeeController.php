<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    
    public function index()
    {
    	return view('employee.index');
    }

    public function list()
	{ 
		$target = request()->search;
	    
	    $users = User::with('cities')
	     ->orderBy('id', 'desc')
	     ->paginate();

	    $banks = Bank::all();

		return [
		  'employes' =>  $emloyees,
		  'cities' =>  $cities,
		]; 
	}

	public function store()
	{
		$employee = Employee::create([
			'name' => request()->name,
			'city_id' => request()->city_id,
		]);

		$employee->save();

		return ['message' => 'El empleado se ha creado con exito'];
	}

	public function update($id)
	{
		$employee = Employee::find($id);

		$employee->fill(request()->all());

		$employee->save();

		return ['message' => 'El empleado se ha actualizada con exito'];
	}

	public function show()
	{
		return view('admin.employee.show') -> with(['id' => request() -> id]);
	}

	public function getData()
	{
	   return Employee::FindOrFail(request()->id);
	}
	 
	public function delete()
	{
		$employee = Employee::find(request()->id); 
		$employee -> save();

		return ['message' => 'El empleado se ha eliminado con exito'];
	}

	
}
