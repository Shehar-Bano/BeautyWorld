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
        $deal->type = $validatedData['type'];

        // If the type is 'duration', also save the duration
        if ($validatedData['type'] == 'duration') {
            $deal->duration = $validatedData['duration'];
        }

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
        $deal = Deal::find($id);
        $deal->name = $validatedData['name'];
        $deal->description = $validatedData['description'];
        $deal->dis_price = $validatedData['dis_price'];
        $deal->type = $validatedData['type'];

        // If the type is 'duration', also save the duration
        if ($validatedData['type'] == 'duration') {
            $deal->duration = $validatedData['duration'];
        }
        $deal->save();
        foreach ($validatedData['services'] as $serviceId) {
            if (DealService::where('deal_id', $id)) {
                DealService::find('$id')->update([
                    'service_id' => $serviceId, // Correctly assign service_id
                ]);
            }

        }

        return $deal;
    }

    public function deleteDeal($id)
    {
        return Deal::destroy($id);
    }

}
