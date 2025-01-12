<?php

namespace App\Models;

use App\Core\Classes\News;
use core\Model;

class NewsModel extends Model
{
    public function getAllNews(){
        return $this->selectAll('news');
    }
    public function addNews(News $news, $id = ''){
        if($id == ''){
            return $this->insertObject('news',$news);
        }else{
            return $this->updateObject('news',$news,$id);
        }

    }

    public function getNewsById($id){
        return $this->selectWhere("news", ['id' => $id]);
    }

    public function deleteNews($id){
        return $this->deleteWhere("news", $id);
    }
}