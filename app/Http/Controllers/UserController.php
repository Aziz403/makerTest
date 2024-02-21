<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller {
	
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index() {
		$users = User::all();
		
		return response()->json(['data' => $users]);
	}

	
	/**
	* Store a newly created resource in storage.
	*
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request) {
		
		User::create($request->all());
		
		return response()->json(['success' => 'User created successfully']);
	}

	
	/**
	* Display the specified resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function show($id) {
		$user = User::find($id);
		
		return response()->json(['data' => $user]);
	}

	
	/**
	* Update the specified resource in storage.
	*
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id) {
		
		$user = User::find($id);
		$user->update($request->all());
		
		return response()->json(['success' => 'User updated successfully']);
	}

	
	/**
	* Remove the specified resource from storage.
	*
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id) {
		$user = User::find($id);
		$user->delete();
		
		return response()->json(['success' => 'User deleted successfully']);
	}

	
}
