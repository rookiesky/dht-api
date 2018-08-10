<?php
/**
 * File name:HashController.php
 * User: rookie
 * Url : PTP5.Com
 * Date: 2018/8/9
 * Time: 19:16
 */

namespace App\Api\Controllers;


use App\Hash;
use Illuminate\Http\Request;


class HashController extends BaseController
{
    /**
     * 搜索
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(Request $request)
    {
        $keyword = $request->get('keyword');
        //页码
        $limit = $request->get('limit') ?? 1;
        //每页显示条数
        $page = $request->get('page') ?? 20;
        //排序内容
        $orderType = $request->get('orderby') ?? 'id';

        $type = ['length','id','requests'];

        if( !in_array($orderType,$type) ){
            $orderType = 'id';
        }

        $data = Hash::search($keyword)->orderBy($orderType,'desc')->paginate($page,'',$limit);

        return $data;
    }

    /**
     * 查询指定hash
     * @param $hash
     * @return \Illuminate\Http\JsonResponse
     */
    public function find($hash)
    {
        if(empty($hash)){
            return $this->errorMsg('hash is empty');
        }

        $info = Hash::where('info_hash',$hash)->first();

        if(empty($info)){
            return $this->errorMsg('data empty');
        }
        $info->file_list = $info->fileList;

        if($info->file_list['file_list']) {
            $info->file_list['file_list'] = json_decode($info->file_list['file_list'], true);
        }

            return $info;
    }

    /**
     * 返回错误信息
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorMsg($message)
    {
        return response()->json(['error' => $message], 401);
    }

    /**
     *  统计总和
     * @return mixed
     */
    public function getTotal()
    {
        return Hash::count();
    }
    
}

