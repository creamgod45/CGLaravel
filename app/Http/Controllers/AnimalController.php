<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $var = Animal::create($request->all());
        return response()->json(['message' => "Animal Added"], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        // 手动查找 Animal 模型实例
        $animal = Animal::find($id);

        // 检查是否找到实例
        if (!$animal) {
            // 如果没有找到，返回自定义错误消息
            return response()->json(['message' => 'Animal not found with ID ' . $id], ResponseAlias::HTTP_NOT_FOUND);
        }
        $animal->delete();
        return response()->json(['message' => "Animal Deleted"], ResponseAlias::HTTP_OK);
    }
}
