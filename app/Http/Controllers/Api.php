<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\MovieIdRequest;
use App\Http\Requests\NameRequest;
use Illuminate\Routing\Controller;
use Ixudra\Curl\Facades\Curl;

class Api extends Controller
{
    /**
     * Метод подтягивает список городов и перезаписывает их в базу
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCityList()
    {
        $key = config('app.key_kinoafisha');
        if ($key === null) {
            return response()->json(['error' => 404, 'message' => 'Ключ не задан'], 404);
        }
        $url = "https://api.kinoafisha.info/export/cities?api_key=$key";

        $response = Curl::to($url);

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        City::truncate();
        
        $cityList = json_decode($response->get());
        dd($cityList);
        if(isset($cityList['cities'])){
            foreach ($cityList['cities'] as $cityObj) {
                $city = new City;
                foreach ($cityObj as $key => $item) {
                    $city->{$key} = $item;
                }
                $city->save();
            }

            return response('OK', 200);
        } else {
            return response(dd($cityList);, 500);
        }
    }

    /**
     * Метод возвращает код города из нашей базы который соответствует коду из сервиса kinohod
     * @param NameRequest $request
     * @return array
     */
    public function getCode(NameRequest $request)
    {
        $city = City::where('name', 'like', '%' . $request->name . '%');
        $city = $city->first();

        if ($city === null) {
            return response()->json(['error' => 404, 'message' => 'Not found'], 404);
        }

        return $city->getCode();
    }

    /**
     * Метод возвращает список фильмов с краткой ифнормацие по коду города
     * @param CodeRequest $request
     * @return array
     */
    public function getSchedule(CodeRequest $request)
    {
        $key = config('app.key_kinoafisha');
        if ($key === null) {
            return response()->json(['error' => 404, 'message' => 'Ключ не задан'], 404);
        }
        $url = "https://api.kinoafisha.info/export/schedule?api_key=$key&city=" . $request->city . ($request->date_end !== null ? '&date_end=' . $request->date_end : '');

        $response = Curl::to($url);

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        $response = $response->returnResponseObject()->get();

        if ($response->status !== 200) {
            return response()->json(['error' => $response->status], $response->status);
        }

        $schedules = [];

        foreach (json_decode($response->content) as $movie) {
            $schedules[] = $movie;
        }

        return $schedules;
    }

    /**
     * Метод возвращает детальную информацию по id фильма | не используется
     * @param MovieIdRequest $request
     * @return mixed
     */
    public function getMovieDetail(MovieIdRequest $request)
    {
        $key = config('app.key_kinoafisha');
        if ($key === null) {
            return response()->json(['error' => 404, 'message' => 'Ключ не задан'], 404);
        }
        $url = 'https://api.kinoafisha.info/export/movie?movie_id=' . $request->movie_id . "&api_key=$key";

        $response = Curl::to($url);

        // если нужен прокси
        if (config('app.proxy')) {
            $response = $response->withProxy(config('app.proxy_url'), config('app.proxy_port'), config('app.proxy_type'), config('app.proxy_username'), config('app.proxy_password'));
        }

        $response = $response->returnResponseObject()->get();

        if ($response->status !== 200) {
            return response()->json(['error' => $response->status, 'content' => $response->content], $response->status);
        }

        $schedules = [];

        foreach (json_decode($response->content) as $movie) {
            $schedules[] = $movie;
        }

        return $schedules;
    }
}
