<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    // Retrieve all menu items and return them as a JSON response
    public function index()
    {
        $menuItems = MenuItem::with('restaurant')->get();
        return response()->json($menuItems);
    }
    
    public function getget()
    {
        echo 'hgfhgfhgfhgfh';
    }

    

    // Validate the incoming request, create a new menu item, and return a success message along with the created menu item as a JSON response
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'availability' => 'required|boolean',
        ]);

        $menuItem = new MenuItem();
        $menuItem->restaurant_id = $request->restaurant_id;
        $menuItem->name = $request->name;
        $menuItem->description = $request->description;
        $menuItem->price = $request->price;
        $menuItem->image_url = $request->image_url;
        $menuItem->availability = $request->availability;
        $menuItem->save();

        return response()->json(['message' => 'Menu item created successfully', 'menu_item' => $menuItem], 201);
    }

    // Retrieve a specific menu item by their ID and return it as a JSON response
    public function show(MenuItem $menuItem)
    {
        $menuItem->load('restaurant');
        return response()->json($menuItem);
    }

    // Validate the incoming request, update the specified menu item, and return a success message along with the updated menu item as a JSON response
    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'name' => 'sometimes|required',
            'description' => 'sometimes|required',
            'price' => 'sometimes|required|numeric|min:0',
            'image_url' => 'nullable|url',
            'availability' => 'sometimes|required|boolean',
        ]);

        if ($request->has('name')) {
            $menuItem->name = $request->name;
        }

        if ($request->has('description')) {
            $menuItem->description = $request->description;
        }

        if ($request->has('price')) {
            $menuItem->price = $request->price;
        }

        if ($request->has('image_url')) {
            $menuItem->image_url = $request->image_url;
        }

        if ($request->has('availability')) {
            $menuItem->availability = $request->availability;
        }

        $menuItem->save();

        return response()->json(['message' => 'Menu item updated successfully', 'menu_item' => $menuItem]);
    }

    // Delete the specified menu item and return a success message as a JSON response
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return response()->json(['message' => 'Menu item deleted successfully']);
    }
}

