<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\User;
use App\QueryBuilder\ProductServiceQueryBuilder;
use App\Services\IProductServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $productService;

    public function __construct(IProductServiceService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        // Use the service to fetch filtered services
        $services = $this->productService->getFilteredServices($request);


        return view('services.index', compact('services'));
    }

    public function show(ProductService $service)
    {
        return view('services.show', compact('service'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'device_name' => 'required|string|max:255',
            'issue_description' => 'required|string',
            'service_user' => 'required|string|exists:users,name', // Validate that the user exists by name
        ]);

        // Fetch the user by name for the service_user_id
        $user = User::where('name', $validated['service_user'])->first();

        // Add the user_id (authenticated user) and service_user_id (selected user) to the validated data
        $validated['auth_user_id'] = auth()->id();  // authenticated user
        $validated['service_user_id'] = $user->id; // selected user

        // Use the service to create the service
        $this->productService->createService($validated);


        return redirect()->route('service.index')->with('success', 'Service created successfully!');
    }


    public function edit(ProductService $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, ProductService $service)
    {
        // Validate the request
        $validated = $request->validate([
            'device_name' => 'required|string|max:255',
            'issue_description' => 'required|string',
        ]);

        // Use the service to update the service
        $this->productService->updateService($service, $validated);

        return redirect()->route('service.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(ProductService $service)
    {
        // Use the service to delete the service
        $this->productService->deleteService($service);

        return redirect()->route('service.index')->with('success', 'Service deleted successfully!');
    }

    public function editFinish(Request $request, ProductService $service){
//        $service = ProductService::find($request->service_id);
        return view('services.edit_finish', compact('service'));
    }

    public function finish(Request $request, ProductService $service){

        $validate = $request->validate([
            'price' => 'required|numeric|min:0', // Ensure the price is valid
        ]);

        $this->productService->finishService($service, $validate['price']);

        return redirect()->route('service.index')->with('success', 'Service marked as finished!');
    }
}
