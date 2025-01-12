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

    public function addNews($id = ''){
        $news = new News($this->requestInput('title'), $this->requestInput('description'));

        if($id != ''){
            $result = $this->newsModel->addNews($news, $id);
        }else{
            $result = $this->newsModel->addNews($news);
        }


        if($result){
            echo json_encode(['success'=>true,'message'=>'News added successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'Something went wrong']);
        }
        exit;
    }

    public function deleteNews($id){
        $result = $this->newsModel->deleteNews($id);
        if($result){
            echo json_encode(['success'=>true,'message'=>'News deleted successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'Something went wrong']);
        }
        exit;
    }

    public function getNewsById($id){
        $result = $this->newsModel->getNewsById($id);
        if($result != null){
            echo json_encode(['success'=>true,'data'=>$result]);
        }else{
            echo json_encode(['success'=>false]);
        }
        exit;
    }
}