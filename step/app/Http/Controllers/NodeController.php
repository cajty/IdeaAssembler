<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function index()
    {
        $nodes = Node::all();
        return response()->json($nodes);
    }

    public function show($id)
    {
        $node = Node::find($id);
        return response()->json($node);
    }

    public function store(Request $request)
    {
        $node = Node::create($request->all());
        return response()->json($node, 201);
    }

    public function update(Request $request, $id)
    {
        $node = Node::find($id);
        $node->update($request->all());
        return response()->json($node);
    }

    public function destroy($id)
    {
        Node::destroy($id);
        return response()->json(null, 204);
    }
}