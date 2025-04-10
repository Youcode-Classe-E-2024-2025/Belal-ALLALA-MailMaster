<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Subscribers",
 *     description="Operations related to subscribers"
 * )
 */
class SubscriberController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/subscribers",
     *      operationId="getSubscribersList",
     *      tags={"Subscribers"},
     *      summary="Get list of subscribers",
     *      description="Returns list of subscribers with pagination.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Subscriber")
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
        $subscribers = Subscriber::paginate(10);
        return response()->json($subscribers);
    }

    /**
     * @OA\Post(
     *      path="/api/subscribers",
     *      operationId="createSubscriber",
     *      tags={"Subscribers"},
     *      summary="Create a new subscriber",
     *      description="Creates a new subscriber.",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Subscriber")
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
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subscriber = Subscriber::create($request->all());

        return response()->json($subscriber, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/subscribers/{subscriber}",
     *      operationId="getSubscriberById",
     *      tags={"Subscribers"},
     *      summary="Get subscriber information",
     *      description="Returns subscriber data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="subscriber",
     *          description="Subscriber id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Subscriber")
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
    public function show(Subscriber $subscriber)
    {
        return response()->json($subscriber);
    }

    /**
     * @OA\Put(
     *      path="/api/subscribers/{subscriber}",
     *      operationId="updateSubscriber",
     *      tags={"Subscribers"},
     *      summary="Update existing subscriber",
     *      description="Updates an existing subscriber",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="subscriber",
     *          description="Subscriber id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Subscriber")
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
    public function update(Request $request, Subscriber $subscriber)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:subscribers,email,' . $subscriber->id,
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subscriber->update($request->all());

        return response()->json($subscriber);
    }

    /**
     * @OA\Delete(
     *      path="/api/subscribers/{subscriber}",
     *      operationId="deleteSubscriber",
     *      tags={"Subscribers"},
     *      summary="Delete subscriber",
     *      description="Deletes a subscriber record",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="subscriber",
     *          description="Subscriber id",
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
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(@OA\Property(property="message", type="string", example="Unauthorized"))
     *      )
     *  )
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return response()->json(null, 204);
    }
}