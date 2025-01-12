<?php

namespace App\Controllers;

use App\Core\Classes\Discussion;
use App\Models\DiscussionModel;
use core\Controller;

class DiscussionController extends Controller
{
    private $discussionModel;

    /**
     * @throws \Exception
     */
    public function __construct(){
        $this->discussionModel = $this->model("DiscussionModel");
    }

    public function createDiscussion(){

        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $discussion = new Discussion(
            $this->requestInput('title'),
            $this->requestInput('description'),
            $this->getSession('user_name')
        );

        $result = $this->discussionModel->createDiscussion($discussion);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Discussion Created Successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
        exit;
    }

    public function getDiscussion(){
        $result = $this->discussionModel->getDiscussion();
        if($result !== null){
            $organizedData = [];
            foreach ($result as $row) {
                $id = $row['id'];
                if (!isset($organizedData[$id])) {
                    $organizedData[$id] = [
                        'id' => $row['id'],
                        'title' => $row['title'],
                        'description' => $row['description'],
                        'author' => $row['author'],
                        'replies' => []
                    ];
                }
                $organizedData[$id]['replies'][] = [
                    'replier' => $row['replier'],
                    'reply' => $row['reply']
                ];
            }

            $finalArray = array_values($organizedData);
            echo json_encode(['success' => true, 'data' => $finalArray]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
        exit;
    }

    public function getDiscussionReplies(){
        $result = $this->discussionModel->getDiscussionReplies();
        if($result !== null){
            echo json_encode(['success' => true, 'data' => $result]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
    }
    public function replyOnDiscussion(){
        $data = $this->getRequest('POST');

        if (empty($data)) {
            return;
        }

        $tempObject = new \stdClass();
        $tempObject->discussion_id = $this->requestInput('discussion_id');
        $tempObject->replier = $this->getSession('user_name');
        $tempObject->reply = $this->requestInput('reply');

        $result = $this->discussionModel->replyOnDiscussion($tempObject);

        if($result){
            echo json_encode(['success' => true, 'message' => 'Discussion Replied Successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
        exit;
    }

    public function deleteDiscussion($id, $type){
        $result = $this->discussionModel->deleteDiscussion($id, $type);
        if($result){
            echo json_encode(['success' => true, 'message' => 'Discussion / Reply Deleted Successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Something went wrong']);
        }
    }
}