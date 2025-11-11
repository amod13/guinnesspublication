<?php
namespace App\Modules\Publication\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Publication\Enums\MenuTypeEnum;
use App\Modules\Publication\Models\Menu;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    protected $pageService;
    public function __construct(PageServiceInterface $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        $menus = collect(); // An empty collection
        $unassignedMenus = collect(); // Empty collection for unassigned items
        $selected_menu_type_id = $menuTypeId ?? null;
        $menuTypes = MenuTypeEnum::getMenuTypes();
        $pages = $this->pageService->getActivePages();
        // dd($pages);

        return view('publication::admin.menu.index', compact('menus', 'menuTypes', 'selected_menu_type_id', 'unassignedMenus', 'pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string',
            'parent_id' => 'nullable|exists:menus,id',
            'position' => 'nullable|integer',
            'status' => 'nullable|integer',
            'menu_type_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_mega_menu' => 'nullable|in:0,1',
            'description' => 'nullable|string',
            'blockquote' => 'nullable|string',
            'menu_icon' => 'nullable|string',
            'is_thematic' => 'nullable|in:0,1',
            'page_id' => 'nullable|exists:pages,id',
            'slug' => 'nullable|string|unique:menus,slug',
            'language' => 'nullable|string|max:10',
        ]);

        // Check if trying to set is_thematic = 1 when another already exists
        if ($request->input('is_thematic') == 1) {
            $existingThematic = Menu::where('menu_type_id', $request->menu_type_id)
                ->where('is_thematic', 1)
                ->exists();

            if ($existingThematic) {
                return back()->withErrors(['is_thematic' => 'Only one thematic menu is allowed per menu type.']);
            }
        }

        // Collect validated data
        $data = $request->only([
            'title',
            'url',
            'parent_id',
            'position',
            'page_id',
            'status',
            'menu_type_id',
            'is_mega_menu',
            'description',
            'blockquote',
            'menu_icon',
            'is_thematic',
            'slug',
            'language',
        ]);

        $data['language'] = session('language', 'en');
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_image.' . $imageExtension;

            $imageDirectory = public_path('uploads/menu/');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            $image->move($imageDirectory, $imageFilename);

            // Save the filename
            $data['image'] = $imageFilename;
        }

        // Set position to bottom of menu structure and make it visible
        $maxPosition = Menu::where('menu_type_id', $request->menu_type_id)
            ->whereNull('parent_id')
            ->where('is_display_web', 1)
            ->max('position') ?? 0;
        $data['position'] = $maxPosition + 1;
        $data['is_display_web'] = 1; // Automatically add to menu structure


        $menu = Menu::create($data);

        // If AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'menu' => $menu,
                'message' => 'Menu item created successfully'
            ]);
        }

        return redirect()->route('menu.index')->with('success', 'Menu item created successfully');
    }

    public function update(Request $request, $id)
    {
        // Check if this is a drag and drop update (only parent_id)
        if ($request->has('parent_id') && !$request->has('title')) {
            $menu = Menu::findOrFail($id);
            $updateData = [
                'parent_id' => $request->input('parent_id'),
                'position' => $request->input('position', $menu->position)
            ];

            // Handle is_display_web field if provided
            if ($request->has('is_display_web')) {
                $updateData['is_display_web'] = $request->input('is_display_web');
            }

            $menu->update($updateData);
            return response()->json(['success' => true]);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'url' => 'nullable|url',
            'parent_id' => 'nullable|exists:menus,id',
            'position' => 'nullable|integer',
            'status' => 'sometimes|integer',
            'menu_type_id' => 'sometimes|required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_mega_menu' => 'nullable|in:0,1',
            'description' => 'nullable|string',
            'blockquote' => 'nullable|string',
            'menu_icon' => 'nullable|string',
            'is_thematic' => 'nullable|in:0,1',
            'page_id' => 'nullable|exists:pages,id',
            'slug' => 'nullable|string|unique:menus,slug,' . $id,
            'language' => 'nullable|string|max:10',
        ]);


        $menu = Menu::findOrFail($id);

        // Check if trying to set is_thematic = 1 when another already exists
        if ($request->input('is_thematic') == 1 && $menu->is_thematic != 1) {
            $existingThematic = Menu::where('menu_type_id', $request->menu_type_id ?: $menu->menu_type_id)
                ->where('is_thematic', 1)
                ->where('id', '!=', $id)
                ->exists();

            if ($existingThematic) {
                return back()->withErrors(['is_thematic' => 'Only one thematic menu is allowed per menu type.']);
            }
        }

        // Collect validated data - preserve existing parent_id if not explicitly changed
        $data = $request->only([
            'title',
            'url',
            'position',
            'status',
            'menu_type_id',
            'is_mega_menu',
            'description',
            'blockquote',
            'menu_icon',
            'is_thematic',
            'page_id',
            'slug',
            'language',
        ]);

        $data['language'] = session('language', 'en');
        // Don't update parent_id through normal edit form - only through drag & drop
        // This preserves the existing parent-child relationships

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_image.' . $imageExtension;

            $imageDirectory = public_path('uploads/menu/');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Delete old image if exists
            if ($menu->image && file_exists($imageDirectory . $menu->image)) {
                unlink($imageDirectory . $menu->image);
            }

            // Save new image
            $image->move($imageDirectory, $imageFilename);
            $data['image'] = $imageFilename;
        }

        // Preserve existing position if not provided or is 0
        if (!isset($data['position']) || $data['position'] == 0) {
            $data['position'] = $menu->position;
        }

        $menu->update($data);

        return redirect()->route('menu.search')
            ->withInput([
                'menu_type_id' => $request->menu_type_id
            ])
            ->with('success', 'Menu item updated successfully');
    }

    public function delete($id)
    {
        $menu = Menu::find($id);

        if ($menu) {
            // Delete image if exists
            if ($menu->image) {
                $imageDirectory = public_path('uploads/menu/');
                if (file_exists($imageDirectory . $menu->image)) {
                    unlink($imageDirectory . $menu->image);
                }
            }

            $menu->delete();
            return response()->json(['success' => 'Menu item deleted successfully'], 200);
        }

        return response()->json(['error' => 'Menu item not found'], 404);
    }


    public function updateOrder(Request $request)
    {
        $menuOrder = json_decode($request->menuOrder, true);

        foreach ($menuOrder as $item) {
            $menu = Menu::find($item['id']);

            if ($menu) {
                $updateData = [
                    'parent_id' => $item['parent_id'],
                    'position' => $item['position']
                ];

                // Handle is_display_web field if provided
                if (isset($item['is_display_web'])) {
                    $updateData['is_display_web'] = $item['is_display_web'];
                }

                $menu->update($updateData);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Menu order updated successfully']);
    }


    public function getMenuSearchByMenuTypeIdAndCompanyIdBase(Request $request)
    {
        // Get the search parameters from POST, GET, or old input
        $menuTypeId = $request->input('menu_type_id') ?: old('menu_type_id');

        // Get organized menu structure (items with is_display_web = 1)
        $menus = collect();
        if ($menuTypeId) {
            $query = Menu::where('menu_type_id', $menuTypeId)
                ->where('language', session('language', 'en'))
                ->where('is_display_web', 1);

            $menus = $query->orderBy('position')->get();
        }
        $pages = $this->pageService->getActivePages();

        // No unassigned items needed anymore
        $unassignedMenus = collect();

        $parents = Menu::where(function ($query) {
            $query->whereNull('parent_id')
                ->where('language', session('language', 'en'))
                ->orWhereNotNull('parent_id');
        })->get();

        $menuTypes = MenuTypeEnum::getMenuTypes();

        $selected_menu_type_id = $menuTypeId ?? null;


        return view('publication::admin.menu.index', compact('menus', 'parents', 'menuTypes', 'selected_menu_type_id', 'unassignedMenus', 'pages'));
    }

}
