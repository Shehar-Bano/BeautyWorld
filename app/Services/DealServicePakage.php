<?php
namespace App\Services;

use App\Models\Deal;
use App\Models\Service;
use App\Models\DealService;
use Illuminate\Support\Facades\Request;

class DealServicePakage
{
    public function getDeals()
    {
        return Deal::with('dealService')->get();

    }


    public function createDeal()
    {
        return Service::all();

    }
    public function storeDeal($validatedData)
    {
        // Create and save the Deal
        $deal = new Deal();
        $deal->name = $validatedData['name'];
        $deal->description = $validatedData['description'];
        $deal->dis_price = $validatedData['dis_price'];

        // Save the Deal
        $deal->save();

        // Store services in the deal_service table
        foreach ($validatedData['services'] as $serviceId) {
            DealService::create([
                'deal_id' => $deal->id, // Correctly assign deal_id
                'service_id' => $serviceId, // Correctly assign service_id
            ]);
        }

        return $deal; // Return the created deal
    }
    public function editDeal($id)
    {
        return Deal::find($id);
    }

    public function updateDeal($id, $validatedData)
    {
        // Find the existing Deal by ID
        $deal = Deal::find($id);

        // Update Deal details
        $deal->name = $validatedData['name'];
        $deal->description = $validatedData['description'];
        $deal->dis_price = $validatedData['dis_price'];
        
        // Save the Deal updates
        $deal->save();

        // Sync the selected services in the deal_services table
        if (isset($validatedData['services'])) {
            $deal->services()->sync($validatedData['services']); // Sync services in deal_services table
        } else {
            // If no services are selected, detach all services
            $deal->services()->detach();
        }

        return $deal; // Return the updated deal
    }





    public function deleteDeal($id)
    {
        return Deal::destroy($id);
    }

}
