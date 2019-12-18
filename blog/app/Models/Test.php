<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// php artisan make:migration create_test_table --create=test
// php artisan migrate
class Test extends Model
{
    public $table = "test";
    public $text;
    protected $fillable = ['text', 'is_enabled'];

//    protected $casts = [
//        'is_enabled' => 'boolean',
//    ];

//    public static function searchTestMaxID()
//    {
//        $testId = Test::orderBy('id', 'desc')->first();
//        $test = Test::where('id', $testId)->update(['text' => 'So what about pepito?', 'is_enabled' => 1]);
//        return $testId;
//    }
//
//    public static function insertTestInt($id)
//    {
//        $test = Test::where('id', $id)->get();
//        if (!$test) {
//            return response()->json($test);
//        } else {
//            return null;
//        }
//        return null;
//    }
//
//    public static function insertStringData($text)
//    {
//        $test = Test::where('text', $text)->get();
//        if (!$test) {
//            return collect($test);
//        } else {
//            return null;
//        }
//        return null;
//    }
}
