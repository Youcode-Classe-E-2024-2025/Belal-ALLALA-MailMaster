<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Newsletter; // Assurez-vous d'importer le modèle Newsletter
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::paginate(10);
        return response()->json($campaigns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newsletter_id' => 'required|exists:newsletters,id', // Vérifie que newsletter_id existe dans la table newsletters
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'status' => 'in:draft,pending,sent,failed', // Validation pour le statut (enum)
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign = Campaign::create($request->all());

        return response()->json($campaign, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return response()->json($campaign);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'newsletter_id' => 'exists:newsletters,id', // Pas obligatoire à la mise à jour, mais doit exister si fourni
            'title' => 'string|max:255',
            'subject' => 'string|max:255',
            'status' => 'in:draft,pending,sent,failed', // Validation pour le statut (enum)
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->update($request->all());

        return response()->json($campaign);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $newsletter);
        $campaign->delete();

        return response()->json(null, 204);
    }
}