<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\AdvertisementImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sort_field' => 'nullable|in:created_at',
            'sort_order' => 'nullable|in:asc,desc',
            'per_page' => ['nullable', 'integer', 'between:1,20',],
            'page' => [
                'nullable',
                'integer',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $sortField = $request->input('sort_field', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $perPage = $request->input('per_page', 10);

        // Retrieve advertisements with sorting, pagination, and eager loading of images
        $query = Advertisement::with('images')->orderBy($sortField, $sortOrder);
        $advertisements = $query->paginate($perPage);

        if (!in_array($sortField, ['created_at', 'price'])) {
            return response()->json(['error' => 'Invalid sort field'], 400);
        }

        $transformedData = $advertisements->map(function ($advertisement) {
            $imageUrls = $advertisement->images->pluck('url')->toArray();
            $mainUrl = array_shift($imageUrls);

            return [
                "url" => $mainUrl,
                'title' => $advertisement->title,
                'price' => $advertisement->price,
                'image_urls' => $imageUrls,
            ];
        });

        $response = [
            'data' => $transformedData,
            'meta' => [
                'total' => $advertisements->total(),
                'per_page' => $advertisements->perPage(),
                'current_page' => $advertisements->currentPage(),
                'last_page' => $advertisements->lastPage(),
            ],
            'status' => 'ok',
        ];

        return response()->json($response);
    }

    public function show(Request $request, $id)
    {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            return response()->json(['error' => 'Advertisement not found'], 404);
        }


        $imageUrls = $advertisement->images->pluck('url')->toArray();
        $mainUrl = array_shift($imageUrls);



        $response = [
            'data' => [
                'title' => $advertisement->title,
                'price' => $advertisement->price,
                'url' => $mainUrl,
            ],
            'meta' => [
                'timestamp' => round(microtime(true) * 1000),
            ],
            'status' => 'ok',
        ];

        $fields = $request->input('fields');
        if ($fields) {
            $fieldArray = explode(',', $fields);
            foreach ($fieldArray as $field) {
                if ($field === 'descr') {
                    $response['data']['description'] = $advertisement->description;
                }
                if ($field === 'images') {
                    $response['data']['image_urls'] = $imageUrls;
                }
            }
        }



        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'description' => 'required|max:1000',
            'price' => 'required|numeric',
            'image_urls' => 'required|array|min:1|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Extract data from the request
        $title = $request->input('title');
        $description = $request->input('description');
        $price = $request->input('price');

        // dd($title);

        // Create a new advertisement with the extracted data
        $advertisement = new Advertisement([
            'title' => "asdasd",
            'description' => $description,
            'price' => $price,
        ]);

        $advertisement->save();


        // Store image URLs in advertisement_images table
        $imageUrls = $request->input('image_urls');

        foreach ($imageUrls as $imageUrl) {
            $image = new AdvertisementImage([
                'advertisement_id' => $advertisement->id,
                'url' => $imageUrl,
            ]);

            $image->save();
        }

        return response()->json(['message' => 'Advertisement created', 'id' => $advertisement->id], 201);
    }
}
