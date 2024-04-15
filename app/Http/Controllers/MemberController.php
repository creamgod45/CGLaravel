<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Utils\Utils;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 获取完整的 URL
        $url = $request->url();

        // 获取路径部分，即去除域名和协议部分
        $path = parse_url($url, PHP_URL_PATH);

        // 将路径分割成数组
        $pathParts = explode('/', $path);

        // 移除数组中的空元素
        $pathParts = array_filter($pathParts);
        $i18n=new I18N(Utils::default(ELanguageCode::valueof($pathParts[1]), ELanguageCode::en_US),
            limitMode: [
            ELanguageCode::zh_TW,
            ELanguageCode::zh_CN,
            ELanguageCode::en_US,
            ELanguageCode::en_GB
        ]);

        $members = Member::all();
        foreach ($members as $member) {
            echo $member->username;
        }
        return view('members', $this->baseGlobalVariable($request, ['members' => $members]));
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
    public function store(StoreMemberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
