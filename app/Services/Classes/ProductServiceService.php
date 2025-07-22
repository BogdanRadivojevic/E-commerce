<?php

namespace App\Services\Classes;

use App\Models\ProductService;
use App\Notifications\ServiceRepairedNotification;
use App\QueryBuilder\ProductServiceQueryBuilder;
use App\Services\Interfaces\IProductServiceService;
use Illuminate\Http\Request;

class ProductServiceService implements IProductServiceService
{
    public function getFilteredServices(Request $request)
    {
        // Create the query builder for ProductService
        $queryBuilder = new ProductServiceQueryBuilder();

        // Apply filters (including the auth_user filter) and sorting
        $query = $queryBuilder
            ->applyFilters($request)
            ->getQuery();


        // Return paginated results
        return $query->paginate(12);
    }

    public function createService(array $data): ProductService
    {
        $service = new ProductService();

        $service->device_name = $data['device_name'];
        $service->issue_description = $data['issue_description'];
        $service->auth_user_id = auth()->id(); // Set the authenticated user's ID
        $service->service_user_id = $data['service_user_id']; // Set the selected user's ID from the input

        $service->save();

        return $service;
    }
    public function updateService(ProductService $service, array $data): ProductService
    {
        $service->device_name = $data['device_name'];
        $service->issue_description = $data['issue_description'];

        $service->save();

        return $service;
    }

    public function deleteService(ProductService $service): void
    {
        $service->delete();
    }

    public function finishService(ProductService $service, $validate): void{
        $service->status = ProductService::STATUS_REPAIRED;
        $service->price = $validate;

        $service->save();
        // todo: add this to the order
        $user = $service->serviceUser;

        if ($user) {
            $user->notify(new ServiceRepairedNotification($service));
        }
    }

    public function countService(): int
    {
        return ProductService::count();
    }

    public function getServices(){
        // Get all services
        return ProductService::all();
    }
}
