<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\StorePropertyRequest;
use Illuminate\Http\JsonResponse;
use App\Services\PropertyService;
class PropertyController extends Controller
{
    protected $propertyService;
    /**
     * Initialize the Property Service in Constructor.
     *
     */
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }
    /**
     * Display a listing of the property.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->propertyService->getUserPropertyList();
        return $this->getApiResponse();
    }

    /**
     * Display the specified property.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $this->propertyService->getProperty($id);
        return $this->getApiResponse();
    }
    /**
     * Store a newly created property in storage.
     * @param StorePropertyRequest $request
     * @return JsonResponse
     */
    public function store(StorePropertyRequest $request): JsonResponse
    {
        $this->propertyService->propertyStore($request);
        return $this->getApiResponse();
    }

    /**
     * Update the specified property in storage.
     *
     * @param StorePropertyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StorePropertyRequest $request, int $id): JsonResponse
    {
        $this->propertyService->propertyUpdate($request,$id);
        return $this->getApiResponse();
    }
    /**
     * Remove the specified property from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->propertyService->destroy($id);
        return $this->getApiResponse();
    }
    /**
     * Get all Property Types.
     *
     * @return JsonResponse
     */
    public function getPropertyTypes(): JsonResponse
    {
        $this->propertyService->getPropertyTypes();
        return $this->getApiResponse();
    }
    /**
     * Get all Property Area Units.
     *
     * @return JsonResponse
     */
    public function getPropertyAreaUnits(): JsonResponse
    {
        $this->propertyService->getPropertyAreaUnits();
        return $this->getApiResponse();
    }
}
