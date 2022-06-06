<?php
namespace App\Models;

use Illuminate\Support\Collection;

class Tools
{
	public static function GetToolList()
	{
		$toolList = [
		'Manage',
		'Search'
		];
		return $toolList;
	}
}
class Tool
{
	public static function GetTool($name)
	{
		switch($name) {
			case 'Manage':
				return
				[
				'New-Customer', 'Remove-Customer',
				'New-Group', 'Remove-Group',
				'Assign-Customer', 'Unassign-Customer',
				'Add-Balance', 'Subtract-Balance'
				];
				break;
			case 'Search':
				return
				[
				'Search-Customer-By-ID',
				'Search-Customer-By-Name',
				'Search-Group-By-ID',
				'Search-Group-By-Name'
				];
				break;
		}
	}
}
class Action
{
	public static function GetAction($name)
	{
		switch($name) {
			case 'New-Customer':
				return
				[
				'Customer-Name',
				'Add'
				];
				break;
			case 'Remove-Customer':
				return
				[
				'Customer-ID',
				'Remove'
				];
				break;
			case 'New-Group':
				return
				[
				'Group-Name',
				'Add'
				];
				break;
			case 'Remove-Group':
				return
				[
				'Group-ID',
				'Remove'
				];
				break;
			case 'Assign-Customer':
				return
				[
				'Customer-ID',
				'Group-ID',
				'Add'
				];
				break;
			case 'Unassign-Customer':
				return
				[
				'Customer-ID',
				'Group-ID',
				'Remove'
				];
				break;
			case 'Add-Balance':
				return
				[
				'Customer-ID',
				'Value',
				'Add'
				];
				break;
			case 'Subtract-Balance':
				return
				[
				'Customer-ID',
				'Value',
				'Subtract'
				];
				break;
			case 'Search-Customer-By-Name':
				return
				[
				'Customer-Name',
				'Find'
				];
				break;
			case 'Search-Customer-By-ID':
				return
				[
				'Customer-ID',
				'Find'
				];
				break;
			case 'Search-Group-By-ID':
				return
				[
				'Group-ID',
				'Find'
				];
				break;
			case 'Search-Group-By-Name':
				return
				[
				'Group-Name',
				'Find'
				];
				break;
				
		}
	}

}