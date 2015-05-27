<?php

namespace Expose\Http\Controllers;

use Carbon\Carbon;
use Expose\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use InfluxDB\Exception\InfluxNoSeriesException;

class AppController extends Controller
{
    public function getDashboard()
    {
        /**
         * @var $client \InfluxDB\Client
         */
        $client      = app()->make('influxdb');
        $annotations = [];

        try {
            $result = $client->query('select time, title, text, categories, __user_id from events limit 15');

            $annotations = $result['events'];
        } catch (InfluxNoSeriesException $e) {
            $annotations = [];
        }

        foreach ($annotations as &$annotation) {
            $annotation['data'] = json_encode($annotation); // Store before we do anything

            $user = User::find($annotation['__user_id']);

            $annotation['poster'] = (!$user) ? "Unknown" : $user->name;

            $annotation['time'] = Carbon::createFromTimestamp($annotation['time'] / 1000)->diffForHumans();
        }

        return view('dashboard')->with('annotations', $annotations);
    }

    public function postAnnotation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'text'       => 'required',
            'categories' => ''
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => true,
                'errors'  => $validator->errors()->getMessageBag()
            ]);
        }

        /**
         * @var $client \InfluxDB\Client
         */
        $client = app()->make('influxdb');

        $client->mark('events', [
            'title'      => $request->get('title'),
            'text'       => $request->get('text'),
            'categories' => $request->get('categories'),
            '__user_id'  => \Auth::user()->id,
        ]);

        return response()->json(["success" => true]);
    }
}