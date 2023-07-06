<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class PaginationHelper
{
    public static function paginate($posts, $perPage = 30, $page = null, $options = []): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $posts->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $posts = new LengthAwarePaginator($pagedData, $posts->count(), $perPage, $currentPage);
        $posts->withPath(Request::url());
        return $posts;
    }
}
