<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\Tool;
use App\Models\Action;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Customer_Group_Relation;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
	public function gotoMenu() {
		$toolList = Tools::GetToolList();
		$toolActive = $toolList[0];
		return view('/menu',
		[
		'toolActive' => $toolActive,
	]);
	}
	public function showTools($toolType)
	{
		$toolList = Tools::GetToolList();
		$toolIndex = array_search($toolType, $toolList, true);
		if (GetType($toolIndex) == 'boolean')
		{
			abort(404);
		}
		$toolActive = $toolList[$toolIndex];

		$tool = Tool::GetTool($toolList[$toolIndex]);
		$actionIndex = 0;
		$actionActive = $tool[$actionIndex];
		$action = Action::GetAction($tool[$actionIndex]);
		
		if(!isset($filteredCustomers))
			$filteredCustomers = Customer::all();
		if(!isset($filteredGroups))
			$filteredGroups = Group::all();

		return view('/manager',
		[
		'toolList' => $toolList,
		'toolActive' => $toolActive,
		'tool' => $tool,
		'actionActive' => $actionActive,
		'action' => $action,
		'customers' => $filteredCustomers,
		'groups' => $filteredGroups,
		'customers_groups_relation' => Customer_Group_Relation::all()
		]);
	}
	public function showToolFeatures($toolType, $toolName) {
		$toolList = Tools::GetToolList();
		$toolIndex = array_search($toolType, $toolList, true);
		if (GetType($toolIndex) == 'boolean')
		{
			abort(404);
		}
		$toolActive = $toolList[$toolIndex];

		$tool = Tool::GetTool($toolList[$toolIndex]);
		$actionIndex = array_search($toolName, $tool, true);
		if (GetType($toolIndex) == 'boolean')
		{
			abort(404);
		}
		$actionActive = $tool[$actionIndex];
		$action = Action::GetAction($tool[$actionIndex]);

		if(!isset($filteredCustomers))
			$filteredCustomers = Customer::all();
		if(!isset($filteredGroups))
			$filteredGroups = Group::all();

		return view('/manager',
		[
		'toolList' => $toolList,
		'toolActive' => $toolActive,
		'tool' => $tool,
		'actionActive' => $actionActive,
		'action' => $action,
		'customers' => $filteredCustomers,
		'groups' => $filteredGroups,
		'customers_groups_relation' => Customer_Group_Relation::all()
		]);
	}
	public function toolExecute($toolType, $toolName) {
		$maxIDvalue = 10000;
		$maxBalanceValue = 10000;
		$toolList = Tools::GetToolList();
		$toolIndex = array_search($toolType, $toolList, true);
		if (GetType($toolIndex) == 'boolean')
		{
			abort(404);
		}
		$toolActive = $toolList[$toolIndex];
		$tool = Tool::GetTool($toolList[$toolIndex]);
		$actionIndex = array_search($toolName, $tool, true);
		if (GetType($toolIndex) == 'boolean')
		{
			abort(404);
		}
		$actionActive = $tool[$actionIndex];
		$action = Action::GetAction($tool[$actionIndex]);
		
		$filteredCustomers = Customer::all();
		$filteredGroups = Group::all();

		switch($actionActive)
		{
			case 'New-Customer':
				$attributes = request()->validate(['Customer-Name' => ['required', 'max:255', 'alpha'], ]);
				$customer = new Customer;
				$customer->name = $attributes['Customer-Name'];
				$customer->balance = 0;
				$customer->save();
				break;
			case 'Remove-Customer':
				$attributes = request()->validate(['Customer-ID' => ['required', 'exists:customers,id','lt:'.$maxIDvalue,'integer', 'gt:0'], ]);
				$customer = Customer::find($attributes['Customer-ID']);
				$customer->delete();
				break;
			case 'New-Group':
				$attributes = request()->validate(['Group-Name' => ['required', 'unique:groups,name','max:255'], ]);
				$group = new Group;
				$group->name = $attributes['Group-Name'];
				$group->save();
				break;
			case 'Remove-Group':
				$attributes = request()->validate(['Group-ID' => ['required','exists:groups,id', 'lt:'.$maxIDvalue,'integer', 'gt:0'], ]);
				$group = Group::find($attributes['Group-ID']);
				$group->delete();
				break;
			case 'Assign-Customer':
				$attributes = request()->validate(
				[
				'Customer-ID' 	=> 	['required', 'exists:customers,id','lt:'.$maxIDvalue,'integer', 'gt:0'], 
				'Group-ID' 	=> 	['required', 'exists:groups,id','lt:'.$maxIDvalue,'integer', 'gt:0']
				]);
				$group = Group::find($attributes['Group-ID']);
				$customer = Customer::find($attributes['Customer-ID']);
				$customer->groups;
				$customer->groups()->syncWithoutDetaching($group);
				$customer->save();
				break;
			case 'Unassign-Customer':
				$attributes = request()->validate(
				[
				'Customer-ID' 	=> 	['required','exists:customers,id','lt:'.$maxIDvalue,'integer', 'gt:0'], 
				'Group-ID' 	=> 	['required','exists:groups,id','lt:'.$maxIDvalue,'integer', 'gt:0']
				]);
				$group = Group::find($attributes['Group-ID']);
				$customer = Customer::find($attributes['Customer-ID']);
				$customer->groups;
				$customer->groups()->detach($group);
				$customer->save();
				break;
			case 'Add-Balance':
				$attributes = request()->validate(
				[
				'Customer-ID' => ['required', 'exists:customers,id', 'lt:'.$maxIDvalue,'integer', 'gt:0'], 
				'Value' => ['required', 'lt:'.$maxBalanceValue,'integer', 'gt:0'], 
				]);
				$customer = Customer::find($attributes['Customer-ID']);
				$customer->balance += $attributes['Value'];
				$customer->save();
				break;
			case 'Subtract-Balance':
				$attributes = request()->validate(
				[
				'Customer-ID' => ['required', 'exists:customers,id','lt:'.$maxIDvalue, 'integer', 'gt:0'], 
				'Value' => ['required', 'lt:'.$maxBalanceValue,'integer', 'gt:0'], 
				]);
				$customer = Customer::find($attributes['Customer-ID']);
				$customer->balance -= $attributes['Value'];
				$customer->save();
				break;
			case 'Search-Customer-By-ID':
				$attributes = request()->validate(
				[
				'Customer-ID' => ['required', 'lt:'.$maxIDvalue, 'integer', 'gt:0']
				]);
				
				$filteredCustomers = Customer::all()->filter(function ($customer) use ($attributes) {
    				return $customer['id'] == $attributes['Customer-ID'];
				});

				break;
			case 'Search-Customer-By-Name':
				$attributes = request()->validate(
				[
				'Customer-Name' => ['required', 'max:255', 'alpha']
				]);
				$filteredCustomers = Customer::all()->filter(function ($customer) use ($attributes) {
    				return $customer['name'] == $attributes['Customer-Name'];
				});

				break;
			case 'Search-Group-By-ID':
				$attributes = request()->validate(
				[
				'Group-ID' => ['required', 'lt:'.$maxIDvalue, 'integer', 'gt:0']
				]);
				
				$filteredGroups = Group::all()->filter(function ($group) use ($attributes) {
    				return $group['id'] == $attributes['Group-ID'];
				});

				break;
			case 'Search-Group-By-Name':
				$attributes = request()->validate(
				[
				'Group-Name' => ['required', 'max:255']
				]);

				$filteredGroups = Group::all()->filter(function ($group) use ($attributes) {
    				return $group['name'] == $attributes['Group-Name'];
				});

				break;
			default:
				abort(404);
				break;
		}
		if($toolActive == 'Manage')
			return back();
		else
			return view('/manager',
			[
			'toolList' => $toolList,
			'toolActive' => $toolActive,
			'tool' => $tool,
			'actionActive' => $actionActive,
			'action' => $action,
			'customers' => $filteredCustomers,
			'groups' => $filteredGroups,
			'customers_groups_relation' => Customer_Group_Relation::all()
			]);
	}
}
