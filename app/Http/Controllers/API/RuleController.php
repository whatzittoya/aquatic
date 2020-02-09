<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Rule::get();

        return response()->json($rules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = new Rule;
        $rule->name = $request->name;
        $rule->min_age = $request->min_age;
        $rule->max_age = $request->max_age;
        $rule->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function show(Rule $rule)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->data;

        $rule = Rule::find($id);
        $rule->name = $data['name'];
        $rule->min_age = $data['min_age'];
        $rule->max_age = $data['max_age'];
        $rule->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $rule = Rule::find($id);
        $rule->delete();
        return 204;
    }
}
