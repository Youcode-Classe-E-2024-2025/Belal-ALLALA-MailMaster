<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Newsletters",
 *     description="Operations related to newsletters"
 * )
 */
class NewsletterController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/newsletters",
     *      operationId="getNewslettersList",
     *      tags={"Newsletters"},
     *      summary="Get list of newsletters",
     *      description="Returns list of newsletters with pagination.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Newsletter")
     *              ),
     *              @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *              @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized")
     *          )
     *      )
     *  )
     */
    public function index()
    {
        $newsletters = Newsletter::paginate(10);
        return response()->json($newsletters);
    }

    /**
     * @OA\Post(
     *      path="/api/newsletters",
     *      operationId="createNewsletter",
     *      tags={"Newsletters"},
     *      summary="Create a new newsletter",
     *      description="Creates a new newsletter.",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Newsletter")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Newsletter")
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $newsletter = Newsletter::create($request->all());

        return response()->json($newsletter, 201);
    }

    /**
     * @OA\Get(
     *      path="/api/newsletters/{newsletter}",
     *      operationId="getNewsletterById",
     *      tags={"Newsletters"},
     *      summary="Get newsletter information",
     *      description="Returns newsletter data",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="newsletter",
     *          description="Newsletter id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Newsletter")
     *      ),
     *      @OA\Response(
     *          response="404",
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
    public function show(Newsletter $newsletter)
    {
        return response()->json($newsletter);
    }

    /**
     * @OA\Put(
     *      path="/api/newsletters/{newsletter}",
     *      operationId="updateNewsletter",
     *      tags={"Newsletters"},
     *      summary="Update existing newsletter",
     *      description="Updates an existing newsletter",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="newsletter",
     *          description="Newsletter id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Newsletter")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Newsletter")
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
    public function update(Request $request, Newsletter $newsletter)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'content' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $newsletter->update($request->all());

        return response()->json($newsletter);
    }

    /**
     * @OA\Delete(
     *      path="/api/newsletters/{newsletter}",
     *      operationId="deleteNewsletter",
     *      tags={"Newsletters"},
     *      summary="Delete newsletter",
     *      description="Deletes a newsletter record",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="newsletter",
     *          description="Newsletter id",
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
     *          response="403",
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
    public function destroy(Newsletter $newsletter)
    {
        $this->authorize('delete', $newsletter);

        $newsletter->delete();
        return response()->json(null, 204);
    }
}