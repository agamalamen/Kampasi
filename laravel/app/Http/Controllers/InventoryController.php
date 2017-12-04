<?php

namespace App\Http\Controllers;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Inventory;
use App\InventoryAttribute;
use App\Item;
use App\User;
use App\UserAllocatedCost;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class InventoryController extends Controller
{
    public function getInventories()
    {
      return view('maboneng');
      return view('app.school.inventory.inventories');
    }

    public function postInventory(Request $request)
    {
      if(!Auth::User()->authority->create_inventory) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      $name = strtolower($request['name']);
      //Make alphanumeric (removes all other characters)
      $name = preg_replace("/[^a-z0-9_\s-]/", "", $request['name']);
      //Clean up multiple dashes or whitespaces
      $name = preg_replace("/[\s-]+/", " ", $request['name']);
      //Convert whitespaces and underscore to dash
      $name = preg_replace("/[\s_]/", "-", $request['name']);
      $request['name'] = $name;

      $this->validate($request, [
        'name' => 'required|unique:inventories'
      ]);

      $colors = ['purple', 'red', 'green', 'orange'];

      $inventory = new Inventory();
      $inventory->name = $request['name'];
      $inventory->school_id = Auth::User()->school->id;
      $inventory->color = $colors[rand(0,3)];
      $inventory->save();
      return redirect()->route('get.inventory', [Auth::User()->school->username, $inventory->name]);
    }

    public function getInventory($school_username, $name)
    {
      $inventory = Inventory::where('name', $name)->first();
      if($inventory == '') {
        return redirect()->route('get.inventories', Auth::User()->school->username)->with(['message' => 'Inventory is not found', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $inventory->views += 1;
      $inventory->update();
      $matchThese = ['inventory_id' => $inventory->id, 'deleted' => 0];
      $items = Item::where($matchThese)->paginate(6);
      return view('app.school.inventory.inventory')->with(['inventory' => $inventory, 'items' => $items]);
    }

    public function getInventorySettings($school_username, $inventory_name)
    {
      $inventory = Inventory::where('name', $inventory_name)->first();
      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }
      if(!$authorized && !Auth::User()->authority->inventory) {
        return redirect()->route('get.inventories', [$school_username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      return view('app.school.inventory.settings.all')->with(['inventory' => $inventory]);
    }

    public function postUpdateInventoryName(Request $request, $school_username, $inventory_name)
    {
      $inventory = Inventory::where('name', $inventory_name)->first();

      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $name = strtolower($request['name']);
      //Make alphanumeric (removes all other characters)
      $name = preg_replace("/[^a-z0-9_\s-]/", "", $request['name']);
      //Clean up multiple dashes or whitespaces
      $name = preg_replace("/[\s-]+/", " ", $request['name']);
      //Convert whitespaces and underscore to dash
      $name = preg_replace("/[\s_]/", "-", $request['name']);
      $request['name'] = $name;

      $this->validate($request, [
        'name' => 'required|unique:inventories'
      ]);

      $inventory->name = $request['name'];
      $inventory->update();
      return redirect()->route('get.inventory', [Auth::User()->school->username, $inventory->name]);
    }

    public function getRemoveInventoryOwner($school_username, $inventory_name, $user_id)
    {
      $inventory = Inventory::where('name', $inventory_name)->first();

      $matchThese = ['inventory_id' => $inventory->id, 'user_id' => $user_id];
      DB::table('inventory_user')->where($matchThese)->delete();
      return redirect()->route('get.inventory.settings', [Auth::User()->school->username, $inventory->name]);
    }

    public function postDeleteInventory(Request $request, $school_username, $inventory_name)
    {
      $this->validate($request, [
        'name' => 'required'
        ]);

        if($inventory_name != $request['name']) {
          return redirect()->back()->with(['message' => 'The inventory name you entered is incorrect.', 'status' => 'alert-danger', 'dismiss' => true]);
        }

        $inventory = Inventory::where('name', $inventory_name)->first();
        $inventory->deleted = 1;
        $inventory->update();
        foreach($inventory->items as $item) {
          $item->deleted = 1;
          $item->update();
        }

        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'Inventory deleted.', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getUserAllocatedCosts($school_username, $user_username)
    {
      $user = '';
      if($user_username == 'all') {
        $allocatedCosts = Auth::User()->school->allocatedCosts;        
        if(Auth::User()->role == 'student') {
          return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
        }
      } else {
        $user = User::where('username', $user_username)->first();
        $allocatedCosts = $user->allocatedCosts;        
        if(Auth::User()->role == 'student' && Auth::User()->id != $user->id) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
        }
      }

      return view('app.school.inventory.allocated-costs')->with(['allocatedCosts' => $allocatedCosts, 'user' => $user]);
    }

    public function postItem(Request $request, $school_username, $name, $inventory_id)
    {
      $inventory = Inventory::find($inventory_id);
      
      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $this->validate($request, [
        'name' => 'required|unique:items'
      ]);
      $item = new Item();
      $item->name = $request['name'];
      $item->stock = $request['stock'];
      $item->cost = $request['cost'];
      $item->inventory_id = $inventory_id;
      $item->school_id = Auth::User()->school->id;
      $item->save();

      $x = 0;
      $y = 1;
      $inventory_attributes_count = $inventory->attributes->count() * 2;
      while ($x < $inventory_attributes_count) {
        if(isset($request[$x])) {
          DB::table('item_attributes')->insert([
                ['item_id' => $item->id, 'inventory_attribute_id' => $request[$y], 'value' => $request[$x]]
            ]);
        }
        $x+= 2;
        $y = $x + 1;
      }
      return redirect()->back();
    }

    public function postEditItem(Request $request, $school_username, $inventory_name, $item_name)
    {
      $inventory = Inventory::where('name', $inventory_name)->first();

      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $item = Item::where('name', $item_name)->first();
      $name_validation = 'required|unique:items';
      if($item->name == $request['name']) {
        $name_validation = '';
      }
      $this->validate($request, [
        'name' => $name_validation,
        'stock' => 'required',
        'cost' => 'required'
      ]);

      $item->name = $request['name'];
      $item->stock = $request['stock'];
      $item->cost = $request['cost'];

      $item->update();

      return redirect()->route('get.inventory', [Auth::User()->school->username, $item->inventory->name])->with(['message' => 'Item updated.', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function deleteItem($school_username, $item_id)
    {
      $item = Item::find($item_id);
      $inventory = $item->inventory;

      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $item->deleted = 1;
      $item->update();
      return redirect()->route('get.inventory', [Auth::User()->school->username, $item->inventory->name])->with(['message' => 'Item deleted. <a href="'. route('get.undo.delete.item', [Auth::User()->school->username, $item->id]) .'">Undo</a>', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function getUndoDeleteItem($school_username, $item_id)
    {
      $item = Item::find($item_id);
      $inventory = $item->inventory;

      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $item->deleted = 0;
      $item->update();
      return redirect()->back();
    }

    public function getEditItem($school_username, $inventory_name, $item_name)
    {
      $item = Item::where('name', $item_name)->first();
      $inventory = Inventory::where('name', $inventory_name)->first();

      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      return view('app.school.inventory.edit-item')->with(['item' => $item, 'inventory' => $inventory]);
    }

    public function postInventoryAttribute(Request $request, $school_username, $inventory_name, $inventory_id)
    {
      $this->validate($request, [
        'name' => 'required'
      ]);

      $inventory = Inventory::where('name', $inventory_name)->first();
      //return $inventory;
      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $inventoryAttribute = new InventoryAttribute();
      $inventoryAttribute->inventory_id = $inventory_id;
      $inventoryAttribute->name = $request['name'];
      $inventoryAttribute->save();
      return redirect()->back();
    }

    public function getItem($school_username, $inventory_name, $item_name)
    {
      $item = Item::where('name', $item_name)->first();
      if($item == '') {
        return redirect()->route('get.inventory', [$school_username, $inventory_name]);
      }
      return view('app.school.inventory.item')->with(['item' => $item]);
    }

    public function postLendItem(Request $request, $school_username, $inventory_name, $item_name)
    {
      $currentDate = date('Y-m-d');
      $this->validate($request, [
          'return_date' => 'required|after:' . $currentDate
        ]);
      $inventory = Inventory::where('name', $inventory_name)->first();
      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      /*if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }*/

      $item = Item::where('name', $item_name)->first();
      
      if($item->stock == 0) {
        return redirect()->back()->with(['message' => 'This item is out of stock.', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      DB::table('item_user')->insert([
            ['item_id' => $item->id, 'user_id' => $request['user'], 'received_date' => date('Y-m-d'), 'return_date' => $request['return_date']]
        ]);
      $item->stock -= 1;
      $item->update();
      return redirect()->back();
    }

    public function getUserInventory($school_username, $user_username)
    {
      $user = User::where('username', $user_username)->first();
      if($user == '') {
        return redirect()->route('get.inventories', Auth::User()->school->username);
      }

      if(Auth::User()->role == 'student' && Auth::User() != $user) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      return view('app.school.inventory.my-inventory')->with(['user' => $user]);
    }

    public function getTrackItems($school_username, $item_id)
    {
      if(!Auth::User()->authority->track_items) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      if($item_id == 'all') {
        $filterItem = '';
      } else {
        $filterItem = Item::find($item_id);
      }

      return view('app.school.inventory.track-items')->with(['filterItem' => $filterItem]);
    }

    public function postItemReturned(Request $request)
    {
      //echo $request['item'] . '<br>' . $request['user'];

      $item = Item::find($request['item']);
      $inventory = $item->inventory;

      $authorized = 0;
      foreach($inventory->users as $user) {
        if(Auth::User()->id == $user->id) {
          $authorized = 1;
          break;
        }
      }

      if(!$authorized) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $item->stock += 1;
      $item->update();
      $matchThese = ['item_id' => $request['item'], 'user_id' => $request['user']];
      DB::table('item_user')->where($matchThese)->delete();
      return redirect()->back();
    }

    public function getInventoriesSettings()
    {
      if(!Auth::User()->authority->inventory) {
        return redirect()->back()->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }
      return view('app.school.inventory.settings.inventories-settings');
    }

    public function postInventoryAdmin(Request $request, $school_username)
    {
      $user = User::find($request['user']);
      $user->authority->inventory = 1;
      $user->authority->create_inventory = 1;
      $user->authority->add_inventory_owner = 1;
      $user->authority->track_items = 1;
      $user->authority->update();
      return redirect()->back()->with(['message' => 'User was successfully added.', 'status' => 'alert-success', 'dismiss' => true]);
    }

    public function postTrackItemsAuthority($school_username, $user_id, $authority)
    {
      if(Auth::User()->role == 'student') {
        return redirect()->back()->with(['message'=> 'You are not authorized.', 'status'=> 'alert-danger', 'dismiss'=> true]);
      }
      $user = User::find($user_id);
      if($user->authority->$authority) {
        $user->authority->$authority = 0;
      } else {
        $user->authority->$authority = 1;
      }

      $user->authority->update();
      return redirect()->back();
    }

    public function postItemPaid(Request $request)
    {
      if(Auth::User()->role == 'student') {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $matchThese = ['item_id' => $request['item'], 'user_id' => $request['user']];
      $allocatedCost = UserAllocatedCost::where($matchThese)->first();
      $allocatedCost->paid = 1;
      $allocatedCost->update();
      return redirect()->back();
    }

    public function postAllItemsPaid(Request $request)
    {
      if(Auth::User()->role == 'student') {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $matchThese = ['paid' => 0, 'user_id' => $request['user']];
      $allocatedCosts = UserAllocatedCost::where($matchThese)->get();
      foreach($allocatedCosts as $cost) {
        $cost->paid = 1;
        $cost->update();
      }
      return redirect()->back();
    }

    public function postItemMissing(Request $request)
    {
      if(Auth::User()->role == 'student') {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $allocatedCost = new UserAllocatedCost();
      $allocatedCost->item_id = $request['item'];
      $allocatedCost->user_id = $request['user'];
      $allocatedCost->school_id = Auth::User()->school->id;
      $allocatedCost->save();

      $matchThese = ['item_id' => $request['item'], 'user_id' => $request['user']];
      DB::table('item_user')->where($matchThese)->delete();

      return redirect()->back();
    }

    public function postInventoryOwner(Request $request, $school_username)
    {
      if(!Auth::User()->authority->add_inventory_owner) {
        return redirect()->route('get.inventories', [Auth::User()->school->username])->with(['message' => 'You are not authorized', 'status' => 'alert-danger', 'dismiss' => true]);
      }

      $matchThese = ['inventory_id' => $request['inventory'], 'user_id' => $request['user']];
      $owner = DB::table('inventory_user')->where($matchThese)->first();
      if($owner != '') {
        return redirect()->back()->with(['message' => 'This user is already an owner', 'status' => 'alert-info', 'dismiss' => true]);
      }
      DB::table('inventory_user')->insert([
            ['inventory_id' => $request['inventory'], 'user_id' => $request['user']]
        ]);
      return redirect()->back();
    }

    public function postDateDeparting(Request $request) 
    {
      $this->validate($request, [
          'date_departing' => 'required'
        ]);

      $user = Auth::User();
      $user->date_departing = $request['date_departing'];
      $user->update();

      return redirect()->back();
    }

    public function postTimeDeparting(Request $request) 
    {
      $this->validate($request, [
          'time_departing' => 'required'
        ]);

      $user = Auth::User();
      $user->time_departing = $request['time_departing'];
      $user->update();

      return redirect()->back();
    }

    public function getSearchInventory()
    {
      // get the q parameter from URL
      $q = $_GET["q"];
      $hint = "";

      // lookup all hints from array if $q is different from ""
      if ($q !== "") {
      $q = strtolower($q);
      $len=strlen($q);
        foreach(Auth::User()->school->items as $item) {
          if (stristr($q, substr($item->name, 0, $len))) {
              if ($hint === "") {
                  $hint = '
                  <div class="col-md-6">
                    <div class="panel panel-primary" style="border-radius: 5px;">
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-8">
                            <a href="'. route('get.item', [Auth::User()->school->username, $item->inventory->name, $item->name]) .'">'. $item->name . '</a>
                            <p>In stock: ' . $item->stock . '</p>
                          </div><!-- .col-md-8 -->
                        </div><!-- .row -->
                      </div><!-- .panel-body -->
                    </div><!-- .panel -->
                  </div><!-- .col-md-6 -->
                  ';
              } else {
                $hint .= '
                <div class="col-md-6">
                  <div class="panel panel-primary" style="border-radius: 5px;">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-8">
                          <a href="'. route('get.item', [Auth::User()->school->username, $item->inventory->name, $item->name]) .'">'. $item->name . '</a>
                          <p>In stock: ' . $item->stock . '</p>
                        </div><!-- .col-md-8 -->
                      </div><!-- .row -->
                    </div><!-- .panel-body -->
                  </div><!-- .panel -->
                </div><!-- .col-md-6 -->
                ';
              }
          }
        }
      }

      // Output "no suggestion" if no hint was found or output correct values
      if($hint == '') {
        $hint = '<p class="text-center" style="font-style: italic; color: grey;">No results were found. <a href="'. route('get.inventories', Auth::User()->school->username) .'">Back to invetories</a></p><hr>';
        echo $hint;
      } else {
        echo $hint;
      }

    }

    public function getExportInventory($school_username, $inventory_name)
    {
      $inventory = Inventory::where('name', $inventory_name)->first();

      $attributes_array = array('Name', 'Stock', 'Cost');
      foreach($inventory->attributes as $attribute) {
        array_push($attributes_array, $attribute->name);
      }

      $data = array($attributes_array);

      foreach($inventory->items as $item) {
        $item_array = array($item->name, $item->stock, $item->cost);
        foreach($item->itemAttributes as $item_attribute) {
          array_push($item_array, $item_attribute->value);
        }
        array_push($data, $item_array);
      }

      Excel::create($inventory->name, function($excel) use($data) {

      $excel->sheet('Stock', function($sheet) use($data) {

      $sheet->fromArray($data);

      });

      })->export('xls');
    }

    public function getExportInventories()
    {
      return 'hi';
      /*Excel::create("Inventories", function($excel) {

      foreach(Auth::User()->school->inventories as $inventorry) {

        $excel->sheet($inventory->name, function($sheet) use($data) {

        $sheet->fromArray(array('hi'));

        });

      }

      })->export('xls');*/
    }
}
