<?php

namespace App\Controllers;

use App\Core\Classes\News;
use core\Controller;

class NewsController extends Controller
{
    private $newsModel;

    /**
     * @throws \Exception
     */
    public function __construct(){
        $this->newsModel = $this->model('NewsModel');
    }

    public function getAllNews(){
        $result = $this->newsModel->getAllNews();
        if($result != null){
            echo json_encode(['success'=>true,'data'=>$result]);
        }else{
            echo json_encode(['success'=>false]);
        }
        exit;
    }

    public function addNews(){
        $news = new News($this->requestInput('title'), $this->requestInput('description'));
        $result = $this->newsModel->addNews($news);
        if($result){
            echo json_encode(['success'=>true,'message'=>'News added successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'Something went wrong']);
        }
        exit;
    }
}