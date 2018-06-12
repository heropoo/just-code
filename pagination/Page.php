<?php

namespace Moon;

/**
 * 分页类
 * @author TTT
 * @date 2015-01-19
 * @lastModified 2018-06-12
 */
class Pagination
{
    protected $totalRows;   //总数据条数
    protected $pageSize;   //页大小
    protected $pageVar;   //分页中的get参数
    protected $page;        //当前页数
    protected $totalPage;   //总页数
    protected $url;        //当前页面地址
    protected $showPages;   //显示页数

    public function __construct($total, $pageSize = 10, $showPages = 5, $pageVar = 'page', $url = '')
    {
        $this->totalRows = $total;
        $this->pageSize = $pageSize;
        $this->showPages = $showPages;
        $this->pageVar = $pageVar;
        $this->page = !empty($_GET[$this->pageVar]) ? (int)$_GET[$this->pageVar] : 1;
        $this->totalPage = $this->totalPage();
        $this->url = empty($url) ? $this->getPageUrl() : $url;
    }

    protected function getPageUrl()
    {
        //获取当前页面地址
        $this->url = $_SERVER['PHP_SELF'];
//        if (!empty($_GET)) {                          //有get参数的情况
//            $this->url .= '?';
//            unset($_GET[$this->pageVar]);
//            foreach ($_GET as $k => $v) {
//                $this->url .= "$k=$v&";
//            }
//            $this->url .= "{$this->pageVar}=";
//        } else {                                      //无get参数的情况
//            $this->url .= "?{$this->pageVar}=";
//        }
        unset($_GET['page']);
        if (empty($_GET)) {
            $this->url .= "?{$this->pageVar}=";
        } else {
            $this->url = '?' . http_build_query($_GET);
            $this->url .= "&{$this->pageVar}=";
        }
        return $this->url;
    }

    /**
     * 获取总页数
     */
    public function totalPage()
    {
        return ceil($this->totalRows / $this->pageSize);
    }

    /**
     * 获取分页 offset 参数
     */
    public function getOffset()
    {
        return ($this->page - 1) * $this->pageSize;
    }

    /**
     * 获取分页 limit 参数
     */
    public function getLimit()
    {
        return $this->pageSize;
    }

    public function getLimitString()
    {
        return $this->getOffset() . ',' . $this->getLimit();
    }

    /**
     * 获取分页输出的HTML代码
     */
    public function getHtml()
    {
        $beforePage = (($this->page - 1) > 0) ? ($this->page - 1) : 1;   //上一页
        $nextPage = (($this->page + 1) < $this->totalPage) ? ($this->page + 1) : $this->totalPage; //下一页

        $pageHtml = '<div class="pagination">';
        $pageHtml .= '<span class="pageIndex">第' . $this->page . '/' . $this->totalPage . '页</span> ';
        $pageHtml .= '<span class="totalRows">共' . $this->totalRows . '条</span> ';
        if ($this->page <= 1) {
            $pageHtml .= '<span class="firstPage">首页</span> ';
        } else {
            $pageHtml .= '<a class="firstPage" href="' . $this->url . '">首页</a> ';
            $pageHtml .= '<a class="beforePage" href="' . $this->url . $beforePage . '"><<上一页</a> ';
        }

        $half = ceil($this->showPages);
        $left = $this->page - $half > 0 ? $this->page - $half : 0;
        $right = $this->page + $half < $this->totalPage ? $this->page + $half : $this->totalPage;

        if($left && ($this->page - $half) > 1){
            $pageHtml .= '<a class="pageItem" href="' . $this->url . '1">1</a> ';
            if($this->page - $half > 2){
                $pageHtml .= '<span>...</span> ';
            }
        }

        for ($i = 1; $i <= $this->totalPage; $i++) {
            if($i < $left){
                continue;
            }
            if($i > $right){
                continue;
            }

            if ($this->page == $i) {
                $pageHtml .= '<span class="currentPage">' . $i . '</span> ';
            } else {
                $pageHtml .= '<a class="pageItem" href="' . $this->url . $i . '">' . $i . '</a> ';
            }
        }

        if($right && ($this->page + $half) < $this->totalPage){
            if($this->page + $half + 1 < $this->totalPage){
                $pageHtml .= '<span>...</span> ';
            }
            $pageHtml .= '<a class="pageItem" href="' . $this->url .$this->totalPage.'">'.$this->totalPage.'</a> ';

        }

        if ($this->page == $this->totalPage) {
            $pageHtml .= '<span class="lastPage">末页</span>';
        } else {
            $pageHtml .= '<a class="nextPage" href="' . $this->url . $nextPage . '">下一页>></a> ';
            $pageHtml .= '<a class="lastPage" href="' . $this->url . $this->totalPage . '">末页</a>';
        }
        $pageHtml.= '</div>';
        return $pageHtml;
    }

    /**
     * 获取分页输出的HTML代码
     */
    public function getBootstrapHtml()
    {
        $beforePage = (($this->page - 1) > 0) ? ($this->page - 1) : 1;   //上一页
        $nextPage = (($this->page + 1) < $this->totalPage) ? ($this->page + 1) : $this->totalPage; //下一页

        $pageHtml = '<ul class="pagination">';
        if ($this->page == 1) {
            $pageHtml .= '<li class="disabled"><span>首页</span></li> ';
        } else {
            $pageHtml .= '<li><a href="' . $this->url . '">首页</a></li>';
            $pageHtml .= '<li><a href="' . $this->url . $beforePage . '"><<上一页</a></li> ';
        }

        $half = ceil($this->showPages);
        $left = $this->page - $half > 0 ? $this->page - $half : 0;
        $right = $this->page + $half < $this->totalPage ? $this->page + $half : $this->totalPage;

        if($left && ($this->page - $half) > 1){
            $pageHtml .= '<li><a href="' . $this->url . '1">1</a></li> ';
            if($this->page - $half > 2){
                $pageHtml .= '<li class="disabled"><span>...</span></li> ';
            }
        }

        for ($i = 1; $i <= $this->totalPage; $i++) {
            if($i < $left){
                continue;
            }
            if($i > $right){
                continue;
            }

            if ($this->page == $i) {
                $pageHtml .= '<li class="active"><span>' . $i . '</span></li> ';
            } else {
                $pageHtml .= '<li><a href="' . $this->url . $i . '">' . $i . '</a></li> ';
            }
        }

        if($right && ($this->page + $half) < $this->totalPage){
            if($this->page + $half + 1 < $this->totalPage){
                $pageHtml .= '<li><span>...</span></li> ';
            }
            $pageHtml .= '<li><a class="pageItem" href="' . $this->url .$this->totalPage.'">'.$this->totalPage.'</a></li> ';

        }

        if ($this->page == $this->totalPage) {
            $pageHtml .= '<li class="disabled"><span>末页</span></li>';
        } else {
            $pageHtml .= '<li><a class="nextPage" href="' . $this->url . $nextPage . '">下一页>></a></li> ';
            $pageHtml .= '<li><a class="lastPage" href="' . $this->url . $this->totalPage . '">末页</a></li>';
        }
        $pageHtml.= '</ul>';
        return $pageHtml;
    }
}
/**
 * 使用方法
 * $page = new Page($user_total,10);
 * //limit 条件
 * $startLimit = $page->getStartLimit();
 * $endLimit = $page->getEndLimit();
 * //输出的html
 * $html = $page->getHtml();
 */