<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $data = Message::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'phone' => $query->phone,
                    'subject' => $query->subject,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('messages-show')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.messages.show' , ['message' => $row['id']]).'" style="margin-left:5px;">عرض</button>';
                        }
                    }
                    if ($user->can('messages-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.messages.destroy' , ['message' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.messages.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.messages.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.messages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('admin.pages.messages.edit' ,compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Message $message
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $message = Message::withTrashed()->find($id);
        $message->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Message $message
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $message = Message::withTrashed()->find($id);
        $message->forceDelete();

        return redirect()->back();
    }

}
