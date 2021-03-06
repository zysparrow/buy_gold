<?php

namespace App\Http\Controllers\Czf;

use Illuminate\Http\Request;
use App\Good;
use App\News;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth','checkmbr']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Good $good)
    {
        $member = \Auth::user();
        $member_status = $member['status'];
        $aConfig = getConfigByType(1);
        $aGoods = $this->getGoodsLoic($good)->query(['_sort'=>'updated_at,desc']);
        $news=new news();
        $newslist = $news->where('type', 1)->orderBy('id', 'desc')->get();
        $member_count = $member->count() ?? 0;
        return view('czf.home',compact('aConfig','aGoods','newslist','member_status','member_count'));
    }

    /**
     * @param object $oModel
     */
    public function getGoodsLoic(object $oModel)
    {
        return new \App\Logics\GoodsLogic($oModel);
    }
}
