<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToDoListResource;
use App\Models\ActivityLog;
use App\Models\ToDoList;
use App\Models\ToDoListCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ToDoListController extends Controller
{
    public function store(Request $request): JsonResponse
    {

        //Ip Restriction
        if ($request->ip() === '192.168.0.179') {
            return response()->json(['error' => 'Access from this IP address is not allowed'], 403);
        }


        //Validation
        $request->validate([
            'name' => 'required|string',
            'category_name' => 'required|string'
        ]);


        //Saving ToDoList
        $todolist = new ToDoList();
        $todolist->name = $request->name;
        $todolist->category_name = $request->category_name;
        $todolist->save();


        //Storing Activity Log
        $activity_log = new ActivityLog();
        $activity_log->log_name = "Added ToDoList" . $todolist->name;
        $activity_log->causer_ip_address = $request->ip();
        $activity_log->save();

        return response()->json($todolist);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(): AnonymousResourceCollection
    {
        //Ip Restriction
        if (request()->ip() === '192.168.0.179') {
            throw new \Illuminate\Auth\Access\AuthorizationException('Access from this IP address is not allowed');
        }

        $todolist = ToDoList::query()->get();
        $todolist = $todolist->sortBy('category_name');

        // Group the collection by the category_name
        $todolist = $todolist->groupBy('category_name');

        $activity_log = new ActivityLog();
        $activity_log->log_name = "Viewed ToDoList";
        $activity_log->causer_ip_address = request()->ip();
        $activity_log->save();

        // Transform each group into a resource collection
        $todolist = $todolist->map(function ($group) {
            return ToDoListResource::collection($group);
        });

        return new AnonymousResourceCollection($todolist);
    }

    public function update(Request $request, $id): JsonResponse
    {
        //This ip is actually the ip of the server
        if ($request->ip() === '192.168.0.179') {
            return response()->json(['error' => 'Access from this IP address is not allowed'], 403);
        }

        //Validation
        $request->validate([
            'name' => 'required|string',
            'category_name' => 'required|string'
        ]);

        //Updating ToDoList
        $todolist = ToDoList::query()->findOrFail($id);
        $todolist->name = $request->name;
        $todolist->category_name = $request->category_name;
        $todolist->save();

        //Storing Activity Log
        $activity_log = new ActivityLog();
        $activity_log->log_name = "Updated ToDoList" . $todolist->name;
        $activity_log->causer_ip_address = $request->ip();
        $activity_log->save();

        return response()->json($todolist);
    }



    public function delete($id, Request $request): JsonResponse
    {
        //IP Restriction
        if ($request->ip() === '192.168.0.179') {
            return response()->json(['error' => 'Access from this IP address is not allowed'], 403);
        }

        //Deleting ToDoList
        $todolist = ToDoList::query()->findOrFail($id);
        $todolist->delete();

        //Storing Activity Log
        $activity_log = new ActivityLog();
        $activity_log->log_name = "Deleted ToDoList" . $todolist->name;
        $activity_log->causer_ip_address = request()->ip();
        $activity_log->save();

        return response()->json('ToDoList deleted');
    }




}
