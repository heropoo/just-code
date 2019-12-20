<?php
/**
 * Date: 2019-12-20
 * Time: 16:03
 */

namespace App\Controllers;

use App\Container;
use App\Models\Board;

class IndexController extends BaseController
{
    const ZSETS_NAME = 'board_zsets';

    /**
     * 主页
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * 创建页面
     */
    public function create()
    {
        return $this->render('create');
    }

    public function boardList()
    {
        $page = $_GET['page'] ?? 1;
        if ($page <= 0) {
            return $this->json(['code' => 400, 'msg' => '已是第一页了']);
        }

        $page_size = 2;

        /** @var \Redis $redis */
        $redis = Container::get('redis');

        $total = $redis->zCard(self::ZSETS_NAME);

        $total_page = ceil($total / $page_size);
        if ($page > $total_page) {
            return $this->json(['code' => 400, 'msg' => '已是最后一页了']);
        }

        $start = ($page - 1) * $page_size;
        $end = $start + $page_size - 1;

        $list = $redis->zRevRange(self::ZSETS_NAME, $start, $end);
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                $list[$key] = json_decode($item);
            }
        }

        return $this->json([
            'code' => 0,
            'msg' => 'ok',
            'data' => [
                'page'=> $page,
                'total' => $total,
                'list' => $list
            ]
        ]);
    }

    /**
     * 保存
     */
    public function save()
    {
        $model = new Board();
        $model->subject = $_POST['subject'];
        $model->author = $_POST['author'];
        $model->body = $_POST['body'];
        $model->ip = $_SERVER['REMOTE_ADDR'];
        $model->idate = date('Y-m-d H:i:s');
        $model->ndate = date('Y-m-d H:i:s');

        $res = $model->save();
        if ($res) {
            $this->saveToRedis($model);
            return $this->json(['code' => 0, 'msg' => 'ok']);
        } else {
            return $this->json(['code' => 500, 'msg' => '发表失败']);
        }
    }

    /**
     * 保存到redis zset中
     * @param Board $model
     * @return int
     * @throws \App\Exception
     */
    protected function saveToRedis(Board $model)
    {
        /** @var \Redis $redis */
        $redis = Container::get('redis');
        $id = $model->id;

        return $redis->zAdd(self::ZSETS_NAME, $id, json_encode($model));
    }

    /**
     * 从redis中删除
     * @param $id
     * @return int
     * @throws \App\Exception
     */
    protected function deleteFromRedis($id)
    {
        /** @var \Redis $redis */
        $redis = Container::get('redis');
        return $redis->zRemRangeByScore(self::ZSETS_NAME, $id, $id);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = $_POST['id'];
        $res = Board::getDb()->delete(Board::tableName(), 'id=?', [$id]);
        if ($res) {
            $this->deleteFromRedis($id);
            return $this->json(['code' => 0, 'msg' => 'ok']);
        } else {
            return $this->json(['code' => 500, 'msg' => '删除失败']);
        }
    }
}