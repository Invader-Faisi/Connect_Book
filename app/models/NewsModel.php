<?php

namespace App\Models;

use App\Core\Classes\News;
use core\Model;

class NewsModel extends Model
{
    public function getAllNews(){
        return $this->selectAll('news');
    }
    public function addNews(News $news){
        return $this->insertObject('news', $news);
    }
}