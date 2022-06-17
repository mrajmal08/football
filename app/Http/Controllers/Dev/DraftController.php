<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    /**
     * Show the Draft.
     *
     * @return Response
     */
    public function showDraft()
    {
        return view('draft.index');
    }

    /**
     * Show the Draft Room.
     *
     * @return Response
     */
    public function showDraftRoom()
    {
        return view('draft.room');
    }

    /**
     * Show the Draft Prep.
     *
     * @return Response
     */
    public function showDraftPrep()
    {
        return view('draft.prep');
    }

    /**
     * Show the Draft Results.
     *
     * @return Response
     */
    public function showDraftResults()
    {
        return view('draft.results');
    }
}
