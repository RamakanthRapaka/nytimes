<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BestSeller;
use App\Models\BestSellerBook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNyTime;
use Illuminate\Support\Facades\Validator;

class BestSellerController extends Controller
{
    public function create()
    {
        $url = env('NY_TIMES_BEST_SELLER_URL');
        $api_token = env('NY_TIMES_API_TOKEN');

        $response = Http::get($url, [
            'api-key' => $api_token
        ]);

        if ($response->successful()) {
            $data = json_decode($response, true);

            BestSeller::truncate();
            BestSellerBook::truncate();

            try {
                DB::beginTransaction();

                foreach ($data['results']['lists'] as $list) {
                    BestSeller::create([
                        'list_id' => $list['list_id'],
                        'list_name' => $list['list_name'],
                        'bestsellers_date' => $data['results']['bestsellers_date'],
                    ]);
                    foreach ($list['books'] as $book) {
                        BestSellerBook::create([
                            'list_id' => $list['list_id'],
                            'title' => $book['title'],
                            'author' => $book['author'],
                            'book_rank' => $book['rank'],
                            'weeks_on_list' => $book['weeks_on_list'],
                            'image' => $book['book_image'],
                            'buy_links' => json_encode($book['buy_links']),
                        ]);
                    }
                }
                DB::commit();
                return response()->json([
                    'message' => 'Best Sellers Books Updated!',
                    'status_code' => Response::HTTP_OK
                ]);
            } catch(Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Internal Server Error!',
                    'status_code' => 500
                ]);
            }
        }
    }

    public function topthreebooks()
    {
        try {
            $results = null;
            $top_best_sellers = BestSeller::with(['books' => function ($query) {
                $query->take(9)->orderBy('book_rank', 'asc')->get();
            }])->orderBy('list_id', 'desc')->take(3)->get()->toArray();

            foreach ($top_best_sellers as $top_best_seller) {
                foreach ($top_best_seller['books'] as $book) {
                    $book['list_name'] = $top_best_seller['list_name'];
                    $results[] = $book;
                }
            }

            return response()->json([
                'data' => $results,
                'message' => 'Best Sellers Books!',
                'status_code' => Response::HTTP_OK
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error!',
                'status_code' => 500
            ]);
        }
    }

    public function sendEmail()
    {
        try {
            $email = 'ramakanth.rapaka@gmail.com';

            $top_best_sellers = BestSeller::with(['books' => function ($query) {
                $query->take(9)->orderBy('book_rank', 'asc')->get();
            }])->orderBy('list_id', 'desc')->take(3)->get()->toArray();

            foreach ($top_best_sellers as $top_best_seller) {
                foreach ($top_best_seller['books'] as $book) {
                    $book['list_name'] = $top_best_seller['list_name'];
                    $results[] = $book;
                }
            }

            $mailData = [
                'title' => 'Ny Times Top Three Books Of The Week!',
                'url' => 'https://developer.nytimes.com',
                'results' => $results
            ];

            Mail::to($email)->send(new EmailNyTime($mailData));

            return 200;
        } catch(Exception $e) {
            return 500;
        }
    }

    public function getbookbyid(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors(), 'status_code' => 422]);
            }

            $book = BestSellerBook::with('list')->where('id', $request->input('id'))->get()->toArray();

            return response()->json([
                'data' => $book,
                'message' => 'Best Sellers Books!',
                'status_code' => Response::HTTP_OK
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal Server Errors!',
                'status_code' => 500
            ]);
        }
    }

    public function updatebookbyid(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'list_name' => 'required|string|max:50',
                'book_name' => 'required|string|max:50',
                'author' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors(), 'status_code' => 422]);
            }
            $book = BestSellerBook::with('list')->where('id', $request->input('id'))->get()->toArray();
            $book = $book[0];

            DB::beginTransaction();

            BestSellerBook::where('id', $request->input('id'))->update([
                'title' => $request->input('book_name'),
                'author' => $request->input('author'),
             ]);

            BestSeller::where('id', $book['list']['id'])->update([
               'list_name' => $request->input('list_name')
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Book Details Updated!',
                'status_code' => Response::HTTP_OK
            ]);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal Server Errors!',
                'status_code' => 500
            ]);
        }
    }
}
