<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Campaigns",
 *     description="Operations related to campaigns"
 * )
 */
class CampaignController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/campaigns",
     *      operationId="getCampaignsList",
     *      tags={"Campaigns"},
     *      summary="Get list of campaigns",
     *      description="Returns list of campaigns with pagination.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Campaign")
     *              ),
     *              @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *              @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function index()
    {
        $campaigns = Campaign::paginate(10);
        return response()->json($campaigns);
    }

    /**
     * @OA\Post(
     *      path="/api/campaigns",
     *      operationId="createCampaign",
     *      tags={"Campaigns"},
     *      summary="Create a new campaign",
     *      description="Creates a new campaign.",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newsletter_id' => 'required|exists:newsletters,id',
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'status' => 'in:draft,pending,sent,failed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign = Campaign::create($request->all());

        return response()->json($campaign, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/campaigns/{campaign}",
     *      operationId="getCampaignById",
     *      tags={"Campaigns"},
     *      summary="Get campaign information",
     *      description="Returns campaign data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="campaign",
     *          description="Campaign id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Resource Not Found"))
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function show(Campaign $campaign)
    {
        return response()->json($campaign);
    }

    /**
     * @OA\Put(
     *      path="/api/campaigns/{campaign}",
     *      operationId="updateCampaign",
     *      tags={"Campaigns"},
     *      summary="Update existing campaign",
     *      description="Updates an existing campaign",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="campaign",
     *          description="Campaign id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Resource Not Found"))
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'newsletter_id' => 'exists:newsletters,id',
            'title' => 'string|max:255',
            'subject' => 'string|max:255',
            'status' => 'in:draft,pending,sent,failed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign->update($request->all());

        return response()->json($campaign);
    }

    /**
     * @OA\Delete(
     *      path="/api/campaigns/{campaign}",
     *      operationId="deleteCampaign",
     *      tags={"Campaigns"},
     *      summary="Delete campaign",
     *      description="Deletes a campaign record",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="campaign",
     *          description="Campaign id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Resource Not Found"))
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Forbidden"))
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *      path="/api/campaigns/{campaign}/send",
     *      operationId="sendCampaign",
     *      tags={"Campaigns"},
     *      summary="Send a campaign",
     *      description="Sends a specific campaign to subscribers.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="campaign",
     *          description="Campaign id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Campaign sending started"))
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Campaign not found"))
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function send(Campaign $campaign)
    {
        if ($campaign->status !== 'draft') {
            return response()->json(['message' => 'Campaign must be in draft status to be sent.'], 400);
        }

        $subscribers = Subscriber::all(); 

        $newsletterContent = $campaign->newsletter->content;

        foreach ($subscribers as $subscriber) {
            Mail::raw($newsletterContent, function ($message) use ($subscriber, $campaign) { 
                $message->to($subscriber->email)
                        ->subject($campaign->subject);
            });
        }

        $campaign->status = 'pending'; 
        $campaign->sent_at = now();
        $campaign->save();

        return response()->json(['message' => 'Campaign sending started to ' . $subscribers->count() . ' subscribers.']);
    }

    /**
     * @OA\Get(
     *      path="/api/campaigns/{campaign}/preview",
     *      operationId="previewCampaign",
     *      tags={"Campaigns"},
     *      summary="Preview a campaign",
     *      description="Returns the content of a campaign for preview.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="campaign",
     *          description="Campaign id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(@OA\Property(property="content", type="string", example="HTML content of the newsletter"))
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Campaign not found"))
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function preview(Campaign $campaign)
    {
        return response()->json(['content' => $campaign->newsletter->content]); 
    }
}