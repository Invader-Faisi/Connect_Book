<?php

namespace App\Models;

use App\Core\Classes\Discussion;
use core\Model;

class DiscussionModel extends Model
{
    public function createDiscussion(Discussion $discussion){
        return $this->insertObject('discussion', $discussion);
    }

    public function getDiscussion(){
        return $this->selectFromMultipleTables(
            ['discussion','discussion_replies'],
            ['discussion.id = discussion_replies.discussion_id'],
            ['LEFT JOIN'],
            'discussion.id,discussion.title,discussion.description,discussion.author,            
            discussion_replies.replier,discussion_replies.reply');
    }

    public function getDiscussionReplies(){
        return $this->selectFromMultipleTables(
            ['discussion','discussion_replies'],
            ['discussion.id = discussion_replies.discussion_id'],
            ['LEFT JOIN'],
            'discussion.title,discussion_replies.replier,discussion_replies.reply,discussion_replies.id');
    }

    public function replyOnDiscussion(\stdClass  $reply){
        return $this->insertObject('discussion_replies', $reply);
    }

    public function deleteDiscussion($id, $type){
       return $this->deleteWhere($type,$id);
    }

}