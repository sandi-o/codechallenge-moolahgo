<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *  check the ownership of the referral code submitted
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response json
     */
    public function process(Request $request) {

        $this->validateIncoming($request);

        $code = $request->referral_code;
        
        $refObj = array_filter($this->refCodes(), function ($k, $v) use($code) {
            return $k['referral_code'] == $code;
        },ARRAY_FILTER_USE_BOTH);
        
        if(!$refObj){
            return response()->json(['referral_code'=> array('Invalid Referral Code.')],422);
        }
        
        return response()->json(['referral_code'=>$refObj[0]['owner']],200);
    }

    /**
     * Array of Referral Codes
     */
    private function refCodes(){
        return [
            array("referral_code"=>"REF001","owner" => "Tito", "location" => "Singapore"),
            array("referral_code"=>"REF002","owner" => "Vic", "location" => "New Zealand"),
            array("referral_code"=>"REF003","owner" => "Joey", "location" => "Canada")
        ];
    }

    /**
     * Validation for incoming request (referral_code)
     */
    protected function validateIncoming($request) {
        return $this->validate($request,[
            'referral_code'=> ['required','alpha_num','string','size:6','regex:/^[A-Z0-9]+$/'],            
        ]);
    }
}
