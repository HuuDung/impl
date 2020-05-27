<?php

namespace App\Http\Controllers;

use App\Models\Fork;
use App\Models\GithubHelper;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $helper = new GithubHelper();
        $response = $helper->ownedRepo(auth()->user()->access_token);
        $data = [
            'datas' => $response,
        ];
        return view('repo.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::where('github_id', $id)->first();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get(Request $request)
    {
        $params = $request->all();
        $params["key"] = empty($params["key"]) ? '' : $params["key"];
        $count = empty($params["count"]) ? 0 : (int)$params["count"];
        $helper = new GithubHelper();
        $user = $helper->getProfileFromUsername($params["key"]);
        $response = $helper->getRepoFromUsername($params["key"], $params["page"], GithubHelper::PERPAGE);
        $count += count($response);
        $data = [
            'datas' => $response,
            'perPage' => GithubHelper::PERPAGE,
        ];
        $html = view('repo.list', $data)->render();
        return json_encode([
            'html' => $html,
            'success' => true,
            'username' => $params["key"],
            'max' => $user["public_repos"],
            'count' => $count,
        ]);
    }

    public function save(Request $request, $id)
    {
        if (!Fork::where('user_id', $id)->where('repo_name', $request->name)->first()) {
            $fork = new Fork();
            $fork->fill([
                'user_id' => $id,
                'html_url' => $request->html_url,
                'repo_name' => $request->name,
                'status' => Fork::NO_CLONE,
                'owner' => $request->owner,
            ]);
            $fork->save();
            return redirect()->route('repo.save-list');
        }
    }

    public function listSaved()
    {
        $data = [
            'forks' => auth()->user()->forks,
        ];
        return view('repo.fork', $data);
    }

    public function fork($id)
    {
        $fork = Fork::findOrFail($id);
        $fork->update([
            'status' => Fork::PENDING,
        ]);
        $helper = new GithubHelper();
        $helper->postForkRepo('PhamAnhHoang', 'ITSS-pink', auth()->user()->access_token);
        return redirect()->back();
    }
}
